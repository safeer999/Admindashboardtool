<?php
namespace App\Jobs;
use App\Models\BulkVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\BulkVerificationResult;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProcessEmailVerification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;

    public function __construct(BulkVerification $task)
    {
        $this->task = $task;
    }

    public function handle()
    {
        // Update task status to processing and set started_at
        $this->task->update(['status' => 'processing', 'started_at' => now()]);

        $filePath = Storage::path($this->task->stored_file_path);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        $emails = [];

        try {
            if (in_array($extension, ['csv', 'txt'])) {
                $file = new \SplFileObject($filePath);
                $file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY | \SplFileObject::READ_AHEAD);

                // Skip header if present
                if (!$file->eof()) {
                    $firstLine = $file->current();
                    if (!empty($firstLine) && is_array($firstLine) && (count($firstLine) > 1 || !empty(trim($firstLine[0])))) {
                        $file->next();
                    } else {
                        $file->rewind();
                    }
                }

                foreach ($file as $row) {
                    if (is_array($row) && isset($row[0]) && !empty(trim($row[0]))) {
                        $emails[] = trim($row[0]);
                    }
                }
            } elseif (in_array($extension, ['xlsx', 'xls'])) {
                $spreadsheet = IOFactory::load($filePath);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
                foreach ($rows as $index => $row) {
                    if ($index === 0) continue; // Skip header
                    if (isset($row[0]) && !empty(trim($row[0]))) {
                        $emails[] = trim($row[0]);
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error("Failed to read file for task ID {$this->task->id}: " . $e->getMessage());
            $this->task->update(['status' => 'failed', 'completed_at' => now()]);
            return;
        }

        $totalEmails = count($emails);
        $processedEmails = 0;

        $counts = [
            '✅ Safe' => 0, '❌ Invalid' => 0, '🔥 Disposable' => 0,
            '👥 Role-based' => 0, '⚠️ Spam Trap' => 0, '📥 Inbox Full' => 0,
            '🚫 Disabled' => 0, '❓ Unknown' => 0, '🟠 Catch-All' => 0, '🚫 Undeliverable' => 0, '🚫 Connection Failed' => 0, '❌ No MX' => 0, '🚫 SMTP Fail' => 0, '✅ Not Catch-All' => 0
        ];

        // Ensure these files exist or handle their absence
        $disposableDomains = [];
        if (Storage::exists('app/disposableDomains.json')) {
            $disposableDomains = json_decode(file_get_contents(storage_path('app/disposableDomains.json')), true);
        } else {
            \Log::warning("disposableDomains.json not found in storage/app.");
        }

        $spamTraps = [];
        $spamTrapDomains = [];
        if (Storage::exists('app/spamTrapsList.json')) {
            $spamTraps = json_decode(file_get_contents(storage_path('app/spamTrapsList.json')), true);
            $spamTrapDomains = array_keys($spamTraps['domains'] ?? []);
        } else {
            \Log::warning("spamTrapsList.json not found in storage/app.");
        }


        foreach ($emails as $email) {
            $domain = substr(strrchr($email, "@"), 1);
            $username = strstr($email, '@', true);

            $syntax = $this->isValidSyntax($email) ? 'Valid' : 'Invalid';
            $disposable = in_array($domain, $disposableDomains) ? 'Yes' : 'No';
            $roleBased = $this->isRoleBased($username) ? 'Yes' : 'No';
            $spamTrap = in_array($email, $spamTrapDomains) ? 'Yes' : 'No';

            // Perform SMTP and SSL checks only if syntax is valid to avoid unnecessary network calls
            $smtp = 'N/A';
            $ssl = 'N/A';

            if ($syntax === 'Valid') {
                $smtp = $this->verifySMTP($email);
                $ssl = $this->isSslEnabled($domain) ? 'Secure' : 'Insecure';
            }


            // Determine Catch-All only if SMTP result is not immediately conclusive of undeliverability
            $catchAll = 'N/A';
            if ($syntax === 'Valid' && ($smtp === '📥 Deliverable' || $smtp === '❓ Unknown')) {
                $catchAll = $this->checkCatchAll($domain);
            }


            $overallStatus = $this->determineOverallStatus($syntax, $spamTrap, $disposable, $roleBased, $smtp, $catchAll);
            $counts[$overallStatus]++;

            // Create a new record in bulk_verification_results table
            BulkVerificationResult::create([
                'bulk_verification_task_id' => $this->task->id,
                'email' => $email,
                'overall_status' => $overallStatus,
                'syntax' => $syntax,
                'role_based' => $roleBased,
                'catch_all' => $catchAll,
                'disposable' => $disposable,
                'spam_trap' => $spamTrap,
                'smtp' => $smtp,
                'ssl' => $ssl,
            ]);

            $processedEmails++;
            $progress = ($totalEmails > 0) ? round(($processedEmails / $totalEmails) * 100) : 0;
            $this->task->update(['progress' => $progress]);
        }

        // After processing all emails, update the main task
        $this->task->update([
            'status' => 'completed',
            'progress' => 100,
            'summary_counts' => json_encode($counts), // Store the summary counts
            'completed_at' => now(),
            // No need for result_file_path if storing directly in the DB
        ]);

        // Delete the original uploaded file after processing if it's no longer needed
        Storage::delete($this->task->stored_file_path);
    }

    // Your helper methods (isValidSyntax, isRoleBased, isSslEnabled, verifySMTP, checkCatchAll, determineOverallStatus)
    // Make sure these methods are correctly defined within this class.
    // They are already present in your provided job code, just ensure they are `private` or `protected`.

    private function isValidSyntax($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email);
    }

    private function isRoleBased($username)
    {
        $roleBasedList = [
            'admin', 'abuse', 'accounting', 'billing', 'business',
            'compliance', 'contact', 'devnull', 'editor', 'errors',
            'feedback', 'finance', 'hostmaster', 'hr', 'info',
            'inquiries', 'inquiry', 'jobs', 'legal', 'mail',
            'marketing', 'media', 'news', 'noc', 'noreply',
            'office', 'orders', 'postmaster', 'press', 'privacy',
            'registrar', 'recruit', 'recruitment', 'returns', 'root',
            'sales', 'security', 'service', 'services', 'shipping',
            'smtp', 'spam', 'staff', 'subscribe', 'support',
            'sysadmin', 'tech', 'technical', 'unsubscribe', 'usenet',
            'uucp', 'webmaster', 'www', 'hello'
        ];
        return in_array(strtolower($username), $roleBasedList);
    }

    private function isSslEnabled($domain)
    {
        // Increased timeout for SSL connection
        $stream = @stream_context_create(["ssl" => ["capture_peer_cert" => true, "verify_peer" => false, "verify_peer_name" => false]]);
        $socket = @stream_socket_client("ssl://{$domain}:443", $errno, $errstr, 5, STREAM_CLIENT_CONNECT, $stream);
        if ($socket) {
            fclose($socket);
            return true;
        }
        return false;
    }

    private function verifySMTP($email)
    {
        $ports = [25, 587, 465]; // Add common SMTP ports for better success rate
        $domain = substr(strrchr($email, "@"), 1);
        $from = 'noreply@yourdomain.com'; // Use a valid sender email for your application

        // Get MX records
        if (!getmxrr($domain, $mxhosts) || empty($mxhosts)) {
            return '❓ Unknown';
        }

        // Sort MX records by preference (lower is preferred)
        $mx_records_with_pref = [];
        getmxrr($domain, $mxhosts, $mxweights);
        foreach ($mxhosts as $i => $host) {
            $mx_records_with_pref[$host] = $mxweights[$i];
        }
        asort($mx_records_with_pref);
        $mxhosts = array_keys($mx_records_with_pref);


        $fp = null;
        foreach ($mxhosts as $mxhost) {
            foreach ($ports as $port) {
                $fp = @fsockopen($mxhost, $port, $errno, $errstr, 5); // Increased timeout
                if ($fp) {
                    break 2; // Break both loops if connection is successful
                }
            }
        }

        if (!$fp) {
            return '🚫 Connection Failed';
        }

        stream_set_timeout($fp, 10); // Increased timeout for SMTP communication

        $safeRead = function () use ($fp) {
            $line = fgets($fp, 1024);
            if ($line === false) return false;
            return trim($line);
        };

        $safeWrite = function ($cmd) use ($fp) {
            $written = fwrite($fp, $cmd . "\r\n");
            if ($written === false || feof($fp)) {
                throw new \Exception("Failed to write command: $cmd");
            }
            return $written;
        };

        try {
            $response = $safeRead();
            if (!$response || stripos($response, '220') === false) {
                throw new \Exception("No 220 greeting from server or initial response is not 220.");
            }

            $safeWrite("HELO " . gethostname()); // Use actual hostname
            $safeRead(); // Read HELO response

            $safeWrite("MAIL FROM:<$from>");
            $mailResponse = $safeRead();
            if (stripos($mailResponse, '250') === false) {
                // Some servers reject MAIL FROM if not valid, but still accept RCPT TO for validation
                // Continue to RCPT TO, but note this potential issue.
            }

            $safeWrite("RCPT TO:<$email>");
            $rcptResponse = $safeRead();

            $safeWrite("QUIT");
            fclose($fp);

            if (stripos($rcptResponse, '250') !== false) {
                return '📥 Deliverable';
            } elseif (stripos($rcptResponse, '550') !== false) {
                return '🚫 Undeliverable';
            } elseif (stripos($rcptResponse, '552') !== false) {
                return '📥 Inbox Full';
            } else {
                return '❓ Unknown';
            }

        } catch (\Exception $e) {
            if (is_resource($fp)) {
                fclose($fp);
            }
            \Log::error("SMTP error for {$email}: " . $e->getMessage());
            return '❓ Unknown';
        }
    }


    private function checkCatchAll($domain)
    {
        $ports = [25, 587, 465];
        $fakeEmail = 'randomfakeuser12345@' . $domain;
        $from = 'noreply@yourdomain.com'; // Use a valid sender email for your application

        $mxhosts = [];
        if (!getmxrr($domain, $mxhosts) || empty($mxhosts)) {
            return '❌ No MX';
        }

        // Sort MX records by preference
        $mx_records_with_pref = [];
        getmxrr($domain, $mxhosts, $mxweights);
        foreach ($mxhosts as $i => $host) {
            $mx_records_with_pref[$host] = $mxweights[$i];
        }
        asort($mx_records_with_pref);
        $mxhosts = array_keys($mx_records_with_pref);

        $fp = null;
        foreach ($mxhosts as $mxhost) {
            foreach ($ports as $port) {
                $fp = @fsockopen($mxhost, $port, $errno, $errstr, 5); // Increased timeout
                if ($fp) {
                    break 2;
                }
            }
        }

        if (!$fp) {
            return '🚫 SMTP Fail';
        }

        stream_set_timeout($fp, 10);

        $safeRead = function () use ($fp) {
            $line = fgets($fp, 1024);
            if ($line === false) return false;
            return trim($line);
        };

        $safeWrite = function ($cmd) use ($fp) {
            $result = @fwrite($fp, $cmd . "\r\n");
            if ($result === false || feof($fp)) {
                throw new \Exception("fwrite failed on: $cmd");
            }
            return $result;
        };

        try {
            $safeRead(); // Read initial 220 greeting
            $safeWrite("HELO " . gethostname());
            $safeRead(); // Read HELO response

            $safeWrite("MAIL FROM:<$from>");
            $safeRead(); // Read MAIL FROM response

            $safeWrite("RCPT TO:<$fakeEmail>");
            $rcptResponse = $safeRead();

            $safeWrite("QUIT");
            fclose($fp);

            if (stripos($rcptResponse, "250") !== false) {
                return '🟠 Catch-All';
            } elseif (stripos($rcptResponse, "550") !== false) {
                return '✅ Not Catch-All';
            } else {
                return '❓ Unknown';
            }

        } catch (\Exception $e) {
            if (is_resource($fp)) {
                fclose($fp);
            }
            \Log::error("Catch-All error for {$domain}: " . $e->getMessage());
            return '❓ Unknown';
        }
    }

    private function determineOverallStatus($syntax, $spamTrap, $disposable, $roleBased, $smtp, $catchAll)
    {
        if ($syntax === 'Invalid') {
            return '❌ Invalid';
        } elseif ($spamTrap === 'Yes') {
            return '⚠️ Spam Trap';
        } elseif ($disposable === 'Yes') {
            return '🔥 Disposable';
        } elseif ($roleBased === 'Yes') {
            return '👥 Role-based';
        } elseif ($smtp === '🚫 Disabled') {
            return '🚫 Disabled';
        } elseif ($smtp === '📥 Inbox Full') {
            return '📥 Inbox Full';
        } elseif ($smtp === '🚫 Undeliverable') {
            return '🚫 Undeliverable';
        } elseif ($smtp === '❓ Unknown' || $smtp === '🚫 Connection Failed' || $smtp === '❌ No MX') {
            return '❓ Unknown';
        } elseif ($catchAll === '🟠 Catch-All') {
            return '🟠 Catch-All';
        } elseif ($smtp === '📥 Deliverable') {
            return '✅ Safe';
        }

        return '❓ Unknown'; // Fallback for any unhandled cases
    }
}
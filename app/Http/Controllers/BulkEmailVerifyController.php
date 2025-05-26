<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\BulkVerification;
use App\Jobs\ProcessEmailVerification;
use SplFileObject;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BulkEmailVerifyController extends Controller
{
    public function index()
    {
        $user=Auth::user();

       $task = BulkVerification::where('user_id', $user->id)
                                    ->orderByDesc('created_at')
                                    ->get();
        return view('emailverify.bulktask',compact('task'));
    }
    public function handleUploadAndVerify(Request $request)
    {
        $request->validate([
            'email_csv' => [
                'required',
                'file',
                'mimes:csv,txt,xlsx,xls',
                'max:20480',
            ],
        ]);

        $user = Auth::user();
        if (!$user) {
            return back()->withErrors(['auth' => 'You must be logged in to perform this action.']);
        }

        $file = $request->file('email_csv');
        $originalFileName = $file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension();

        $uniqueFileName = Str::random(40) . '.' . $fileExtension;
        $userStoragePath = 'users/' . $user->id . '/uploads';

        try {
            $storedFilePath = Storage::putFileAs($userStoragePath, $file, $uniqueFileName);
            if (!$storedFilePath) {
                throw new \Exception("Failed to store the uploaded file.");
            }
        } catch (\Exception $e) {
            return back()->withErrors(['email_csv' => 'There was an error storing the file. Please try again.']);
        }

        $totalEmails = 0;
        try {
            $filePath = Storage::path($storedFilePath);
            if (in_array($fileExtension, ['csv', 'txt'])) {
                $fileObject = new SplFileObject($filePath, 'r');
                $fileObject->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::READ_AHEAD); // Added READ_AHEAD for robustness
                $fileObject->rewind();

                // Check if file is not empty and attempt to skip header if it exists
                // This assumes the first line is always a header. Adjust if not.
                if (!$fileObject->eof()) {
                    $firstLine = $fileObject->current();
                    // If you're certain of a header, you might consume it here.
                    // For simply counting, just advance the pointer.
                    if (!empty($firstLine) && is_array($firstLine) && (count($firstLine) > 1 || !empty(trim($firstLine[0])))) {
                        // This indicates a possible header line or first data line.
                        // For pure counting, just move to the next line.
                        $fileObject->next();
                    } else {
                        // If the first line was effectively empty or not an array, rewind to process it as data
                        $fileObject->rewind();
                    }
                }


                foreach ($fileObject as $row) {
                    // Crucial: Check if $row is an array before processing
                    if (is_array($row) && !empty(array_filter($row)) && isset($row[0]) && !empty(trim($row[0]))) {
                        $totalEmails++;
                    }
                }
            } elseif (in_array($fileExtension, ['xlsx', 'xls'])) {
                $spreadsheet = IOFactory::load($filePath);
                $worksheet = $spreadsheet->getActiveSheet();
                // Get highest row, then subtract 1 for the header row
                $totalEmails = $worksheet->getHighestDataRow('A') - 1; // getHighestDataRow is more accurate for data
                if ($totalEmails < 0) $totalEmails = 0;
            }
        } catch (\Exception $e) {
            \Log::error("Error counting emails in file {$storedFilePath}: " . $e->getMessage()); // Log the error for debugging
            $totalEmails = 0; // Default to 0 if counting fails to prevent bad data
        }

        $taskUuid = (string) Str::uuid();
        $taskName = $this->generateRandomTaskName($originalFileName);

        $task = BulkVerification::create([
            'user_id' => $user->id,
            'task_name' => $taskUuid,
            'task_name' => $taskName,
            'original_file_name' => $originalFileName,
            'stored_file_path' => $storedFilePath,
            'total_emails' => $totalEmails,
            'status' => 'pending',
            'progress' => 0,
        ]);

      
        // Dispatch the job to the queue
        ProcessEmailVerification::dispatch($task);

        return redirect()->route('bulk.index')->with('success', 'Your bulk verification task has been submitted successfully! It will be processed in the background.');
    }

    private function generateRandomTaskName(string $originalFileName): string
    {
        $adjectives = ['New', 'Recent', 'Automated', 'Quick', 'Scheduled', 'Important', 'Fresh', 'Daily'];
        $verbs = ['Verification', 'Check', 'Scan', 'Audit', 'Process', 'Run'];
        $randomAdjective = $adjectives[array_rand($adjectives)];
        $randomVerb = $verbs[array_rand($verbs)];
        $timestamp = now()->format('M d, H:i');

        return "{$randomAdjective} {$randomVerb} - {$originalFileName} ({$timestamp})";
    }
     public function getTaskProgress(BulkVerification $task)
    {
        // Optional: Add authorization check if needed
         if (Auth::id() !== $task->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
         }

        return response()->json([
            'id' => $task->id,
            'status' => $task->status,
            'progress' => $task->progress,
            'summary_counts' => $task->summary_counts, // Include summary if you want to display it live
        ]);
    }

    // ... (other methods) ...
}
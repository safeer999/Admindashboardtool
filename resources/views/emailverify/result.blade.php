@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Email Verification Results - Task {{ $execution['random'] ?? '' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .donut-chart-inner {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: "Inter", sans-serif;
            font-weight: 500;
            color: #333;
            font-size: 14px;
            user-select: none;
            pointer-events: none;
        }
        .donut-chart-inner .value {
            font-size: 24px;
            font-weight: 700;
        }
        .clickable { cursor: pointer; }
        .chart-container {
            position: relative;
            width: 200px;
            height: 200px;
        }
        /* No min-card-height needed here */
    </style>
</head>
<body class="bg-[#f9fbfc] min-h-screen p-4 font-sans">

    <div class="max-w-screen-xl mx-auto p-4">

        {{-- Removed items-start from here --}}
        <div class="flex flex-col lg:flex-row gap-6 w-full">

            {{-- Left card: Results Analysis --}}
            {{-- Removed min-card-height from here --}}
            <div class="bg-white rounded-xl shadow-md w-full lg:w-1/2 p-6 text-center select-none flex flex-col" style="font-family: 'Inter', sans-serif">
                <h2 class="text-gray-600 text-lg font-normal mb-4">
                    Task: {{ $fileName ?? 'Email List' }}
                </h2>

                <div class="border-t border-b border-gray-300 py-4 grid grid-cols-2 text-left text-gray-700 text-sm font-normal">
                    <div class="space-y-1">
                        <p><span class="font-semibold">Task ID:</span> <span class="inline-block bg-gray-400 rounded px-2 py-0.5 ml-1 select-text">{{ $execution['random'] ?? 'N/A' }}</span></p>
                        <p><span class="font-semibold">Status:</span> {{ $execution['status'] ?? 'N/A' }}</p>
                        <p>
                            <span class="font-semibold">Progress:</span>
                            {{ number_format(array_sum($summary ?? [])) }}/{{ $execution['total_emails'] ?? array_sum($summary ?? []) }}
                            ({{ ($execution['total_emails'] > 0) ? round((array_sum($summary ?? []) / $execution['total_emails']) * 100, 2) : 0 }}%)
                        </p>
                    </div>
                    <div class="space-y-1">
                        <p><span class="font-semibold">Started:</span> {{ $execution['start_time'] ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Finished:</span> {{ $execution['end_time'] ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Runtime:</span> {{ $execution['duration_seconds'] ?? 'N/A' }} seconds</p>
                    </div>
                </div>

                <h3 class="text-gray-600 text-base font-normal mt-6 mb-4">Results Analysis</h3>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-6 flex-grow">
                    <div class="chart-container">
                        <canvas id="myChartJsDonut"></canvas>
                        <div class="donut-chart-inner" id="donutInner">
                            <span class="text-xs text-gray-600" id="donutLabel">Total</span>
                            <span class="value" id="donutValue">{{ number_format(array_sum($summary ?? [])) }}</span>
                        </div>
                    </div>
                    <ul class="text-left text-sm font-normal space-y-1 max-w-xs">
                        @php
                            $colors = [
                                '✅ Safe' => '#6b9e4a',
                                '👥 Role-based' => '#b1aa3a',
                                '🟠 Catch-All' => '#fbb615',
                                '🔥 Disposable' => '#f9a01b',
                                '📥 Inbox Full' => '#f15a22',
                                '⚠️ Spam Trap' => '#f15a22',
                                '🚫 Disabled' => '#e02a2a',
                                '❌ Invalid' => '#e02a2a',
                                '❓ Unknown' => '#b0b0b0',
                                '🚫 Undeliverable' => '#b0b0b0',
                            ];
                        @endphp
                        @foreach (($summary ?? []) as $label => $count)
                            <li class="flex items-center gap-2 clickable" style="color: {{ $colors[$label] ?? '#000' }}" data-label-raw="{{ $label }}">
                                <span class="w-4 h-4 rounded-sm block" style="background-color: {{ $colors[$label] ?? '#000' }}"></span>
                                {{ str_replace(['✅ ', '❌ ', '🔥 ', '👥 ', '⚠️ ', '📥 ', '🚫 ', '❓ ', '🟠 ', '📦 '], '', $label) }}: {{ number_format($count) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Right card: Download Categorized Results --}}
            {{-- Removed min-card-height from here --}}
            <div class="bg-white rounded-xl shadow-md w-full lg:w-1/2 p-6 text-center flex flex-col">
                <div class="flex justify-center items-center mb-6 mt-10">
                    <i class="fas fa-cloud-download-alt text-gray-700 text-[100px]"></i>
                </div>
                <h1 class="text-gray-700 text-lg font-semibold mb-4">Download Categorized Results</h1>

                <select id="categorySelect" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-4">
                    <option value="all">All - Include all type of results</option>
                    <option value="safe">Safe</option>
                    <option value="rolebased">Role-based</option>
                    <option value="catchall">Catch-all</option>
                    <option value="disposable">Disposable</option>
                    <option value="inboxfull">Inbox Full</option>
                    <option value="spamtrap">Spam Trap</option>
                    <option value="disabled">Disabled</option>
                    <option value="invalid">Invalid</option>
                    <option value="unknown">Unknown</option>
                    <option value="undeliverable">Undeliverable</option>
                </select>

                {{-- Added mt-auto here to push buttons to the bottom --}}
                <div class="flex justify-center gap-4 mt-auto">
                    <button id="downloadCSV" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900 transition">Download CSV</button>
                    <button id="downloadXLSX" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900 transition">Download XLSX</button>
                </div>
            </div>
        </div>
    </div> <script>
        const summaryData = @json($summary ?? []);
        const colorMapping = @json($colors ?? []);
        const allEmailData = @json($data ?? []);

        const totalEmails = Object.values(summaryData).reduce((a, b) => a + b, 0);

        const chartLabels = Object.keys(summaryData);
        const chartValues = Object.values(summaryData);
        const chartBackgroundColors = chartLabels.map(label => colorMapping[label] || '#cccccc');

        const donutLabelEl = document.getElementById("donutLabel");
        const donutValueEl = document.getElementById("donutValue");

        const ctx = document.getElementById('myChartJsDonut');
        if (ctx) {
            const myDonutChart = new Chart(ctx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: chartLabels.map(label => label.replace(/^[✅❌🔥👥⚠️📥🚫❓🟠📦]\s*/, '')),
                    datasets: [{
                        label: 'Email Status',
                        data: chartValues,
                        backgroundColor: chartBackgroundColors,
                        borderColor: '#ffffff',
                        borderWidth: 4,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '50%',
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += context.parsed.toLocaleString();
                                    }
                                    const originalLabel = chartLabels[context.dataIndex];
                                    const percentage = ((context.parsed / totalEmails) * 100).toFixed(1);
                                    return `${originalLabel}: ${context.parsed.toLocaleString()} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        document.querySelectorAll('li.clickable').forEach((item) => {
            item.addEventListener('click', () => {
                const labelText = item.innerText.split(':')[0].trim();
                const valueText = item.innerText.split(':')[1].trim();

                if (donutLabelEl) donutLabelEl.innerText = labelText;
                if (donutValueEl) donutValueEl.innerText = valueText;
            });
        });

        function normalizeStatus(text) {
            if (!text) return "";
            return text.replace(/[\u{1F600}-\u{1F64F}\u{1F300}-\u{1F5FF}\u{1F680}-\u{1F6FF}\u{1F1E0}-\u{1F1FF}\u{2600}-\u{26FF}\u{2700}-\u{27BF}\u{FE0F}]/gu, '')
                       .replace(/\s+/g, '')
                       .toLowerCase()
                       .replace(/-/g, '');
        }

        function filterDataByCategory(category) {
            if (category === "all") return allEmailData;

            const normCategory = category.toLowerCase().replace(/\s+/g, '').replace(/-/g, '');

            return allEmailData.filter(item => {
                const itemStatus = item.status;
                const normStatus = normalizeStatus(itemStatus);
                return normStatus === normCategory;
            });
        }

        const downloadCSVButton = document.getElementById("downloadCSV");
        if (downloadCSVButton) {
            downloadCSVButton.addEventListener("click", () => {
                const selectedCategory = document.getElementById("categorySelect").value;
                const filteredEmails = filterDataByCategory(selectedCategory);

                if (!filteredEmails || filteredEmails.length === 0) {
                    alert("No data found for the category: " + selectedCategory);
                    return;
                }

                let csv = Object.keys(filteredEmails[0]).join(",") + "\n";
                filteredEmails.forEach(row => {
                    csv += Object.values(row).map(value => `"${String(value).replace(/"/g, '""')}"`).join(",") + "\n";
                });

                const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
                const url = URL.createObjectURL(blob);
                const link = document.createElement("a");
                link.setAttribute("href", url);
                link.setAttribute("download", `emails_${selectedCategory}.csv`);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        }

        const downloadXLSXButton = document.getElementById("downloadXLSX");
        if (downloadXLSXButton) {
            downloadXLSXButton.addEventListener("click", () => {
                const selectedCategory = document.getElementById("categorySelect").value;
                const filteredEmails = filterDataByCategory(selectedCategory);

                if (!filteredEmails || filteredEmails.length === 0) {
                    alert("No data found for the category: " + selectedCategory);
                    return;
                }

                const ws = XLSX.utils.json_to_sheet(filteredEmails);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "FilteredEmails");
                XLSX.writeFile(wb, `emails_${selectedCategory}.xlsx`);
            });
        }
    </script>

</body>
</html>

@endsection
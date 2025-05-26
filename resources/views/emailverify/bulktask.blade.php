@extends('layouts.app')
@section('content')

<div id="content" class="app-content">
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Tables</a></li>
        <li class="breadcrumb-item active">Managed Tables</li>
    </ol>
    <h1 class="page-header">Managed Tables <small>header small text goes here...</small></h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Data Table - Default</h4>
            <div class="panel-heading-btn"></div>
        </div>
        <div class="panel-body">
            <table id="data-table-default" width="100%" class="table table-striped table-bordered align-middle text-nowrap">
                <thead>
                    <tr>
                        <th width="1%">Id</th>
                        <th class="text-nowrap">Task Name</th>
                        <th class="text-nowrap">Task Date</th>
                        <th class="text-nowrap">Emails</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-nowrap">Expiry Date</th>
                        <th class="text-nowrap">Progress</th>
                        <th class="text-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($task as $index => $taskItem) {{-- Important: Use a different variable name like $taskItem --}}
                        <tr class="odd gradeX" id="task-row-{{ $taskItem->id }}">
                            <td width="1%" class="fw-bold">{{ $index + 1 }}</td>
                            <td>{{ $taskItem->task_name }}</td>
                            <td>{{ $taskItem->created_at->format('M d, Y H:i') }}</td>
                            <td>{{ $taskItem->total_emails }}</td>
                            <td id="task-status-{{ $taskItem->id }}">{{ $taskItem->status }}</td>
                            <td>{{ $taskItem->created_at->addDays(7)->format('M d, Y H:i') }}</td> {{-- Example: Assuming 7 days expiry from creation --}}
                            <td id="task-progress-{{ $taskItem->id }}">
                                <div class="progress">
                                    <div class="progress-bar {{ ($taskItem->status === 'processing' || $taskItem->status === 'pending') ? 'progress-bar-striped progress-bar-animated' : '' }}"
                                         role="progressbar"
                                         style="width: {{ $taskItem->progress }}%;"
                                         aria-valuenow="{{ $taskItem->progress }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                        {{ $taskItem->progress }}%
                                    </div>
                                </div>
                            </td>
                            <td id="task-action-{{ $taskItem->id }}">
                                @if($taskItem->status === 'completed')
                                    <a href="" class="btn btn-info">View Results</a>
                                @else
                                    <button class="btn btn-secondary" disabled>Processing...</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>

{{-- THIS IS THE CRUCIAL JAVASCRIPT FOR LIVE UPDATES --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Collect initial task data for tasks that might still be processing
        const activeTasks = [];
        @foreach ($task as $taskItem)
            @if ($taskItem->status === 'pending' || $taskItem->status === 'processing')
                activeTasks.push({ id: {{ $taskItem->id }}, status: '{{ $taskItem->status }}' });
            @endif
        @endforeach

        function updateTaskProgress() {
            if (activeTasks.length === 0) {
                console.log('No active tasks, stopping polling.');
                clearInterval(pollInterval); // Stop the interval if no tasks are active
                return;
            }

            // Create a copy of activeTasks to iterate over, as we might modify the original
            [...activeTasks].forEach((task, index) => {
                // Check if the task is still in the activeTasks array before fetching
                // This handles cases where a task might complete right before the next fetch
                const currentTaskIndex = activeTasks.findIndex(at => at.id === task.id);
                if (currentTaskIndex === -1) {
                    return; // Task already completed and removed, skip it
                }

                fetch(`{{ url('/bulk-verification') }}/${task.id}/progress`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        const progressBarContainer = document.getElementById(`task-progress-${data.id}`);
                        const progressBarDiv = progressBarContainer ? progressBarContainer.querySelector('.progress-bar') : null;
                        const statusTd = document.getElementById(`task-status-${data.id}`);
                        const actionTd = document.getElementById(`task-action-${data.id}`);

                        if (progressBarDiv) {
                            progressBarDiv.style.width = data.progress + '%';
                            progressBarDiv.setAttribute('aria-valuenow', data.progress);
                            progressBarDiv.textContent = data.progress + '%';

                            // Update progress bar animation based on status
                            if (data.status === 'processing') {
                                progressBarDiv.classList.add('progress-bar-animated', 'progress-bar-striped');
                            } else {
                                progressBarDiv.classList.remove('progress-bar-animated', 'progress-bar-striped');
                            }
                        }

                        if (statusTd) {
                            statusTd.textContent = data.status;
                        }

                        // If the task is completed or failed, update action button and remove from activeTasks
                        if (data.status === 'completed' || data.status === 'failed') {
                            if (actionTd) {
                                if (data.status === 'completed') {
                                    actionTd.innerHTML = `<a href="{{ url('/bulk-verification') }}/${data.id}/results" class="btn btn-info">View Results</a>`;
                                } else { // failed
                                    actionTd.innerHTML = `<span class="text-danger">Failed</span>`;
                                }
                            }
                            // Remove from the array of active tasks so we don't keep polling it
                            const removeIndex = activeTasks.findIndex(at => at.id === data.id);
                            if (removeIndex > -1) {
                                activeTasks.splice(removeIndex, 1);
                            }
                        }
                    })
                    .catch(error => {
                        console.error(`Error fetching task progress for ID ${task.id}:`, error);
                    });
            });
        }

        // Poll every 3 seconds (adjust as needed, consider server load)
        const pollInterval = setInterval(updateTaskProgress, 3000); // 3000 milliseconds = 3 seconds

        // Initial update when the page loads
        updateTaskProgress();
    });
</script>
@endpush
@endsection
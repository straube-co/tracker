<div class="pl-2 pb-2">
    <table>
        <h5 class="mt-3">Total of hours per Activity</h5>
        <tbody>
            @foreach ($summary as $activity_id => $interval)
                <tr>
                    <th>{{ $activities->find($activity_id)->name }}</th>
                    <td>-</td>
                    <td><samp>{{ App\Support\Formatter::intervalTime($interval) }}</samp></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<table class="table">
    <thead>
        <tr>
            <th class="align-middle">Project</th>
            <th class="align-middle">Task</th>
            <th class="align-middle">Activity</th>
            <th class="align-middle">User</th>
            <th class="align-middle">Started</th>
            <th class="align-middle">Finished</th>
            <th class="align-middle text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($times as $time)
            <tr>
                <td class="align-middle">{{ $time->task->project->name }}</td>
                <td class="align-middle">{{ $time->task->name }}</td>
                <td class="align-middle">{{ $time->activity->name }}</td>
                <td class="align-middle">{{ $time->user->name }}</td>
                <td class="align-middle"><samp>{{ $time->started }}</samp></td>
                <td class="align-middle"><samp>{{ $time->finished }}</samp></td>
                <td class="align-middle text-right"><samp>{{ $time->finished ? App\Support\Formatter::intervalTime($time->finished->diffAsCarbonInterval($time->started)) : '-' }}</samp></td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $times->links() }}

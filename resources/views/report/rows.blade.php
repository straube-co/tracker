<h5 class="mt-3">Activity summary</h5>
<dl>
    @foreach ($summary as $activity_id => $interval)
        <dt>{{ $activities->find($activity_id)->name }}</dt>
        <dd><samp>{{ App\Support\Formatter::intervalTime($interval) }}</samp></dd>
    @endforeach
</dl>

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

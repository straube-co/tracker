@extends('layouts.header')

@section('content')

<h1>Share Name: {{ $report->name }}</h1>

<table class="table pt-3">
    <thead>
        <tr>
            <th>Project</th>
            <th>Task</th>
            <th>Activity</th>
            <th>User</th>
            <th>Started</th>
            <th>Finished</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($times as $time)
            <tr>
                <td>{{ $time->task->project->name }}</td>
                <td>{{ $time->task->name }}</td>
                <td>{{ $time->activity->name }}</td>
                <td>{{ $time->user->name }}</td>
                <td>{{ $time->started }}</td>
                <td>{{ $time->finished }}</td>
            </tr>
        @endforeach
        </tbody>
</table>
{{ $times->links() }}
@endsection

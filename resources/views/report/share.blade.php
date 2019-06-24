@extends('layouts.header')
@section('content')
<h1 class="mt-4 mb-4">Share Name: {{ $report->name }}</h1>
<div class="pl-2 pb-2">
    <table>
        <h5 class="mt-3">Total of hours per Activity</h5>
        <tbody>
            @foreach ($grouped as $activity_id => $interval)
                <tr>
                    <th>{{App\Activity::find($activity_id)->name}} - </th>
                    <td>{{App\Support\Formatter::intervalTime($interval)}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<table class="table">
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

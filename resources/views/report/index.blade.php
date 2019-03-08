@extends('layouts.header')

@section('content')
<div class="container">
    <form action="{{ route('report.index') }}" method="get">
        <div>
            <label for="project">Project: </label>
            <select id="project" name="project_id">
                <option value="">Select</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}" @if ($project->id == request('project_id')) selected @endif>{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <label for="task">Task: </label>
            <select id="task" name="task_id">
                <option value="">Select</option>
                @foreach ($tasks as $task)
                    <option value="{{ $task->id }}" @if ($task->id == request('task_id')) selected @endif>{{ $task->name }}</option>
                @endforeach
            </select>
            {{ $errors->first('task_id') }}
        </div>
        <br>
        <div>
            <label for="user">User: </label>
            <select id="user" name="user_id">
                <option value="">Select</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @if ($user->id == request('user_id')) selected @endif>{{ $user->name }}</option>
                @endforeach
            </select>
            {{ $errors->first('name') }}
        </div>
        <br>
        <div>
            <label for="activity">Activity: </label>
            <select id="activity" name="activity_id">
                <option value="">Select</option>
                @foreach ($activities as $activity)
                    <option value="{{ $activity->id }}" @if ($activity->id == request('activity_id')) selected @endif>{{ $activity->name }}</option>
                @endforeach
            </select>
            {{ $errors->first('name') }}
        </div>
        <br>
        <div>
            <label for="started">Initial date:</label>
            <input id="started" name="started" type="text" value="{{ $started }}">
        </div>
        <br>
        <div>
            <label for="finished">Final date:</label>
            <input id="finished" name="finished" type="text" value="{{ $finished }}">
        </div>
        <br>
        <button class="btn btn-primary">Filter</button>
        <a href="{{ route('report.index') }}">Cancel</a>
    </form>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Projects</th>
                <th>Tasks</th>
                <th>Activities</th>
                <th>Started</th>
                <th>Finished</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($times as $time)
                <tr>
                    <td>{{ $time->user->name }}</td>
                    <td>{{ $time->task->project->name }}</td>
                    <td>{{ $time->task->name }}</td>
                    <td>{{ $time->activity->name }}</td>
                    <td>{{ $time->started }}</td>
                    <td>{{ $time->finished }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

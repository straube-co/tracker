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
                    <option value="{{ $task->id }}" data-project_id="{{ $task->project_id }}" @if ($task->id == request('task_id')) selected @endif>{{ $task->name }}</option>
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
        <label>I started my work: </label>
        <div class="form-group">
            <div class="input-group date" id="datepickerstarted" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" data-target="#datepickerstarted" name="started" value="{{ $started }}"/>
                <div class="input-group-append" data-target="#datepickerstarted" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            {{ $errors->first('started') }}
        </div>
        <label>I finished my work: </label>
        <div class="form-group">
            <div class="input-group date" id="datepickerfinished" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" data-target="#datepickerfinished" name="finished" value="{{ $finished }}"/>
                <div class="input-group-append" data-target="#datepickerfinished" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
        {{ $errors->first('finished') }}
        <br>
        <button class="btn btn-primary btn-sm" class="btn btn-primary">Filter</button>
        <a class="btn btn-outline-primary btn-sm" name="clean">Clean</a>
    </form>
    <br>
    <h1>Reports</h1>
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
    {{ $times->links() }}
</div>
@endsection

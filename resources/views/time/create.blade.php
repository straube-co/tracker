@extends('layouts.header')

@section('content')
<div class="container">
    <form action="{{ route('time.store') }}" method="post">
    {{ csrf_field() }}
        <div>
            <label for="project">Project: </label>
            <select id="project" name="project_id">
                <option value="">Select</option>
                @foreach ($projects as $project)
                <option value="{{ $project->id }}" @if ($project->id == old('project_id')) selected @endif>{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <label for="task">Task: </label>
            <select id="task" name="task_id">
                <option value="">Select</option>
                @foreach ($tasks as $task)
                <option value="{{ $task->id }}" data-project_id="{{ $task->project_id }}" @if ($task->id == old('task_id')) selected @endif>{{ $task->name }}</option>
                @endforeach
            </select>
            {{ $errors->first('task_id') }}
        </div>
        <br>
        <div>
            <label for="Activity">Activity: </label>
            <select id="Activity" name="activity_id">
                <option value="">Select</option>
                @foreach ($activities as $activity)
                <option value="{{ $activity->id }}" @if ($activity->id == old('activity_id')) selected @endif>{{ $activity->name }}</option>
                @endforeach
            </select>
            {{ $errors->first('name') }}
        </div>
        <br>
        <label>I started my work: </label>
        <div class="form-group">
            <div class="input-group date" id="datepickerstarted" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" data-target="#datepickerstarted" name="started"/>
                <div class="input-group-append" data-target="#datepickerstarted" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            {{ $errors->first('started') }}
        </div>
        <label>I finished my work: </label>
        <div class="form-group">
            <div class="input-group date" id="datepickerfinished" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" data-target="#datepickerfinished" name="finished"/>
                <div class="input-group-append" data-target="#datepickerfinished" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
        {{ $errors->first('finished') }}
        <br>
        <div>
            <button type="submit">Create </button>
            <a href="{{ route('time.index')}}">Cancel</a>
        </div>
    </form>
</div>
@endsection

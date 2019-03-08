@extends('layouts.header')

@section('content')
<div class="container">
    <form action="{{ route('time.update', $time->id )}}" method="post">
    {{ csrf_field() }}
    {{ method_field('put') }}
        <div>
            <label for="project">Project: </label>
            <select name="project_id">
                <option value="">Select</option>
                @foreach ($projects as $project)
                <option value="{{ $project->id }}" @if ($project->id == old('project_id', $time->task->project->id)) selected @endif> {{ $project->name }}</option>
                @endforeach
            </select>
            {{ $errors->first('project_id') }}
        </div>
        <br>
        <div>
            <label for="task">Task: </label>
            <select name="task_id">
                <option value="">Select</option>
                @foreach ($tasks as $task)
                <option value="{{ $task->id }}" data-project_id="{{ $task->project_id }}" @if ($task->id == old('task_id', $time->task_id)) selected @endif> {{ $task->name }}</option>
                @endforeach
            </select>
            {{ $errors->first('task_id') }}
        </div>
        <br>
        <div>
            <label for="activity">Activity: </label>
            <select name="activity_id">
                <option value="">Select</option>
                @foreach ($activities as $activity)
                <option value="{{ $activity->id }}" @if ($activity->id == old('activity_id', $time->activity_id)) selected @endif> {{ $activity->name }}</option>
                @endforeach
            </select>
            {{ $errors->first('activity_id') }}
        </div>
        <br>
        <div>
            <label>I started my work: </label>
            <input type="datetime" name="started" value="{{old('started', $time->started)}}">
            {{ $errors->first('started') }}
        </div>
        <br>
        <div>
            <label>I finished my work: </label>
            <input type="datetime" name="finished" value="{{old('finished', $time->finished)}}">
            {{ $errors->first('finished') }}
        </div>
        <br>
        <div>
            <button type="submit">Edit </button>
            <a href="{{ route('time.index')}}">Cancel</a>
        </div>
    </form>
</div>
@endsection

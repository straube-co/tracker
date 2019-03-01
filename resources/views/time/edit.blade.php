@extends('layouts.header')

@section('content')
<div class="container">
    <form action="{{ route('time.update', $time->id )}}" method="post">
    {{ csrf_field() }}
    {{ method_field('put') }}
        <div>
            <label for="project">Project: </label>
            <select name="project_id">
                @foreach ($projects as $project)
                <option value="{{ $project->id }}" @if ($project->id === $time->task->project->id) selected @endif> {{ $project->name }}</option>
                @endforeach
            </select>
            {{ $errors->first('project_id') }}
        </div>
        <br>
        <div>
            <label for="task">Task: </label>
            <select name="task_id">
                @foreach ($tasks as $task)
                <option value="{{ $task->id }}" @if ($task->id === $time->task_id) selected @endif> {{ $task->name }}</option>
                @endforeach
            </select>
            {{ $errors->first('task_id') }}
        </div>
        <br>
        <div>
            <label for="activity">Activity: </label>
            <select name="activity_id">
                @foreach ($activities as $activity)
                <option value="{{ $activity->id }}" @if ($activity->id === $time->activity_id) selected @endif> {{ $activity->name }}</option>
                @endforeach
            </select>
            {{ $errors->first('activity_id') }}
        </div>
        <br>
        <div>
            <label>I started my work: </label>
            <input type="datetime" name="started" value="{{ $time->started }}" required>
            {{ $errors->first('started') }}
        </div>
        <br>
        <div>
            <label>I finished my work: </label>
            <input type="datetime" name="finished" value="{{ $time->finished }}" required>
            {{ $errors->first('finished') }}
        </div>
        <br>
        <div>
            <button type="submit">Edit </button>
            <a type="button" href="{{ route('time.index')}}">Cancel</a>
        </div>
    </form>
</div>
@endsection

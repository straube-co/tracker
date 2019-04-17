@extends('layouts.header')

@section('content')
<div class="container">
    <form action="{{ route('auto.store') }}" method="post">
    {{ csrf_field() }}
        <div>
            <label for="project">Project: </label>
            <select id="project" name="project_id">
                <option value="">Select</option>
                @foreach ($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <label for="task">Task: </label>
            <select id="task" name="task_id">
                <option value="">Select</option>
                @foreach ($tasks as $task)
                <option value="{{ $task->id }}" data-project_id="{{ $task->project_id }}">{{ $task->name }}</option>
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
                <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                @endforeach
            </select>
            {{ $errors->first('name') }}
        <br>
        <br>
        <div>
            @if($notFinishedTime){{-- validation automatic time counting  --}}
                <p style="color:red">Stop your time for start automatic Time Counting</p>
            @else
                <button class="btn btn-success btn-sm" type="submit">Start </button>
            @endif
            <a class="btn btn-danger btn-sm" href="{{ route('time.index')}}">Cancel</a>
        </div>
    </form>
</div>
@endsection

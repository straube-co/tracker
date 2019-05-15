@extends('layouts.header')

@push('head')
    <script>
        var CURRENT_TIMESTAMP = Date.now();
    </script>
@endpush

@section('content')
    <h1 class="pt-3">Time Tracking</h1>
    <table class="table pt-3">
        <thead>
            <tr>
                <th>Project</th>
                <th>Total</th>
                <th class="stop_time">Start</th>
            </tr>
        </thead>
        <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->name }}</td>
                        <td>{{ ($total = $project->getTrackedTime()) ? App\Support\Formatter::interval($total) : '-' }}</td>
                        @if ($time = $project->getUnfinishedTime())
                            <td>
                                <form action="{{ route('auto.update', $time->id) }}" method="post" class="time-stop">
                                    @php
                                        $diff = App\Support\Formatter::interval($time->started->diffAsCarbonInterval());
                                    @endphp
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}
                                    <button
                                        type="submit"
                                        class="btn btn-outline-danger btn-sm"
                                        data-started="{{ $diff }}"
                                    >
                                        {{ $diff }}
                                    </button>
                                </form>
                            </td>
                        @else
                            @php
                                $showError = $project->id == old('project_id');
                            @endphp
                            <td class="time_stop">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#automatic-{{ $project->id }}">
                                    Let's work!
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="automatic-{{ $project->id }}" tabindex="-1" role="dialog" aria-labelledby="modalautomatic" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalautomatic">Start Automatic Time Counting</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('auto.store') }}" method="post">
                                                <div class="modal-body">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <label for="autoproject">Project: </label>
                                                        <select class="custom-select @if ($showError && $errors->has('project_id')) is-invalid @endif" id="autoproject" name="project_id">
                                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                                        </select>
                                                        @if ($showError)
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('project_id') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="autotask">Task: </label>
                                                        <select class="custom-select @if ($showError && $errors->has('task_id')) is-invalid @endif" id="autotask" name="task_id">
                                                            <option value="">Select</option>
                                                            @foreach ($tasks as $task)
                                                                @if($project->id === $task->project_id)
                                                                    <option value="{{ $task->id }}">{{ $task->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        @if ($showError)
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('task_id') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="autoactivity">Activity: </label>
                                                        <select class="custom-select @if ($showError && $errors->has('activity_id')) is-invalid @endif" id="autoactivity" name="activity_id">
                                                            <option value="">Select</option>
                                                            @foreach ($activities as $activity)
                                                                <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($showError)
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('activity_id') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-start">
                                                    <button type="submit" class="btn btn-outline-success btn-sm">Start</button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
        </tbody>
    </table>
@endsection

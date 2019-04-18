@extends('layouts.header')

@section('content')
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-outline-success btn-sm mr-2" data-toggle="modal" data-target="#manual">
        Add Manual Time Entry
    </button>
    <!-- Modal -->
    <div class="modal fade" id="manual" tabindex="-1" role="dialog" aria-labelledby="modalmanual" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalmanual">Add Manual Time Entry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('time.store') }}" method="post">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="project">Project: </label>
                            <select class="custom-select" id="project" name="project_id">
                                <option value="">Select</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}" @if ($project->id == old('project_id')) selected @endif>{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="task">Task: </label>
                            <select class="custom-select" id="task" name="task_id">
                                <option value="">Select</option>
                                @foreach ($tasks as $task)
                                    <option value="{{ $task->id }}" data-project_id="{{ $task->project_id }}" @if ($task->id == old('task_id')) selected @endif>{{ $task->name }}</option>
                                @endforeach
                            </select>
                            {{ $errors->first('task_id') }}
                        </div>
                        <div class="form-group">
                            <label for="Activity">Activity: </label>
                            <select class="custom-select" id="Activity" name="activity_id">
                                <option value="">Select</option>
                                @foreach ($activities as $activity)
                                    <option value="{{ $activity->id }}" @if ($activity->id == old('activity_id')) selected @endif>{{ $activity->name }}</option>
                                @endforeach
                            </select>
                            {{ $errors->first('name') }}
                        </div>
                        <div class="form-group">
                            <label>I started my work: </label>
                            <div class="input-group date" id="datepickerstarted" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#datepickerstarted" name="started"/>
                                <div class="input-group-append" data-target="#datepickerstarted" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            {{ $errors->first('started') }}
                        </div>
                        <div class="form-group">
                            <label>I finished my work: </label>
                            <div class="input-group date" id="datepickerfinished" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#datepickerfinished" name="finished"/>
                                <div class="input-group-append" data-target="#datepickerfinished" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        {{ $errors->first('finished') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success btn-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if($notFinishedTime){{-- validation automatic time counting  --}}
        <p class="pt-3" style="color:red">Stop your time for start automatic Time Counting</p>
    @else
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#automatic">
            Start Automatic Time Counting
        </button>
        <!-- Modal -->
        <div class="modal fade" id="automatic" tabindex="-1" role="dialog" aria-labelledby="modalautomatic" aria-hidden="true">
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
                                <select class="custom-select" id="autoproject" name="project_id">
                                    <option value="">Select</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="autotask">Task: </label>
                                <select class="custom-select" id="autotask" name="task_id">
                                    <option value="">Select</option>
                                    @foreach ($tasks as $task)
                                        <option value="{{ $task->id }}" data-project_id="{{ $task->project_id }}">{{ $task->name }}</option>
                                    @endforeach
                                </select>
                                {{ $errors->first('task_id') }}
                            </div>
                            <div class="form-group">
                                <label for="autoactivity">Activity: </label>
                                <select class="custom-select" id="autoactivity" name="activity_id">
                                    <option value="">Select</option>
                                    @foreach ($activities as $activity)
                                        <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                    @endforeach
                                </select>
                                {{ $errors->first('name') }}
                            </div>
                        </div>
                        <div class="modal-footer">
                            @if($notFinishedTime){{-- validation automatic time counting  --}}
                                <p style="color:red">Stop your time for start automatic Time Counting</p>
                            @else
                                <button type="submit" class="btn btn-success btn-sm">Start</button>
                            @endif
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    <h1 class="pt-3">Activities</h1>
    <table class="table pt-3">
        <thead>
            <tr>
                <th>Project</th>
                <th>Task</th>
                <th>Activity</th>
                <th>Started</th>
                <th>Finished</th>
                <th class="stop_time">Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($times as $time)
                <tr>
                    <td>{{ $time->task->project->name }}</td>
                    <td>{{ $time->task->name }}</td>
                    <td>{{ $time->activity->name }}</td>
                    <td>{{ $time->started }}</td>
                    <td>{{ $time->finished }}</td>
                    @if($time->finished == NULL)
                        <td>
                            <form action="{{ route('auto.update', $time->id) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('put') }}
                                <button type="submit" class="btn btn-outline-danger btn-sm" name="update_time">
                                    {{Carbon\Carbon::now()->diff($time->started)->format('%H:%I:%S')}}
                                </button>
                            </form>
                        </td>
                    @else
                        <td><a class="btn btn-secondary btn-sm" href="{{ route('time.edit', $time->id) }}">Edit</a></td>
                    @endif
                    <td>
                        <form action="{{ route('time.destroy', $time->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button class="btn btn-danger btn-sm" type="submit">Delete </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $times->links() }}
@endsection

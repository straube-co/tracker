@extends('layouts.app')

@section('content')
    <form id="form_action" action="{{ route('report.index') }}" method="get">
        <button
            class="btn btn-outline-dark btn-sm mr-1"
            type="button"
            data-toggle="collapse"
            data-target="#filter-advanced"
            aria-expanded="false"
        >
            Filter
        </button>
        <button type="button" id="btn_export" class="btn btn-outline-info btn-sm mr-1">Export CSV</button>
        <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#share">
            Save & Share
        </button>
        <div class="collapse" id="filter-advanced">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group pt-3">
                        <label for="project">Project:</label>
                        <select class="custom-select" id="project" name="project_id">
                            <option value="">Select</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" @if ($project->id == request('project_id')) selected @endif>{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group pt-3">
                        <label for="task">Task:</label>
                        <select class="custom-select" id="task" name="task_id">
                            <option value="">Select</option>
                            @foreach ($tasks as $task)
                                <option value="{{ $task->id }}" data-project_id="{{ $task->project_id }}" @if ($task->id == request('task_id')) selected @endif>{{ $task->name }}</option>
                            @endforeach
                        </select>
                        {{ $errors->first('task_id') }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group pt-3">
                        <label for="user">User:</label>
                        <select class="custom-select" id="user" name="user_id">
                            <option value="">Select</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @if ($user->id == request('user_id')) selected @endif>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group pt-3">
                        <label for="activity">Activity:</label>
                        <select class="custom-select" id="activity" name="activity_id">
                            <option value="">Select</option>
                            @foreach ($activities as $activity)
                                <option value="{{ $activity->id }}" @if ($activity->id == request('activity_id')) selected @endif>{{ $activity->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="pt-3 form-group">
                        <label>From:</label>
                        <div class="input-group date" id="datepickerstarted" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#datepickerstarted" name="started" value="{{ request('started') }}"/>
                            <div class="input-group-append" data-target="#datepickerstarted" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pt-3 form-group">
                        <label>To:</label>
                        <div class="input-group date" id="datepickerfinished" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#datepickerfinished" name="finished" value="{{ request('finished') }}"/>
                            <div class="input-group-append" data-target="#datepickerfinished" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-outline-secondary btn-sm">Apply</button>
            </div>
        </div>

        <div class="modal fade" id="share" tabindex="-1" role="dialog" aria-labelledby="modalShare" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalShare">Save & Share</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input class="form-control" type="text" name="name">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="button" id="btn_share" class="btn btn-outline-success btn-sm">Save</button>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <h1 class="mt-3">Reports</h1>

    @include('report.rows')
@endsection

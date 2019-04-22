@extends('layouts.header')

@section('content')
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-outline-info btn-sm mb-3 mr-2" data-toggle="modal" data-target="#import">
        Import
    </button>
    <!-- Modal import-->
    <div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="modalImport" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalImport">Import</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('import.store') }}" enctype="multipart/form-data" method="post">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="file" name="import_file"/>
                        </div>
                        <div class="form-group">
                            <label for="importproject">Project: </label>
                            <select class="custom-select" id="importproject" name="project_id">
                                <option value="">Select</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success btn-sm">Import file</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <button class="btn btn-outline-info btn-sm mb-3" type="button" data-toggle="collapse" data-target="#collapseReport" aria-expanded="false" aria-controls="collapseExample">
        Search filter
    </button>
    <form id="form_action" action="{{ route('report.index') }}" method="get">
    <div class="collapse" id="collapseReport">
            <div class="form-group pt-3">
                <label for="project">Project: </label>
                <select class="custom-select" id="project" name="project_id">
                    <option value="">Select</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" @if ($project->id == request('project_id')) selected @endif>{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group pt-3">
                <label for="task">Task: </label>
                <select class="custom-select" id="task" name="task_id">
                    <option value="">Select</option>
                    @foreach ($tasks as $task)
                        <option value="{{ $task->id }}" data-project_id="{{ $task->project_id }}" @if ($task->id == request('task_id')) selected @endif>{{ $task->name }}</option>
                    @endforeach
                </select>
                {{ $errors->first('task_id') }}
            </div>
            <div class="form-group pt-3">
                <label for="user">User: </label>
                <select class="custom-select" id="user" name="user_id">
                    <option value="">Select</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @if ($user->id == request('user_id')) selected @endif>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group pt-3">
                <label for="activity">Activity: </label>
                <select class="custom-select" id="activity" name="activity_id">
                    <option value="">Select</option>
                    @foreach ($activities as $activity)
                        <option value="{{ $activity->id }}" @if ($activity->id == request('activity_id')) selected @endif>{{ $activity->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="pt-3 form-group">
                <label>I started my work: </label>
                <div class="input-group date" id="datepickerstarted" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#datepickerstarted" name="started" value="{{ $started }}"/>
                    <div class="input-group-append" data-target="#datepickerstarted" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
            <div class="pt-3 form-group">
                <label>I finished my work: </label>
                <div class="input-group date" id="datepickerfinished" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#datepickerfinished" name="finished" value="{{ $finished }}"/>
                    <div class="input-group-append" data-target="#datepickerfinished" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            <button type="button" class="btn btn-outline-info btn-sm" name="clean">Clean</button>
        </form>
    </div>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#share">
              Share
            </button>
            <!-- Modal share -->
            <div class="modal fade" id="share" tabindex="-1" role="dialog" aria-labelledby="modalShare" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalShare">Share</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                      <div class="form-group">
                          <label for="name">Name: </label>
                          <input class="form-control" type="text" name="name" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="button" id="btn_share" class="btn btn-success btn-sm">Share</button>
                  </div>
                </div>
              </div>
            </div>
    <h1 class="mt-3">Reports</h1>
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
@endsection

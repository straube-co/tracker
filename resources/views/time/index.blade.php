@extends('layouts.app')

@push('head')
    <script>
        var CURRENT_TIMESTAMP = Date.now();
    </script>
@endpush

@section('content')
    <div class="container-fluid">
        <h3>Time Tracking</h3>
        <div class="d-flex align-items-center my-3 ml-3">
            {{-- Start time --}}
            <button type="button" class="btn btn-outline-success btn-sm lets">
                Let's work!
            </button>
            {{-- Add time manually button --}}
            <button type="button" class="btn btn-outline-success btn-sm mx-2" data-toggle="modal" data-target="#manual">
                Add time manually
            </button>
            @include("time.manually-modal")
             {{-- Create project button --}}
            <button type="button" class="btn btn-outline-primary btn-sm mr-2" data-toggle="modal" data-target="#createProjectModal">
              Create project
            </button>
            @include("time.project-modal")
        </div>
        <hr>
    </div>
    {{-- Search --}}
    <div class="container-fluid mb-4">
        <form id="form_action" action="{{ route('time.index') }}" method="get">
            <div class="row">
                @can('report')
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="user_id">User</label>
                            <select class="custom-select" id="user" name="user_id">
                                <option value="">Select</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @if ($user->id == request('user_id')) selected @endif>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endcan
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="project_id">Project</label>
                        <select class="custom-select" id="project" name="project_id">
                            <option value="">Select</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" @if ($project->id == request('project_id')) selected @endif>{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="task_id">Task</label>
                        <select class="custom-select select2" id="task" name="task_id">
                            <option value="">Select</option>
                            @foreach ($tasks as $task)
                                <option value="{{ $task->id }}" data-project_id="{{ $task->project_id }}" @if ($task->id == request('task_id')) selected @endif>{{ $task->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="activity_id">Activity</label>
                        <select class="custom-select" id="activity" name="activity_id">
                            <option value="">Select</option>
                            @foreach ($activities as $activity)
                                <option value="{{ $activity->id }}" @if ($activity->id == request('activity_id')) selected @endif>{{ $activity->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row align-items-baseline mt-2">
                <div class="col-md-3">
                    <div class="input-group date" id="datepickerstarted" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#datepickerstarted" name="started" value="{{ request('started') }}" placeholder="From"/>
                        <div class="input-group-append" data-target="#datepickerstarted" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group date" id="datepickerfinished" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#datepickerfinished" name="finished" value="{{ request('finished') }}" placeholder="To"/>
                        <div class="input-group-append" data-target="#datepickerfinished" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <button type="submit" class="btn btn-outline-secondary btn-sm">Apply</button>
                    <button type="button" id="btn_export" class="btn btn-outline-secondary btn-sm mx-1">Export CSV</button>
                    @can('report')
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#share">
                            Save & Share
                        </button>
                        @include("time.share-modal")
                    @endcan
                </div>
            </div>
        </form>
    </div>
     {{-- Table with projects --}}
     <div class="container-fluid">
        <table class="table table-hover pt-3">
            <thead>
                <tr>
                    <th class="align-top">User</th>
                    <th class="align-top">Task</th>
                    <th class="align-top">Started</th>
                    <th class="align-top">Finished</th>
                    <th class="align-top">Total</th>
                    <th class="align-top">Edit</th>
                    {{-- <th class="align-middle stop_time start">Start</th> --}}
                </tr>
            </thead>
                @foreach ($times as $time)
                    <tr>
                        <td class="align-top">{{ $time->user->name }}</td>
                        <td class="align-top">
                            <strong>{{ $time->task->project->name }}</strong> - {{ $time->task->name }}
                            <br>
                            <small class="text-muted">{{ $time->activity->name }}</small>
                        </td>
                        <td class="align-top"><samp>{{ $time->started }}</samp></td>
                        <td class="align-top"><samp>{{ $time->finished }}</samp></td>
                        <td class="align-top">
                            <samp>
                                {{ $time->finished ? App\Support\Formatter::intervalTime($time->finished->diffAsCarbonInterval($time->started)) : '-' }}
                            </samp>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-dark btn-sm mr-2" data-toggle="modal" data-target="#edit-{{ $time->id }}">Edit</button>
                            @include("time.manually-modal")
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $times->links() }}
    <div class="container-fluid pb-5">
        <hr>
        <h3>Activity summary</h3>
        <div class="row ml-2">
            @foreach ($summary as $activity_id => $interval)
                <div class="col-md-2">
                    <dt>{{ $activities->find($activity_id)->name }}</dt>
                    <dd><samp>{{ App\Support\Formatter::intervalTime($interval) }}</samp></dd>
                </div>
            @endforeach
        </div>
    </div>
@endsection

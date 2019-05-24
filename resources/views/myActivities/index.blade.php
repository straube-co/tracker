@extends('layouts.header')

@section('content')
    {{--  --}}
    @php
        $showError = "create" == old('time_id');
    @endphp
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#manual">
        Add Manual Time Entry
    </button>
    <!-- Modal addManual-->
    <div class="modal fade" id="manual" tabindex="-1" role="dialog" aria-labelledby="modalmanual" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalmanual">Add Manual Time Entry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('my.store') }}" method="post">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="project">Project: </label>
                            <select class="custom-select @if ($showError && $errors->has('project_id')) is-invalid @endif" id="project" name="project_id">
                                <option value="">Select</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}" @if ($project->id == old('project_id')) selected @endif>{{ $project->name }}</option>
                                @endforeach
                            </select>
                            @if ($showError)
                                <div class="invalid-feedback">
                                    {{ $errors->first('project_id') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="task">Task: </label>
                            <select class="custom-select @if ($showError && $errors->has('task_id')) is-invalid @endif" id="task" name="task_id">
                                <option value="">Select</option>
                                @foreach ($tasks as $task)
                                    <option value="{{ $task->id }}" data-project_id="{{ $task->project_id }}" @if ($task->id == old('task_id')) selected @endif>{{ $task->name }}</option>
                                @endforeach
                            </select>
                            @if ($showError)
                                <div class="invalid-feedback">
                                    {{ $errors->first('task_id') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="Activity">Activity: </label>
                            <select class="custom-select @if ($showError && $errors->has('activity_id')) is-invalid @endif" id="Activity" name="activity_id">
                                <option value="">Select</option>
                                @foreach ($activities as $activity)
                                    <option value="{{ $activity->id }}" @if ($activity->id == old('activity_id')) selected @endif>{{ $activity->name }}</option>
                                @endforeach
                            </select>
                            @if ($showError)
                                <div class="invalid-feedback">
                                    {{ $errors->first('activity_id') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="started">I started my work: </label>
                            <div class="input-group date" id="datepickerstarted" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input @if ($showError && $errors->has('started')) is-invalid @endif" data-target="#datepickerstarted" name="started" id="started"/>
                                <div class="input-group-append" data-target="#datepickerstarted" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @if ($showError)
                                    <div class="invalid-feedback">
                                        {{ $errors->first('started') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="finished">I finished my work: </label>
                            <div class="input-group date" id="datepickerfinished" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input @if ($showError && $errors->has('finished')) is-invalid @endif" data-target="#datepickerfinished" name="finished" id="finished"/>
                                <div class="input-group-append" data-target="#datepickerfinished" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @if ($showError)
                                    <div class="invalid-feedback">
                                        {{ $errors->first('finished') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        {{--  --}}
                        <input type="hidden" name="time_id" value="create">

                        <button type="submit" class="btn btn-outline-success btn-sm">Save</button>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <h1 class="pt-3">My Activities</h1>
    <table class="table pt-3">
        <thead>
            <tr>
                <th>Project</th>
                <th>Task</th>
                <th>Activity</th>
                <th>Started</th>
                <th>Finished</th>
                <th>Total</th>
                <th>Edit</th>
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
                    <td>{{ $time->finished ? App\Support\Formatter::intervalTime($time->finished->diffAsCarbonInterval($time->started)) : '-' }}</td>
                    {{--  --}}
                    @php
                        $showError = $time->id == old('time_id');
                    @endphp
                    <td>
                        <button type="button" class="btn btn-outline-dark btn-sm mr-2" data-toggle="modal" data-target="#edit-{{ $time->id }}">
                            Edit
                        </button>
                        {{--EDIT MODAL  --}}
                        <div class="modal fade" id="edit-{{ $time->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('my.update', $time->id )}}" method="post">
                                        <div class="modal-body">
                                            {{ csrf_field() }}
                                            {{ method_field('put') }}
                                            <div class="form-group">
                                                <label for="project">Project: </label>
                                                <select class="custom-select @if ($showError && $errors->has('project_id')) is-invalid @endif" name="project_id" id="project">
                                                    <option value="">Select</option>
                                                    @foreach ($projects as $project)
                                                        <option value="{{ $project->id }}" @if ($project->id == old('project_id', $time->task->project->id)) selected @endif> {{ $project->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($showError)
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('project_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="task">Task: </label>
                                                <select class="custom-select @if ($showError && $errors->has('task_id')) is-invalid @endif" name="task_id" id="task">
                                                    <option value="">Select</option>
                                                    @foreach ($tasks as $task)
                                                        <option value="{{ $task->id }}" data-project_id="{{ $task->project_id }}" @if ($task->id == old('task_id', $time->task_id)) selected @endif> {{ $task->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($showError)
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('task_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="activity">Activity: </label>
                                                <select class="custom-select @if ($showError && $errors->has('activity_id')) is-invalid @endif" name="activity_id" id="activity">
                                                    <option value="">Select</option>
                                                    @foreach ($activities as $activity)
                                                    <option value="{{ $activity->id }}" @if ($activity->id == old('activity_id', $time->activity_id)) selected @endif> {{ $activity->name }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($showError)
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('activity_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="started">I started my work: </label>
                                                <div class="input-group date" id="datepickerstarted" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input @if ($showError && $errors->has('started')) is-invalid @endif" data-target="#datepickerstarted" name="started" value="{{ old('started', $time->started) }}" id="started"/>
                                                    <div class="input-group-append" data-target="#datepickerstarted" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                    @if ($showError)
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('finished') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="finished">I finished my work: </label>
                                                <div class="input-group date" id="datepickerfinished" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input @if ($showError && $errors->has('finished')) is-invalid @endif" data-target="#datepickerfinished" name="finished" value="{{old('finished', $time->finished)}}" id="finished"/>
                                                    <div class="input-group-append" data-target="#datepickerfinished" data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                    </div>
                                                    @if ($showError)
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('finished') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-start">
                                            {{-- carregar os modais com erro com input // @if ($showError)  --}}
                                            <input type="hidden" name="time_id" value="{{ $time->id }}">

                                            <button class="btn btn-outline-success btn-sm" type="submit">Save </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
                                            <button class="btn btn-danger btn-sm ml-auto" type="button" onclick="$('#time_delete-{{ $time->id }}').submit()">Delete </button>
                                        </div>
                                    </form>
                                    <form action="{{ route('my.destroy', $time->id) }}" method="post" id="time_delete-{{ $time->id }}">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $times->links() }}
@endsection

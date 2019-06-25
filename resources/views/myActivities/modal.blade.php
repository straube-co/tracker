@php
    $id = $time->id ?? 0;
    $edit = $id > 0;
    $submitted = old('time_id') === 'time_' . $id;
    $old = $submitted ? old() : [];
    $default = $time ?? new App\Time();
@endphp
<div class="modal fade" id="{{ $edit ? 'edit-' . $id : 'manual' }}" tabindex="-1" role="dialog" aria-labelledby="modalmanual" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalmanual">@if ($edit) Edit Time @else Create Time @endif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ $edit ? route('my.update', $id) : route('my.store') }}" method="post">
                {{ csrf_field() }}
                @if ($edit)
                    {{ method_field('put') }}
                @endif
                <div class="modal-body">
                    <div class="form-group">
                        <label for="project">Project: </label>
                        <select class="custom-select @if ($submitted && $errors->has('project_id')) is-invalid @endif" id="project" name="project_id">
                            <option value="">Select</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" @if ($project->id == array_get($old, 'project_id', $default->task->project_id ?? null)) selected @endif>{{ $project->name }}</option>
                            @endforeach
                        </select>
                        @if ($submitted)
                            <div class="invalid-feedback">
                                {{ $errors->first('project_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="task">Task: </label>
                        <select class="custom-select @if ($submitted && $errors->has('task_id')) is-invalid @endif" id="task" name="task_id">
                            <option value="">Select</option>
                            @foreach ($tasks as $task)
                                <option value="{{ $task->id }}" data-project_id="{{ $task->project_id }}" @if ($task->id == array_get($old, 'task_id', $default->task_id)) selected @endif>{{ $task->name }}</option>
                            @endforeach
                        </select>
                        @if ($submitted)
                            <div class="invalid-feedback">
                                {{ $errors->first('task_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="Activity">Activity: </label>
                        <select class="custom-select @if ($submitted && $errors->has('activity_id')) is-invalid @endif" id="Activity" name="activity_id">
                            <option value="">Select</option>
                            @foreach ($activities as $activity)
                                <option value="{{ $activity->id }}" @if ($activity->id == array_get($old, 'activity_id', $default->activity_id)) selected @endif>{{ $activity->name }}</option>
                            @endforeach
                        </select>
                        @if ($submitted)
                            <div class="invalid-feedback">
                                {{ $errors->first('activity_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="started">I started my work: </label>
                        <div class="input-group date" id="datepickerstarted" data-target-input="nearest">
                            <input type="text" value="{{ array_get($old, 'started', $default->started) }}" class="form-control datetimepicker-input @if ($submitted && $errors->has('started')) is-invalid @endif" data-target="#datepickerstarted" name="started" id="started"/>
                            <div class="input-group-append" data-target="#datepickerstarted" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            @if ($submitted)
                                <div class="invalid-feedback">
                                    {{ $errors->first('started') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="finished">I finished my work: </label>
                        <div class="input-group date" id="datepickerfinished" data-target-input="nearest">
                            <input type="text" value="{{ array_get($old, 'finished', $default->finished) }}" class="form-control datetimepicker-input @if ($submitted && $errors->has('finished')) is-invalid @endif" data-target="#datepickerfinished" name="finished" id="finished"/>
                            <div class="input-group-append" data-target="#datepickerfinished" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            @if ($submitted)
                                <div class="invalid-feedback">
                                    {{ $errors->first('finished') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{--  --}}
                    <input type="hidden" name="time_id" value="time_{{ $id }}">

                    @if ($edit)
                        <button class="btn btn-danger btn-sm mr-auto" id="btn_delete" type="button" onclick="$('#time_delete-{{ $id }}').submit()">Delete </button>
                    @endif
                    <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-outline-success btn-sm">Save</button>
                </div>
            </form>
            <form action="{{ route('my.destroy', $id) }}" method="post" id="time_delete-{{ $id }}">
                {{ csrf_field() }}
                {{ method_field('delete') }}
            </form>
        </div>
    </div>
</div>

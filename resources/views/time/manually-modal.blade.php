<div class="modal fade" id="manual" tabindex="-1" role="dialog" aria-labelledby="manualLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manualLabel">Create time</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('my.store') }}" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="project">Project: </label>
                        <select class="custom-select @if ($errors->has('project_id')) is-invalid @endif" id="project" name="project_id">
                            <option value="">Select</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('project_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('project_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="task">Task: </label>
                        <select class="custom-select select2 @if ($errors->has('task_id')) is-invalid @endif" id="task" name="task_id">
                            <option value="">Select</option>
                            @foreach ($tasks as $task)
                                <option value="{{ $task->id }}" data-project_id="{{ $task->project_id }}">{{ $task->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('task_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('task_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="Activity">Activity: </label>
                        <select class="custom-select @if ($errors->has('activity_id')) is-invalid @endif" id="Activity" name="activity_id">
                            <option value="">Select</option>
                            @foreach ($activities as $activity)
                                <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('activity_id'))
                            <div class="invalid-feedback">
                                {{ $errors->first('activity_id') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="started">I started my work: </label>
                        <div class="input-group date" id="datepickerstarted" data-target-input="nearest">
                            <input type="text" value="" class="form-control datetimepicker-input @if ($errors->has('started')) is-invalid @endif" data-target="#datepickerstarted" name="started" id="started"/>
                            <div class="input-group-append" data-target="#datepickerstarted" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            @if ($errors->has('started'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('started') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="finished">I finished my work: </label>
                        <div class="input-group date" id="datepickerfinished" data-target-input="nearest">
                            <input type="text" value="" class="form-control datetimepicker-input @if ($errors->has('finished')) is-invalid @endif" data-target="#datepickerfinished" name="finished" id="finished"/>
                            <div class="input-group-append" data-target="#datepickerfinished" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                            @if ($errors->has('finished'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('finished') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-outline-success btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

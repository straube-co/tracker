<div class="modal fade" id="automatic-{{ $project->id }}" tabindex="-1" role="dialog" aria-labelledby="modalautomatic" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalautomatic">Let's work!</h5>
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
                        <label for="autotask-{{ $project->id }}">Task: </label>
                        <select class="custom-select select2 @if ($showError && $errors->has('task_name')) is-invalid @endif" id="autotask-{{ $project->id }}" name="task_name">
                            <option>Select</option>
                            @foreach ($tasks as $task)
                                @if($project->id === $task->project_id)
                                    <option value="{{ $task->id }}">{{ $task->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @if ($showError)
                            <div class="invalid-feedback">
                                {{ $errors->first('task_name') }}
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-outline-success btn-sm">Start</button>
                </div>
            </form>
        </div>
    </div>
</div>

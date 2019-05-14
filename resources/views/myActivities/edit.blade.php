
    <form action="{{ route('my.update', $time->id )}}" method="post">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <div class="form-group">
            <label for="project">Project: </label>
            <select class="@if ($errors->has('project_id')) is-invalid @endif" name="project_id" id="project">
                <option value="">Select</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}" @if ($project->id == old('project_id', $time->task->project->id)) selected @endif> {{ $project->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                {{ $errors->first('project_id') }}
            </div>
        </div>
        <div class="form-group">
            <label for="task">Task: </label>
            <select class="@if ($errors->has('task_id')) is-invalid @endif" name="task_id" id="task">
                <option value="">Select</option>
                @foreach ($tasks as $task)
                    <option value="{{ $task->id }}" data-project_id="{{ $task->project_id }}" @if ($task->id == old('task_id', $time->task_id)) selected @endif> {{ $task->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                {{ $errors->first('task_id') }}
            </div>
        </div>
        <div class="form-group">
            <label for="activity">Activity: </label>
            <select class="@if ($errors->has('activity_id')) is-invalid @endif" name="activity_id" id="activity">
                <option value="">Select</option>
                @foreach ($activities as $activity)
                <option value="{{ $activity->id }}" @if ($activity->id == old('activity_id', $time->activity_id)) selected @endif> {{ $activity->name }}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                {{ $errors->first('activity_id') }}
            </div>
        </div>
        <div class="form-group">
            <label for="started">I started my work: </label>
            <div class="input-group date" id="datepickerstarted" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input @if ($errors->has('started')) is-invalid @endif" data-target="#datepickerstarted" name="started" value="{{old('started', $time->started)}}" id="started"/>
                <div class="input-group-append" data-target="#datepickerstarted" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
                <div class="invalid-feedback">
                    {{ $errors->first('finished') }}
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="finished">I finished my work: </label>
            <div class="input-group date" id="datepickerfinished" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input @if ($errors->has('finished')) is-invalid @endif" data-target="#datepickerfinished" name="finished" value="{{old('finished', $time->finished)}}" id="finished"/>
                <div class="input-group-append" data-target="#datepickerfinished" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
                <div class="invalid-feedback">
                    {{ $errors->first('finished') }}
                </div>
            </div>
        </div>
        <div>
            <button class="btn btn-success btn-sm" type="submit">Save </button>
            <a class="btn btn-danger btn-sm" href="{{ route('my.index')}}">Cancel</a>
        </div>
    </form>

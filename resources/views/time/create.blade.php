<div class="container">
    <form action="{{ route('time.store') }}" method="post">
    {{ csrf_field() }}
        <div>
            <label for="project">Project: </label>
            <select name="projectselect">
                <option>Select</option>
                @foreach ($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <label for="task">Task: </label>
            <select name="task_id">
                <option>Select</option>
                @foreach ($tasks as $task)
                <option value="{{ $task->id }}">{{ $task->name }}</option>
                @endforeach
            </select>
            {{ $errors->first('task_id') }}
        </div>
        <br>
        <div>
            <label>I started my work: </label>
            <input type="time" id="hms" name="started" min="00:00" max="24:59" required>
            {{ $errors->first('started') }}
        </div>
        <br>
        <div>
            <label>I finished my work: </label>
            <input type="time" id="hmf" name="finished" min="00:00" max="24:59" required>
            {{ $errors->first('finished') }}
        </div>
        <br>
        <div>
            <button type="submit">Create </button>
        </div>
    </form>
</div>

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
            <select name="taskselect">
                <option>Select</option>
                @foreach ($tasks as $task)
                <option value="{{ $task->id }}">{{ $task->name }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <label>I started my work: </label>
            <input type="time" id="hms" name="hms" min="00:00" max="24:00" required>
        </div>
        <br>
        <div>
            <label>I finished my work: </label>
            <input type="time" id="hmf" name="hmf" min="00:00" max="24:00" required>
        </div>
        <br>
        <div>
            <button type="submit">Create </button>
        </div>
    </form>
</div>

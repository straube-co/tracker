<div class="container">
    <form action="{{ route('time.update', $time->id )}}" method="post">
    {{ csrf_field() }}
    {{ method_field('put') }}
        <div>
            <label for="project">Project: </label>
            <select name="projectselect">
                @foreach ($projects as $project)
                <option value="{{ $project->id }}" @if ($project->id === $time->task->project->id) selected @endif> {{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <label for="task">Task: </label>
            <select name="taskselect">
                @foreach ($tasks as $task)
                <option value="{{ $task->id }}" @if ($task->id === $time->task_id) selected @endif> {{ $task->name }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <div>
            <label>I started my work: </label>
            <input type="time" id="hms" name="hms" min="00:00" max="24:00" value="{{ $time->started }}" required>
        </div>
        <br>
        <div>
            <label>I finished my work: </label>
            <input type="time" id="hmf" name="hmf" min="00:00" max="24:00" value="{{ $time->finished }}"  required>
        </div>
        <br>
        <div>
            <button type="submit">Create </button>
        </div>
    </form>
</div>

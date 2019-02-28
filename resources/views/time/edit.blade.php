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
            <select name="task_id">
                @foreach ($tasks as $task)
                <option value="{{ $task->id }}" @if ($task->id === $time->task_id) selected @endif> {{ $task->name }}</option>
                @endforeach
            </select>
            {{ $errors->first('task_id') }}
        </div>
        <br>
        <div>
            <label>I started my work: </label>
            <input type="time" id="hs" name="started" min="00:00" max="24:00" value="{{ $time->started }}" required>
            {{ $errors->first('started') }}
        </div>
        <br>
        <div>
            <label>I finished my work: </label>
            <input type="time" id="hf" name="finished" min="00:00" max="24:00" value="{{ $time->finished }}"  required>
            {{ $errors->first('finished') }}
        </div>
        <br>
        <div>
            <button type="submit">Edit </button>
        </div>
    </form>
</div>

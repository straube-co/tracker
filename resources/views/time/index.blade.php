<ul>
    <a href="{{ route('time.create') }}">Add Manual Time Entry</a><br><br>
    <a href="{{ route('time.index') }}">Start Automatic Time Counting</a><br><br>

    @foreach ($times as $time)
    <li>
    {{ $time->task->project->name }} / {{ $time->task->name }} / {{ $time->started }} {{ $time->finished }} / <a href="{{ route('time.edit', $time->id) }}">Edit</a>
        <form action="{{ route('time.destroy', $time->id) }}" method="post">
        {{ method_field('delete') }}
        {{ csrf_field() }}
            <div>
                <button type="submit">Delete </button>
            </div>
        </form>
    </li>
@endforeach
</ul>

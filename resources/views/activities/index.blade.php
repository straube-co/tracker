<ul>
    <a href="{{ route('activity.create') }}">Create new activity</a><br><br>
    @foreach ($activities as $activity)
    <li>
    {{ $activity->name }} / <a href="{{ route('activity.edit', $activity->id) }}">Edit</a>
        <form action="{{ route('activity.destroy', $activity->id) }}" method="post">
        {{ method_field('delete') }}
        {{ csrf_field() }}
            <div>
                <button type="submit">Delete </button>
            </div>
        </form>
    </li>
@endforeach
</ul>

@extends('layouts.header')

@section('content')
<ul>
    <a href="{{ route('activity.create') }}">Create new activity</a><br><br>
    <h1>Activity</h1>
    <br>
    @foreach ($activities as $activity)
    <li>
    {{ $activity->name }} / <a href="{{ route('activity.edit', $activity->id) }}">Edit</a>
        <form action="{{ route('activity.destroy', $activity->id) }}" method="post">
        {{ method_field('delete') }}
        {{ csrf_field() }}
            <div>
                <button type="submit">Delete </button>
            </div>
            <br>
        </form>
    </li>
@endforeach
</ul>
@endsection

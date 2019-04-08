@extends('layouts.header')

@section('content')
<ul>
    <a class ="btn btn-outline-dark btn-sm" href="{{ route('activity.create') }}">Create new activity</a><br><br>
    <h1>Activity</h1>
    <br>
    <li>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                    <tr>
                        <td class="activity">{{ $activity->name }}</td>
                        <td><a class="btn btn-secondary btn-sm" href="{{ route('activity.edit', $activity->id) }}">Edit</a></td>
                        <td>
                            <form action="{{ route('activity.destroy', $activity->id) }}" method="post">
                            {{ method_field('delete') }}
                            {{ csrf_field() }}
                                <button class="btn btn-danger btn-sm" type="submit">Delete </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </li>
</ul>
@endsection

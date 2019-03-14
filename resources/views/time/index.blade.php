@extends('layouts.header')

@section('content')
<ul>
    <a href="{{ route('time.create') }}">Add Manual Time Entry</a><br><br>
    <a href="{{ view('timeauto.index') }}">Start Automatic Time Counting</a><br><br>
    <h1>Activities</h1>
    <br>
    <li>
        <table class="table">
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Task</th>
                    <th>Activity</th>
                    <th>Started</th>
                    <th>Finished</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($times as $time)
                    <tr>
                        <td>{{ $time->task->project->name }}</td>
                        <td>{{ $time->task->name }}</td>
                        <td>{{ $time->activity->name }}</td>
                        <td>{{ $time->started }}</td>
                        <td>{{ $time->finished }}</td>
                        <td><a href="{{ route('time.edit', $time->id) }}">Edit</a></td>
                        <td>
                            <form action="{{ route('time.destroy', $time->id) }}" method="post">
                            {{ method_field('delete') }}
                            {{ csrf_field() }}
                                <button type="submit">Delete </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </li>
</ul>
@endsection

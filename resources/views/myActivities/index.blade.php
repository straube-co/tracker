@extends('layouts.header')

@section('content')
    <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#manual">
        Add Manual Time Entry
    </button>
    @include('myActivities.modal', [ 'time' => null ])
    <h1 class="pt-3">My Activities</h1>
    <table class="table pt-3">
        <thead>
            <tr>
                <th>Project</th>
                <th>Task</th>
                <th>Activity</th>
                <th>Started</th>
                <th>Finished</th>
                <th>Total</th>
                <th>Edit</th>
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
                    <td>{{ $time->finished ? App\Support\Formatter::intervalTime($time->finished->diffAsCarbonInterval($time->started)) : '-' }}</td>
                    <td>
                        <button type="button" class="btn btn-outline-dark btn-sm mr-2" data-toggle="modal" data-target="#edit-{{ $time->id }}">
                            Edit
                        </button>
                        @include('myActivities.modal')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $times->links() }}
@endsection

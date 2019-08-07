@extends('layouts.header')

@section('content')
    @include('myActivities.modal', [ 'time' => null ])
    <h1 class="mt-4 mb-4">My Activities
        <button type="button" class="btn btn-outline-success btn-sm ml-2" data-toggle="modal" data-target="#manual">
            Add Manual Time Entry
        </button>
    </h1>
    <div class="table-responsive">
        <table class="table pt-3">
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Task</th>
                    <th>Activity</th>
                    <th>Started</th>
                    <th>Finished</th>
                    <th class="text-right">Total</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($times as $time)
                    <tr>
                        <td>{{ $time->task->project->name }}</td>
                        <td>{{ $time->task->name }}</td>
                        <td>{{ $time->activity->name }}</td>
                        <td><samp>{{ $time->started }}</samp></td>
                        <td><samp>{{ $time->finished }}</samp></td>
                        <td class="text-right"><samp>{{ $time->finished ? App\Support\Formatter::intervalTime($time->finished->diffAsCarbonInterval($time->started)) : '-' }}</samp></td>
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
    </div>
    {{ $times->links() }}
@endsection

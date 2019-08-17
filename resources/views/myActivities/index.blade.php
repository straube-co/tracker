@extends('layouts.app')

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
                    <th class="align-middle">Project</th>
                    <th class="align-middle">Task</th>
                    <th class="align-middle">Activity</th>
                    <th class="align-middle">Started</th>
                    <th class="align-middle">Finished</th>
                    <th class="align-middle text-right">Total</th>
                    <th class="align-middle">Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($times as $time)
                    <tr>
                        <td class="align-middle">{{ $time->task->project->name }}</td>
                        <td class="align-middle">{{ $time->task->name }}</td>
                        <td class="align-middle">{{ $time->activity->name }}</td>
                        <td class="align-middle"><samp>{{ $time->started }}</samp></td>
                        <td class="align-middle"><samp>{{ $time->finished }}</samp></td>
                        <td class="align-middle text-right"><samp>{{ $time->finished ? App\Support\Formatter::intervalTime($time->finished->diffAsCarbonInterval($time->started)) : '-' }}</samp></td>
                        <td class="align-middle">
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

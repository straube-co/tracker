@extends('layouts.header')

@section('content')
    @include('activities.modal', [ 'activity' => null ])
    <h1 class="mt-4 mb-4">Activity
        <button type="button" class="btn btn-outline-dark btn-sm ml-2" data-toggle="modal" data-target="#activity">
            Create new activity
        </button>
    </h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
                <tr>
                    <td class="activity">{{ $activity->name }}</td>
                    <td>
                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#edit-{{ $activity->id }}">
                            Edit
                        </button>
                        @include('activities.modal')
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

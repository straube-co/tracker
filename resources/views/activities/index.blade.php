@extends('layouts.header')

@section('content')
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#activity">
        Create new activity
    </button>
    @include('activities.modal', [ 'activity' => null ])
    <h1 class="pt-3">Activity</h1>
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

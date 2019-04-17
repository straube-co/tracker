@extends('layouts.header')

@section('content')
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#activity">
        Create new activity
    </button>
    <!-- Modal -->
    <div class="modal fade" id="activity" tabindex="-1" role="dialog" aria-labelledby="modalActivity" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalActivity">Create new activity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('activity.store') }}" method="post">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div>
                            <label for="name">Name: </label>
                            <input type="text" name="name" required>
                            {{ $errors->first('name') }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success btn-sm">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <h1 class="pt-3">Activity</h1>
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
@endsection

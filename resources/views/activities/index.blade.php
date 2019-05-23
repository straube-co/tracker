@extends('layouts.header')

@section('content')
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#activity">
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
                        <div class="form-group">
                            <label for="name">Name: </label>
                            <input class="form-control @if ($errors->has('name')) is-invalid @endif" type="text" name="name">
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-success btn-sm">Save</button>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
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
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
                <tr>
                    <td class="activity">{{ $activity->name }}</td>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#edit-{{ $activity->id }}">
                            Edit
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="edit-{{ $activity->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('activity.update', $activity->id )}}" method="post">
                                        <div class="modal-body">
                                            {{ csrf_field() }}
                                            {{ method_field('put') }}
                                            <div>
                                                <label>Name: </label>
                                                <input type="text" name="name" value="{{ $activity->name }}">
                                                {{ $errors->first('name') }}
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-start">
                                            <button class="btn btn-outline-success btn-sm" type="submit">Save </button>
                                            <a class="btn btn-outline-danger btn-sm" href="{{ route('activity.index')}}">Cancel</a>
                                            <button class="btn btn-danger btn-sm ml-auto" type="button" onclick="$('#activity_delete-{{ $activity->id }}').submit()">Delete </button>
                                        </div>
                                    </form>
                                    <form action="{{ route('activity.destroy', $activity->id) }}" method="post" id="activity_delete-{{ $activity->id }}">
                                        {{ method_field('delete') }}
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

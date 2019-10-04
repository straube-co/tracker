@extends('layouts.app')

@section('content')
    <div class="d-flex my-4">
        <h1>Users</h1>
        <div class="d-flex align-items-center ml-3">
            <a class="btn btn-outline-success btn-sm" href="{{ route("user.create") }}">Create user</a>
        </div>
    </div>
    <form action="{{route('user.store')}}" method="post">
        {{ csrf_field() }}
        <table class="table pt-3">
            <thead>
                <tr>
                    <th class="align-middle">User</th>
                    <th class="align-middle">Settings</th>
                    <th class="align-middle">Reports</th>
                    <th class="align-middle">Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="align-middle">{{$user->name}}</td>
                        <td class="align-middle"><input name="access[{{ $user->id }}][]" type="checkbox" value="1" @if (in_array(1, $user->access())) checked @endif></td>
                        <td class="align-middle"><input name="access[{{ $user->id }}][]" type="checkbox" value="2" @if (in_array(2, $user->access())) checked @endif></td>
                        <td><a href="{{ route("user.edit", $user->id) }}"><i class="fas fa-edit"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right">
            <button type="submit" class="btn btn-outline-success btn-sm" name="button">Save</button>
        </div>
    </form>
@endsection

@extends('layouts.app')

@section('content')
    <div class="d-flex my-4 mx-5">
        <h1>Users</h1>
        @can('admin')
            <div class="d-flex align-items-center ml-3">
                <a class="btn btn-outline-success btn-sm" href="{{ route("user.create") }}">Create user</a>
            </div>
        @endcan
    </div>
    <div class="mx-5">
        <table class="table pt-3">
            <thead>
                <tr>
                    <th class="align-middle">User</th>
                    <th class="align-middle">E-mail</th>
                    <th class="align-middle">Access</th>
                    <th class="align-middle">Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="align-middle">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->access }}</td>
                        <td><a href="{{ route("user.edit", $user->id) }}"><i class="fas fa-edit"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

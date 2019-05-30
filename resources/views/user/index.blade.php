@extends('layouts.header')
@section('content')
    <h1 class="mt-4 mb-4">Users</h1>
    <table class="table pt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Settings</th>
                <th>Reports</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td><input value="1" type="checkbox"></td>
                    <td><input value="2" type="checkbox"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <form action="{{route('user.store')}}" method="post">
        {{ csrf_field() }}
        <div>
            <button type="submit" name="button">Save</button>
        </div>
    </form>
@endsection

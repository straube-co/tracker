@extends('layouts.header')
@section('content')
    <h1 class="mt-4 mb-4">Users</h1>
    <form action="{{route('user.store')}}" method="post">
        {{ csrf_field() }}
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
                        <td><input name="access[{{ $user->id }}][]" type="checkbox" value="1"></td>
                        <td><input name="access[{{ $user->id }}][]" type="checkbox" value="2"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <button type="submit" class="btn btn-outline-success btn-sm" name="button">Save</button>
        </div>
    </form>
@endsection

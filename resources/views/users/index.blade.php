@extends('layouts.app')

@section('content')
    <div class="container">
        <button class="btn btn-primary">New user</button>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="align-top">Name</th>
                    <th class="align-top"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="align-top">{{ $user->name }}</td>
                        <td class="align-top"><a class="btn btn-default" href="#">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <button class="btn btn-primary">New activity</button>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="align-top">Name</th>
                    <th class="align-top"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                    <tr>
                        <td class="align-top">{{ $activity->name }}</td>
                        <td class="align-top"><a class="btn btn-default" href="#">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

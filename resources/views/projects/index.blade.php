@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-4">
            <button class="btn btn-primary">New project</button>
        </div>

        <h2 class="pt-4 mb-4">Projects</h2>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="align-middle">Name</th>
                    <th class="align-middle"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td class="align-middle">{{ $project->name }}</td>
                        <td class="align-middle text-right"><a class="btn btn-secondary" href="#">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-4">
            <button class="btn btn-primary">New project</button>
        </div>

        <h2 class="pt-4 mb-4">Projects</h2>

        @if (count($projects) === 0)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">No projects created yet</h5>
                    <p class="card-text">
                        Go ahead and <a href="#">create the first project</a>.
                    </p>
                </div>
            </div>
        @else
            <div class="card-columns">
                @foreach ($projects as $project)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->name }}</h5>
                            <p class="card-text"><samp>{{ $project->getTrackedTime() ?: '00:00:00' }}</samp></p>
                            <a class="card-link" href="#">Edit</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

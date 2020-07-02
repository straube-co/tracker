@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-4">
            <button class="btn btn-primary">{{ __('New project') }}</button>
        </div>

        <h2 class="pt-4 mb-4">{{ __('Projects') }}</h2>

        @if (count($projects) === 0)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('No projects created yet') }}</h5>
                    <p class="card-text">
                        {!! __('Go ahead and <a :attributes >create the first project</a>.', [ 'attributes' => 'href="#"' ]) !!}
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
                            <a class="card-link" href="#">{{ __('Edit') }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

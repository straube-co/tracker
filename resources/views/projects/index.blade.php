@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <button class="btn btn-primary" data-toggle="modal" data-target="#create-project">{{ __('New project') }}</button>
            </div>
            <div class="col-auto ml-auto">
                @if ($status === 'archived')
                    <a class="btn btn-link" href="{{ route('projects.index') }}">{{ __('Active projects') }}</a>
                @else
                    <a class="btn btn-link" href="{{ route('projects.index', 'archived') }}">{{ __('Archived projects') }}</a>
                @endif
            </div>
        </div>

        <h2 class="pt-4 mb-4">{{ __('Projects') }}</h2>

        @if (count($projects) === 0)
            <div class="card">
                <div class="card-body">
                    @if ($status === 'archived')
                        <h5 class="card-title">{{ __('No archived projects') }}</h5>
                        <p class="card-text">
                            {!! __('Check the <a :attributes >active projects</a>.', [ 'attributes' => sprintf('href="%s"', route('projects.index')) ]) !!}
                        </p>
                    @else
                        <h5 class="card-title">{{ __('No projects created yet') }}</h5>
                        <p class="card-text">
                            {!! __('Go ahead and <a :attributes >create the first project</a>.', [ 'attributes' => 'href="javascript:return false" data-toggle="modal" data-target="#create-project"' ]) !!}
                        </p>
                    @endif
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
                            @if ($project->trashed())
                                <a
                                    class="card-link"
                                    href="{{ route('projects.restore', $project) }}"
                                    onclick="event.preventDefault();
                                            document.getElementById('project-restore-{{ $project->id }}').submit();">
                                    {{ __('Restore') }}
                                </a>
                                <form id="project-restore-{{ $project->id }}" action="{{ route('projects.restore', $project) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('PATCH')
                                </form>
                            @else
                                <a
                                    class="card-link"
                                    href="{{ route('projects.archive', $project) }}"
                                    onclick="event.preventDefault();
                                            document.getElementById('project-archive-{{ $project->id }}').submit();">
                                    {{ __('Archive') }}
                                </a>
                                <form id="project-archive-{{ $project->id }}" action="{{ route('projects.archive', $project) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@push('modals')
    <create-project />
@endpush

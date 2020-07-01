@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-4">
            <button class="btn btn-primary">New activity</button>
        </div>

        <h2 class="pt-4 mb-4">Activities</h2>

        @if (count($activities) === 0)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">No activitiy types created yet</h5>
                    <p class="card-text">
                        Go ahead and <a href="#">create the first activity type</a>. Some examples are <strong>Design</strong>, <strong>Programming</strong>, or <strong>Business Development</strong>.
                    </p>
                </div>
            </div>
        @else
            <div class="card-columns">
                @foreach ($activities as $activity)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $activity->name }}</h5>
                            <a class="card-link" href="#">Edit</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

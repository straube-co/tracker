@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-4">
            <button class="btn btn-primary">{{ __('New user') }}</button>
        </div>

        <h2 class="pt-4 mb-4">{{ __('Users') }}</h2>

        <div class="card-columns">
            @foreach ($users as $user)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <p class="card-text">{{ $user->email }}</p>
                        <a class="card-link" href="#">{{ __('Edit') }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

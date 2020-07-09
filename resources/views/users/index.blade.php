@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-4">
            <button class="btn btn-primary" data-toggle="modal" data-target="#create-user">{{ __('New user') }}</button>
        </div>

        <h2 class="pt-4 mb-4">{{ __('Users') }}</h2>

        <div class="card-columns">
            @foreach ($users as $user)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <p class="card-text">{{ $user->email }}</p>
                        <a href="#"
                            onclick="event.preventDefault();app.$emit('user-edit',{{ json_encode($user->attributesToArray()) }})"
                            class="card-link">Edit</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('modals')
    <create-user></create-user>
    <edit-user></edit-user>
@endpush

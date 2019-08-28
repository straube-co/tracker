@extends('layouts.app')

@section('content')
    <div class="container login">
        <h1 class="text-center">Welcome!</h1>
        <a class="btn btn-outline-success btn-sm" href="{{ route('auth.login') }}">Log in with Asana</a>
    </div>
@endsection

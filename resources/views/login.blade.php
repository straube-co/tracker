@extends('layouts.app')

@section('content')
    <div class="container login">
        <h1 class="text-center">Login with Asana</h1>
        <a class="btn btn-outline-success btn-sm" href="{{ route('auth.auth')}}">GO</a>
    </div>
@endsection

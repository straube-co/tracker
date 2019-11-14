@extends('layouts.guest')

@section('content')
    <h3 class="text-center mb-4">Reset Password</h3>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="row">
            <div class="col-10 offset-1">
                <div class="form-group">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group mb-0 d-flex">
                    <a href="{{ route('login') }}">
                        Voltar para o login
                    </a>
                    <button type="submit" class="btn btn-primary ml-auto">Send Password Reset Link</button>
                </div>
            </div>
        </div>
    </form>
@endsection

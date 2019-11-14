@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-1 text-center">Edit user</h1>
            <form action="{{ route('user.update', $user->id) }}" method="post" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="form-group">
                    <label for="name">Name </label>
                    <input class="form-control @if($errors->has('name')) is-invalid @endif" type="text" name="name" id="name" value="{{ old('name', $user->name) }}" autocomplete="false">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="email">E-mail </label>
                    <input class="form-control @if($errors->has('email')) is-invalid @endif" type="text" name="email" id="email" value="{{ old('email', $user->email) }}">
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
                @can('admin')
                    <div class="form-group">
                        <p for="access" class="mb-0">Access:</p>
                        @foreach (App\User::getPermissions() as $value => $name)
                            <div class="form-check form-check-inline ml-3">
                                <input class="form-check-input" type="checkbox" name="access[]" id="checkboxAccess" value="{{ $value }}" @if (in_array($value, (array) old('access', $user->access()))) checked @endif>
                                <label class="form-check-label" for="checkboxAccess">{{ $name }}</label>
                            </div>
                        @endforeach
                        @if ($errors->has('access'))
                            <div class="invalid-feedback d-block">
                                {{ $errors->first('access') }}
                            </div>
                        @endif
                    </div>
                @endcan
                <div class="form-group">
                    <label for="password">Password </label>
                    <input class="form-control @if($errors->has('password')) is-invalid @endif" type="password" name="password" id="password">
                    <label class="mt-3" for="password_confirmation">Confirmar senha</label>
                    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                    @if ($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>
                <div class="d-flex">
                    <div class="ml-auto">
                        <a class="btn btn-outline-danger btn-sm mr-2" href="{{ route('user.index') }}">Cancel</a>
                        <button class="btn btn-outline-success btn-sm" type="submit" name="edit-user">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

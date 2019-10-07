@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-1 text-center">Create user</h1>
            <form action="{{ route('user.store') }}" method="post" autocomplete="off">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Name </label>
                    <input class="form-control @if($errors->has('name')) is-invalid @endif" type="text" name="name" id="name" autocomplete="false" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="email">E-mail </label>
                    <input class="form-control @if($errors->has('email')) is-invalid @endif" type="text" name="email" id="email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="access">Access</label>
                    <select class="custom-select @if($errors->has('access')) is-invalid @endif" name="access">
                        <option value="">Select</option>
                        <option value="3" @if ('3' == old('access')) selected @endif>All access</option>
                        <option value="1" @if ('1' == old('access')) selected @endif>Settings</option>
                        <option value="2" @if ('2' == old('access')) selected @endif>Reports</option>
                    </select>
                    @if ($errors->has('access'))
                        <div class="invalid-feedback">
                            {{ $errors->first('access') }}
                        </div>
                    @endif
                </div>
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
                        <button class="btn btn-outline-success btn-sm" type="submit" name="create-user">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

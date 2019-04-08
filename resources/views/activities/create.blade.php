@extends('layouts.header')

@section('content')
<div class="container">
    <form action="{{ route('activity.store') }}" method="post">
    {{ csrf_field() }}
        <div>
            <label for="name">Name: </label>
            <input type="text" name="name" required>
            {{ $errors->first('name') }}
        </div>
        <br>
        <div>
            <button class="btn btn-success btn-sm" type="submit">Create </button>
            <a class="btn btn-danger btn-sm" href="{{ route('activity.index')}}">Cancel</a>
        </div>
    </form>
</div>
@endsection

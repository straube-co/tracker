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
            <button type="submit">Create </button>
            <a type="button" href="{{ route('time.index')}}">Cancel</a>
        </div>
    </form>
</div>
@endsection

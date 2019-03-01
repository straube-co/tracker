@extends('layouts.header')

@section('content')
<ul>
    <a href="{{ route('time.index') }}">Time Tracking</a><br><br>
    <a href="{{ route('activity.index') }}">Activities</a><br><br>
    <a href="{{ route('report.index') }}">Reports</a><br><br>
</ul>






@endsection

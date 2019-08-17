@extends('layouts.app')

@section('content')
    <h1 class="mt-4 mb-4">{{ $report->name }}</h1>

    @include('report.rows')
@endsection

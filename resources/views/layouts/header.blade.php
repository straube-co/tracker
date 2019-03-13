<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <title></title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <a href="{{ route('time.index') }}">Time Tracking</a>
        <a href="{{ route('activity.index') }}">Activities</a>
        <a href="{{ route('report.index') }}">Reports</a>
        <a href="{{ route('import.index') }}">Import</a>
    </nav>
    <div id="app" class="container-fluid mt-5">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

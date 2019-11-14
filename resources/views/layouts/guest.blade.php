<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="html-guest">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="shortcut icon" href="/img/time.png" type="image/x-icon" />
    <title>Straube Time Tracking</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('head')
</head>
<body>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <h2 class="text-center">Straube time tracker</h2>
            </div>
            <div class="col-12 col-md-6">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>

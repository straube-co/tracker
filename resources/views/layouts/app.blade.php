<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    @if (($user = auth()->user()))
        <nav class="navbar navbar-expand fixed-top">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('time.index') }}">Time tracking</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="{{ route('my.index') }}">My activities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('report.index') }}">Reports</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('point.index') }}">Point</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbar-settings" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Settings
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-settings">
                        <a class="dropdown-item" href="{{ route('activity.index') }}">Activities</a>
                        <a class="dropdown-item" href="{{ route('user.index') }}">Users</a>
                        <a class="dropdown-item" href="{{ route('import.index') }}">Import</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Log out <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
    @endif
    <div id="app" class="container-fluid mt-3">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('foot')
</body>
</html>

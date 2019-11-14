<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="@yield('html-class')">
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
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    @if(App\Point::exit())
                        <a href="#started" class="started" data-toggle="modal" data-target="#point">Start <i class="far fa-clock"></i></a>
                    @elseif ($currentPoint)
                        <a href="#finished" class="finished" onclick="event.preventDefault();
                            document.getElementById('exit-form').submit();">Sign off <i class="far fa-clock"></i></i>
                        </a>
                        <form id="exit-form" action="{{ route('point.update', $currentPoint) }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                        </form>
                    @endif
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbar-settings" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Settings
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-settings">
                        <a class="dropdown-item" href="{{ route('point.index') }}">Point report</a>
                        <a class="dropdown-item" href="{{ route('activity.index') }}">Activities</a>
                        {{-- <a class="dropdown-item" href="{{ route('import.index') }}">Import</a> --}}
                        <a class="dropdown-item" href="{{ route('user.index') }}">Users</a>
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

        <!-- Modal -->
        <div class="modal fade" id="point" tabindex="-1" role="dialog" aria-labelledby="ModalPoint" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="ModalPoint">Your entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ route('point.store') }}" method="post">
                  {{ csrf_field() }}
                  <div class="modal-body">
                      <div class="form-group">
                          <label for="entry">Entry</label>
                          <div class="input-group" id="datepickerentry" data-target-input="nearest">
                              <input type="text" name="started" class="form-control datetimepicker-input @if ($errors->has('started')) is-invalid @endif" value="" data-target="#datepickerentry"/>
                              <div class="input-group-append" data-target="#datepickerentry" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                          @if($errors->has('started'))
                              <div class="invalid-feedback d-block">
                                  {{ $errors->first('started') }}
                              </div>
                          @endif
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
                      <button type="submit" class="btn btn-outline-success btn-sm">Save</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
    @endif
    <div id="app" class="container-fluid">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('foot')
</body>
</html>

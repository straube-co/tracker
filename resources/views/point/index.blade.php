@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">My schedules
            @if(\App\Point::exit())
                <button type="button" class="btn btn-outline-success btn-sm ml-2" data-toggle="modal" data-target="#point">
                    Entry
                </button>
            @endif
        </h1>
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
                              <input type="text" name="entry" class="form-control datetimepicker-input" value="" data-target="#datepickerentry"/>
                              <div class="input-group-append" data-target="#datepickerentry" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
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
        <div class="table-responsive table-hover">
            <table class="table pt-3">
                <thead>
                    <tr>
                        <th class="align-middle">Functionary</th>
                        <th class="align-middle text-right">Entry</th>
                        <th class="align-middle text-right">Exit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($points as $point)
                        <tr>
                            <td class="align-middle">{{ $point->user->name }}</td>
                            <td class="align-middle text-right">{{ $point->entry }}</td>
                            <td class="align-middle text-right">
                                @if($point->exit)
                                    {{ $point->exit }}
                                @else
                                    <a href="#" class="exit" onclick="event.preventDefault();
                                        document.getElementById('exit-form').submit();"><i class="far fa-clock"></i>
                                    </a>
                                    <form id="exit-form" action="{{ route('point.update', $point->id) }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        {{ method_field('put') }}
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

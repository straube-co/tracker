@extends('layouts.app')

@section('content')
    <form action="{{ route('point.index') }}" method="get">
        <button
            class="btn btn-outline-dark btn-sm mr-1"
            type="button"
            data-toggle="collapse"
            data-target="#filter-advanced"
            aria-expanded="false"
        >
            Filter results
        </button>
        <a href="#" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#date">Monthly report</a>
        <div class="collapse" id="filter-advanced">
            <div class="row">
                <div class="col-md-6">
                    @can('report')
                        <div class="form-group pt-3">
                            <label for="user">User:</label>
                            <select class="custom-select" id="user" name="user_id">
                                <option value="">Select</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @if ($user->id == request('user_id')) selected @endif>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endcan
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="pt-3 form-group">
                        <label>From:</label>
                        <div class="input-group" id="datepickerentry" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#datepickerentry" name="started" value="{{ request('entry') }}"/>
                            <div class="input-group-append" data-target="#datepickerentry" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pt-3 form-group">
                        <label>To:</label>
                        <div class="input-group" id="datepickerexit" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#datepickerexit" name="finished" value="{{ request('exit') }}"/>
                            <div class="input-group-append" data-target="#datepickerexit" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-outline-secondary btn-sm">Apply</button>
            </div>
        </div>
    </form>
    <h1 class="my-3">Schedules</h1>
    @if ($schedules->isEmpty())
        <hr>
        <h5 class="text-center">Nenhum registro encontrado</h5>
    @else
        <div>
            <dl>
                <dt>Total hours worked</dt>
                <dd class="ml-3">{{ App\Point::convertToHours($total) }}</dd>
                <dt></dt>
                <dd></dd>
            </dl>
        </div>
        <div class="table-responsive table-hover">
            <table class="table pt-3">
                <thead>
                    <tr>
                        <th class="align-middle">Functionary</th>
                        <th class="align-middle text-center">Date</th>
                        <th class="align-middle text-center">Total</th>
                        <th class="align-middle text-center">Extra</th>
                        <th class="align-middle text-center">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $schedule)
                        <tr>
                            <td class="align-middle">{{ $schedule->user->name }}</td>
                            <td class="align-middle text-center">{{ $schedule->date_entry }}</td>
                            <td class="align-middle text-center @if($schedule->date_time < App\Point::MINUTES) negative @endif">{{ $schedule->convertToHours($schedule->date_time) }}</td>
                            <td class="align-middle text-center">{{ $schedule->extra($schedule->date_time) }}</td>
                            <td class="align-middle text-center">
                                <a href="#" class="details" data-date_entry="{{ $schedule->date_entry }}" data-user_id="{{ $schedule->user_id }}">Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <!-- Modal -->
    <div class="modal" tabindex="-1" role="dialog" id="schedules">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-none">
                    <h5 class="modal-title">Details of the day</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('save') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-body px-0 py-0">
                        <div class="table-responsive">
                            <table class="table pt-3">
                                <thead>
                                    <tr>
                                        <th class="align-middle">Entrada</th>
                                        <th class="align-middle">Saída</th>
                                    </tr>
                                </thead>
                                <tbody id="field"></tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-success btn-sm">Save</button>
                    </div>
                 </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="date" tabindex="-1" role="dialog" aria-labelledby="ModalDate" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalDate">Month</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ route('print.report') }}" method="post">
              {{ csrf_field() }}
              <div class="modal-body">
                  <div class="form-group">
                      <label for="user">User</label>
                      <select class="custom-select" name="user">
                          <option value="">Select</option>
                          @foreach ($users as $user)
                              <option value="{{ $user->id }}">{{ $user->name }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="month">Month</label>
                      <select class="custom-select" name="month">
                          <option value="">Select</option>
                          <option value="01">January</option>
                          <option value="02">February</option>
                          <option value="03">March</option>
                          <option value="04">April</option>
                          <option value="05">May</option>
                          <option value="06">June</option>
                          <option value="07">July</option>
                          <option value="08">August</option>
                          <option value="09">September</option>
                          <option value="10">October</option>
                          <option value="11">November</option>
                          <option value="12">December</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <label for="month">Year</label>
                      <select class="custom-select" name="year">
                          <option value="">Select</option>
                          @foreach (range(2018, date('Y')) as $y)
                              <option value="{{ $y }}">{{ $y }}</option>
                          @endforeach
                      </select>
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
    {{-- {{ $schedules->links() }} --}}
@endsection

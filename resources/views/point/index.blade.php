@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-4">My schedules
            <button type="button" class="btn btn-outline-success btn-sm ml-2" data-toggle="modal" data-target="#point">
                Entry
            </button>
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
              <form action="#" method="post">
                  <div class="modal-body">
                      <div class="form-group">
                          <label for="entry">Entry</label>
                          <div class="input-group date" id="datepickerentry" data-target-input="nearest">
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
                        <th class="align-middle">Entry</th>
                        <th class="align-middle">Exit</th>
                        <th class="align-middle">Date</th>
                        <th class="align-middle text-center">Report</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td class="align-middle"></td>
                            <td class="align-middle"></td>
                            <td class="align-middle"></td>
                            <td class="align-middle"></td>
                            <td class="align-middle text-center"><a href="#">list-icon</a></td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

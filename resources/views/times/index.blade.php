@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <button class="btn btn-primary" data-toggle="modal" data-target="#add-time-entry">New time entry</button>
            </div>
            <div class="col-auto ml-auto">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#report-options" aria-expanded="false" aria-controls="report-options">Report options</button>
            </div>
        </div>

        <form class="collapse" id="report-options" action="{{ route('times.index') }}" method="get">
            <div class="row">
                <div class="col-md-8">
                    <h5>Custom filter</h5>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>Project</label>
                            <select class="custom-select">
                                <option>Select</option>
                                <option disabled>--</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col">
                            <label>Activity</label>
                            <select class="custom-select">
                                <option>Select</option>
                                <option disabled>--</option>
                                @foreach ($activities as $activity)
                                    <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label>User</label>
                            <select class="custom-select">
                                <option>Select</option>
                                <option disabled>--</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col">
                            <label>From</label>
                            <input class="form-control" type="text" placeholder="YYYY-MM-DD" />
                        </div>
                        <div class="form-group col">
                            <label>To</label>
                            <input class="form-control" type="text" placeholder="YYYY-MM-DD" />
                        </div>
                    </div>
                    <button class="btn btn-secondary">Apply</button>
                    <button class="btn btn-secondary">Apply &amp; Save</button>
                </div>
                <div class="col-md-4">
                    <h5>Load report</h5>
                    <div class="form-group">
                        <label>Name</label>
                        <select class="custom-select" name="report_id" onchange="this.form.submit();">
                            <option value="">My week</option>
                            <option value="" disabled>--</option>
                            <option value="" disabled>Saved reports</option>
                            @foreach ($reports as $id => $name)
                                <option value="{{ $id }}" @if (request('report_id') == $id) selected @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </form>

        <h2 class="pt-4 mb-4">{{ $report->name }}</h2>

        @if (count($times) === 0)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">No time tracked yet</h5>
                    <p class="card-text">
                        The current report has no time. It's possible to select different
                        <a href="javascript:return false" class="card-link" type="button" data-toggle="collapse" data-target="#report-options" aria-expanded="false" aria-controls="report-options">report options</a>.
                    </p>
                </div>
            </div>
        @else
            <table class="table table-hover">
                <thead class="sr-only">
                    <tr>
                        <th class="align-top">Task</th>
                        <th class="align-top">User</th>
                        <th class="align-top">Tracked time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($times as $time)
                        <tr>
                            <td class="align-top">
                                <h6>{{ $time->project->name }}</h6>
                                {{ $time->activity->name }} - <span class="text-muted">{{ $time->description }}</span>
                            </td>
                            <td class="align-top">{{ $time->user->name }}</td>
                            <td class="align-top">
                                <h6><samp>{{ $time->getTrackedTime() ?: '-' }}</samp></h6>
                                <small class="text-muted">
                                    <samp>{{ $time->started }}</samp>
                                    -
                                    <samp>{{ $time->finished }}</samp>
                                </small>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $times->withQueryString()->links() }}
        @endif
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="add-time-entry" tabindex="-1" role="dialog" aria-labelledby="add-time-entry-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add-time-entry-label">Add Time Entry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-time-entry modal="add-time-entry" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Start</button>
                </div>
            </div>
        </div>
    </div>
@endpush

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
                            <select class="custom-select" v-model="activity">
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

        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="align-top">Project</th>
                    <th class="align-top">Activity</th>
                    <th class="align-top">User</th>
                    <th class="align-top">Description</th>
                    <th class="align-top">Started</th>
                    <th class="align-top">Finished</th>
                    <th class="align-top">Ellapsed</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($times as $time)
                    <tr>
                        <td class="align-top">{{ $time->project->name }}</td>
                        <td class="align-top">{{ $time->activity->name }}</td>
                        <td class="align-top">{{ $time->user->name }}</td>
                        <td class="align-top">{{ $time->description }}</td>
                        <td class="align-top"><samp>{{ $time->started }}</samp></td>
                        <td class="align-top"><samp>{{ $time->finished }}</samp></td>
                        <td class="align-top"><samp>{{ $time->finished->longAbsoluteDiffForHumans($time->started) }}</samp></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $times->withQueryString()->links() }}
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

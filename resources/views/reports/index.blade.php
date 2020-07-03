@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card" id="report-options">
            <div class="card-body">
                <div class="row">
                    <form class="col-md-8" action="{{ route('reports.index') }}" method="get">
                        <h5>{{ __('Custom filter') }}</h5>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="report-project_id">{{ __('Project') }}</label>
                                <select class="custom-select" name="filter[project_id]" id="report-project_id">
                                    <option value="">{{ __('Select') }}</option>
                                    <option disabled>--</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}" @if ($project->id == request('filter.project_id')) selected @endif>{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col">
                                <label for="report-activity_id">{{ __('Activity') }}</label>
                                <select class="custom-select" name="filter[activity_id]" id="report-activity_id">
                                    <option value="">{{ __('Select') }}</option>
                                    <option disabled>--</option>
                                    @foreach ($activities as $activity)
                                        <option value="{{ $activity->id }}" @if ($activity->id == request('filter.activity_id')) selected @endif>{{ $activity->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="report-user_id">{{ __('User') }}</label>
                                <select class="custom-select" name="filter[user_id]" id="report-user_id">
                                    <option value="">{{ __('Select') }}</option>
                                    <option disabled>--</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @if ($user->id == request('filter.user_id')) selected @endif>{{ $user->getFirstName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col">
                                <label for="report-started">{{ __('From') }}</label>
                                <input class="form-control" type="text" name="filter[started]" id="report-started" value="{{ request('filter.started') }}" placeholder="YYYY-MM-DD" />
                            </div>
                            <div class="form-group col">
                                <label for="form-finished">{{ __('To') }}</label>
                                <input class="form-control" type="text" name="filter[finished]" id="report-finished" value="{{ request('filter.finished') }}" placeholder="YYYY-MM-DD" />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-secondary">{{ __('Apply') }}</button>
                        <button type="button" class="btn btn-secondary">{{ __('Apply & Save') }}</button>
                    </form>
                    <form class="col-md-4" action="{{ route('reports.index') }}" method="get">
                        <h5>{{ __('Load report') }}</h5>
                        <div class="form-group">
                            <label id="report_id">{{ __('Name') }}</label>
                            <select class="custom-select" name="report_id" id="report_id" onchange="this.form.submit();">
                                <option value="">{{ __('My week') }}</option>
                                <option value="" disabled>--</option>
                                <option value="" disabled>{{ __('Saved reports') }}</option>
                                @foreach ($reports as $id => $name)
                                    <option value="{{ $id }}" @if (request('report_id') == $id) selected @endif>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <h2 class="pt-4 mb-4">{{ $report->name }}</h2>

        @if (count($times) === 0)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('No tracked time found') }}</h5>
                    <p class="card-text">
                        {!! __('The current report has no time. It\'s possible to select different <a :attributes >report options</a>.', [ 'attributes' => 'href="#report-options"' ]) !!}
                    </p>
                </div>
            </div>
        @else
            @php
                $hasMyTime = $times->where('user_id', auth()->user()->id)->count() > 0;
            @endphp
            <table class="table">
                <thead class="sr-only">
                    <tr>
                        <th class="align-top">{{ __('Task') }}</th>
                        <th class="align-top">{{ __('User') }}</th>
                        <th class="align-top">{{ __('Tracked time') }}</th>
                        @if ($hasMyTime)
                            <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($times as $time)
                        <tr>
                            <td class="align-middle">
                                <h6>{{ $time->project->name }}</h6>
                                {{ $time->activity->name }} &mdash; <span class="text-muted">{{ $time->description }}</span>
                            </td>
                            <td class="align-middle">{{ $time->user->getFirstName() }}</td>
                            <td class="align-middle text-nowrap text-right">
                                <h6 title="{{ $time->started }} - {{ $time->finished }}">
                                    <samp>{{ $time->getTrackedTime() ?: '-' }}</samp>
                                </h6>
                                <small class="text-muted">
                                    <samp>{{ $time->started->format('Y-m-d') }}</samp>
                                </small>
                            </td>
                            @if ($hasMyTime)
                                <td class="align-middle text-right">
                                    @if ($time->user_id === auth()->user()->id && $time->finished)
                                        <a href="#" class="btn btn-link">Edit</a>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $times->withQueryString()->links() }}
        @endif
    </div>
@endsection

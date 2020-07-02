@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <button class="btn btn-primary" data-toggle="modal" data-target="#create-time">{{ __('New time entry') }}</button>
            </div>
            <div class="col-auto ml-auto">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#report-options" aria-expanded="false" aria-controls="report-options">{{ __('Report options') }}</button>
            </div>
        </div>

        <div class="card collapse" id="report-options">
            <form class="card-body" action="{{ route('times.index') }}" method="get">
                <div class="row">
                    <div class="col-md-8">
                        <h5>{{ __('Custom filter') }}</h5>
                        <div class="form-row">
                            <div class="form-group col">
                                <label>{{ __('Project') }}</label>
                                <select class="custom-select">
                                    <option>{{ __('Select') }}</option>
                                    <option disabled>--</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col">
                                <label>{{ __('Activity') }}</label>
                                <select class="custom-select">
                                    <option>{{ __('Select') }}</option>
                                    <option disabled>--</option>
                                    @foreach ($activities as $activity)
                                        <option value="{{ $activity->id }}">{{ $activity->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label>{{ __('User') }}</label>
                                <select class="custom-select">
                                    <option>{{ __('Select') }}</option>
                                    <option disabled>--</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col">
                                <label>{{ __('From') }}</label>
                                <input class="form-control" type="text" placeholder="YYYY-MM-DD" />
                            </div>
                            <div class="form-group col">
                                <label>{{ __('To') }}</label>
                                <input class="form-control" type="text" placeholder="YYYY-MM-DD" />
                            </div>
                        </div>
                        <button class="btn btn-secondary">{{ __('Apply') }}</button>
                        <button class="btn btn-secondary">{{ __('Apply & Save') }}</button>
                    </div>
                    <div class="col-md-4">
                        <h5>{{ __('Load report') }}</h5>
                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <select class="custom-select" name="report_id" onchange="this.form.submit();">
                                <option value="">{{ __('My week') }}</option>
                                <option value="" disabled>--</option>
                                <option value="" disabled>{{ __('Saved reports') }}</option>
                                @foreach ($reports as $id => $name)
                                    <option value="{{ $id }}" @if (request('report_id') == $id) selected @endif>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <h2 class="pt-4 mb-4">{{ $report->name }}</h2>

        @if (count($times) === 0)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('No time tracked yet') }}</h5>
                    <p class="card-text">
                        {!! __('The current report has no time. It\'s possible to select different <a :attributes >report options</a>.', [ 'attributes' => 'href="javascript:return false" class="card-link" type="button" data-toggle="collapse" data-target="#report-options" aria-expanded="false" aria-controls="report-options"' ]) !!}
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
                                @if ($time->finished)
                                    <h6 title="{{ $time->started }} - {{ $time->finished }}">
                                        <samp>{{ $time->getTrackedTime() ?: '-' }}</samp>
                                    </h6>
                                @else
                                    <h6 title="{{ __('Started at :time', [ 'time' => $time->started ]) }}">
                                        <samp>
                                            <timer time="{{ \Carbon\Carbon::now()->diffInSeconds($time->started) }}">
                                                {{ \App\Support\Formatter::timeDiff($time->started) }}
                                            </timer>
                                        </samp>
                                    </h6>
                                @endif
                                <small class="text-muted">
                                    <samp>{{ $time->started->format('Y-m-d') }}</samp>
                                </small>
                            </td>
                            @if ($hasMyTime)
                                <td class="align-middle text-right">
                                    @if ($time->user_id === auth()->user()->id)
                                        @if ($time->finished)
                                            <a href="#" class="btn btn-link">Edit</a>
                                        @else
                                            <a href="#" class="btn btn-danger">Stop</a>
                                        @endif
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

@push('modals')
    <create-time />
@endpush

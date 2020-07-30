@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8" action="{{ route('reports.index') }}" method="get">
                <div class="card" id="report-options">
                    <filter-report :filter="{{ json_encode(request('filter')) }}"></filter-report>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" id="report-options">
                    <form class="card-body" action="{{ route('reports.index') }}" method="get">
                        <h5>{{ __('Open report') }}</h5>
                        <div class="form-group">
                            <label id="report_id">{{ __('Name') }}</label>
                            <select class="custom-select" name="report_id" id="report_id" onchange="this.form.submit();">
                                @if (request('filter'))
                                    <option value="">{{ __('Select') }}</option>
                                @endif
                                <option value="">{{ __('My week') }}</option>
                                <option value="" disabled>--</option>
                                <option value="" disabled>{{ __('Saved reports') }}</option>
                                @foreach ($reports as $id => $name)
                                    <option value="{{ $id }}" @if (request('report_id') == $id) selected @endif>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($report->code)
                            <hr>
                            <p>Use the links below to share this report with clients and other people outside the organisation.</p>
                            <dl class="mb-0">
                                <dt>Web page</dt>
                                <dd><a href="{{ route('reports.shared.show', $report->code) }}" target="_blank">{{ route('reports.shared.show', $report->code) }}</a></dd>
                                <dt>CSV file</dt>
                                <dd><a href="{{ route('reports.shared.export', $report->code) }}" target="_blank">{{ route('reports.shared.export', $report->code) }}</a></dd>
                            </dl>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col">
                <h2 class="pt-4 mb-4">{{ $report->name }}</h2>
            </div>
            @if (count($totals) > 0)
                <div class="col-auto ml-auto">
                    <button class="btn btn-link" data-toggle="modal" data-target="#report-totals">View totals</button>
                </div>
            @endif
        </div>

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
                        <th class="align-top text-right">{{ __('Tracked time') }}</th>
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
                                <h6
                                    @if ($time->finished)
                                        title="{{ $time->started->tz(auth()->user()->timezone) }} - {{ $time->finished->tz(auth()->user()->timezone) }}"
                                    @else
                                        title="{{ __('Started at :time', [ 'time' => $time->started->tz(auth()->user()->timezone) ]) }}"
                                    @endif
                                >
                                    <samp>{{ $time->getTrackedTime() ?: '-' }}</samp>
                                </h6>
                                <small class="text-muted">
                                    <samp>{{ $time->started->tz(auth()->user()->timezone)->format('Y-m-d') }}</samp>
                                </small>
                            </td>
                            @if ($hasMyTime)
                                <td class="align-middle text-right">
                                    @if ($time->user_id === auth()->user()->id && $time->finished)
                                        <a href="#"
                                            onclick="event.preventDefault();app.$emit('time-edit',{{ json_encode($time->attributesToArray()) }})"
                                            class="btn btn-link">Edit</a>
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
    @if (count($totals) > 0)
        <div class="modal fade" ref="modal" id="report-totals" tabindex="-1" role="dialog" aria-labelledby="report-total-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="report-totals-label">Totals for {{ $report->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-0 pb-0">
                        <table class="table mb-0">
                            <thead class="sr-only">
                                <tr>
                                    <th class="align-top">{{ __('Activity') }}</th>
                                    <th class="align-top text-right">{{ __('Tracked time') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($totals as $name => $total)
                                    <tr>
                                        <td class="align-middle @if ($loop->first) border-top-0 @endif">{{ $name }}</td>
                                        <td class="align-middle text-right @if ($loop->first) border-top-0 @endif">
                                            <samp>{{ $total }}</samp>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="align-middle">{{ __('Total') }}</th>
                                    <th class="align-middle text-right">
                                        <samp>{{ $grandTotal }}</samp>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <create-report></create-report>
    <edit-time></edit-time>
@endpush

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-4">
            <button class="btn btn-primary" data-toggle="modal" data-target="#create-time">{{ __('New time entry') }}</button>
        </div>

        <h2 class="pt-4 mb-4">{{ $report->name }}</h2>

        @if (count($times) === 0)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('No time tracked yet') }}</h5>
                    <p class="card-text">
                        {!! __('You have still not tracked any time this week. Go ahead and <a :attributes >add a time entry</a>.', [ 'attributes' => 'href="javascript:return false" data-toggle="modal" data-target="#create-time"' ]) !!}
                    </p>
                    <blockquote class="blockquote mb-0 mt-5">
                        <p class="mb-0">{{ __('It is the time you have wasted for your rose that makes your rose so important.') }}</p>
                        <footer class="blockquote-footer">{{ __('Antoine de Saint-Exupéry') }}, <cite title="Source Title">{{ __('The Little Prince') }}</cite></footer>
                    </blockquote>
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
                                            <stopwatch time="{{ \Carbon\Carbon::now()->diffInSeconds($time->started) }}">
                                                {{ \App\Support\Formatter::timeDiff($time->started) }}
                                            </stopwatch>
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
                                            <a href="#"
                                                onclick="event.preventDefault();app.$emit('time-edit',{{ json_encode($time->attributesToArray()) }})"
                                                class="btn btn-link">Edit</a>
                                        @else
                                            <a href="{{ route('times.stop', $time) }}" class="btn btn-danger btn-stopwatch">Stop</a>
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
    <create-time></create-time>
    <edit-time></edit-time>
@endpush

@extends('layouts.app')

@section('content')
    <div class="container">
        <button class="btn btn-primary">New time entry</button>

        <form action="{{ route('times.index') }}" method="get">
            <select class="custom-select" name="report_id" onchange="this.form.submit();">
                <option value="">My week</option>
                <option value="" disabled>--</option>
                <option value="" disabled>Saved reports</option>
                @foreach ($reports as $id => $name)
                    <option value="{{ $id }}" @if (request('report_id') == $id) selected @endif>{{ $name }}</option>
                @endforeach
            </select>
        </form>

        <h1>{{ $report->name }}</h1>

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

@extends('layouts.app')

@push('head')
    <script>
        var CURRENT_TIMESTAMP = Date.now();
    </script>
@endpush

@section('content')
    <div class="d-flex align-items-center my-3">
        <!-- Add time manually button -->
        <button type="button" class="btn btn-outline-success btn-sm mx-2" data-toggle="modal" data-target="#manual">
            Add time manually
        </button>
        @include("time.manually-modal")
        <!-- Create project button -->
        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#createProjectModal">
          Create project
        </button>
        @include("time.project-modal")
    </div>

    <!-- Table with projects -->
    <table class="table table-hover pt-3">
        <thead>
            <tr>
                <th class="align-middle">Project</th>
                <th class="align-middle text-right">Total</th>
                <th class="align-middle stop_time start">Start</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td class="align-middle">{{ $project->name }}</td>
                    <td class="align-middle text-right">
                        <samp>
                            {{ ($total = $project->getTrackedTime()) ? App\Support\Formatter::intervalTime($total) : '-' }}
                        </samp>
                    </td>
                    @if ($time = $project->getUnfinishedTime())
                        <td class="align-middle">
                            <form action="{{ route('auto.update', $time->id) }}" method="post" class="time-stop">
                                @php
                                    $diff = App\Support\Formatter::interval($time->started->diffAsCarbonInterval());
                                @endphp
                                {{ csrf_field() }}
                                {{ method_field('put') }}
                                <button
                                    type="submit"
                                    class="btn btn-outline-danger btn-sm"
                                    data-started="{{ $diff }}"
                                >
                                    {{ $diff }}
                                </button>
                            </form>
                        </td>
                    @else
                        @php
                            $showError = $project->id == old('project_id');
                        @endphp
                        <td class="align-middle time_stop">
                            <!-- Start work button  -->
                            <button type="button" class="btn btn-outline-success btn-sm lets" data-toggle="modal" data-target="#automatic-{{ $project->id }}">
                                Let's work!
                            </button>
                            @include("time.work-modal")
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

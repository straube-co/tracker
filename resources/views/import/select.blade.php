@extends('layouts.header')

@section('content')
    <form action="{{ route('import.update', $project->id) }}" method="post">
    {{ csrf_field() }}
    {{ method_field('put') }}
        <h1>Project: {{ $project->name }}</h1>
        <br>
        <div>
            <h6>Múltipla seleção:</h6>
            <select id="task" name="task_id">
                <option value="">Select</option>
                @foreach ($tasks as $task)
                    <option value="{{ $task->id }}"> {{ $task->name }}</option>
                @endforeach
            </select>
            <select id="activity" name="activity_id">
                <option value="">Select</option>
                @foreach ($activities as $activity)
                    <option value="{{ $activity->id }}"> {{ $activity->name }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Name</th>
                    <th>Tasks</th>
                    <th>Activities</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lines as $line)
                    <tr>
                        <td>
                            <input type="checkbox">
                        </td>
                        <td>
                            {{ $line[0] }}
                            {{-- creating JSON with line --}}
                            <input type="hidden" name="time[{{ $loop->index }}][line]" value="{{ json_encode($line) }}"/>
                        </td>
                        <td>
                            {{-- $loop / help in organizing the array $time[] --}}
                            <select id="task" name="time[{{ $loop->index }}][task_id]">
                                <option value="">Select</option>
                                @foreach ($tasks as $task)
                                    <option value="{{ $task->id }}"> {{ $task->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select id="Activity" name="time[{{ $loop->index }}][activity_id]">
                                <option value="">Select</option>
                                @foreach ($activities as $activity)
                                    <option value="{{ $activity->id }}"> {{ $activity->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <button class="btn btn-success btn-sm" type="submit">Salvar </button>
        <a class="btn btn-danger btn-sm" href="{{ route('report.index')}}">Cancel</a>
    </form>
@endsection

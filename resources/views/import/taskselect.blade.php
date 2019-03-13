@extends('layouts.header')

@section('content')
    <form action="{{ route('import.update', $project->id) }}" method="post">
    {{ csrf_field() }}
    {{ method_field('put') }}
        <h1>Project: {{ $project->name }}</h1>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Tasks</th>
                    <th>Activities</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lines as $line)
                    <tr>
                        <td>
                            {{ $line[0] }}
                            <input type="hidden" name="time[{{ $loop->index }}][line]" value="{{ json_encode($line) }}"/>
                        </td>
                        <td>
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
        <button type="submit">Salvar </button>
    </form>
@endsection

@extends('layouts.header')

@section('content')
    <div class="container">
        <form action="{{ route('import.update', $project->id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <h1 class="mt-4 mb-4">Project: {{ $project->name }}</h1>
            <div>
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
                <button class="btn btn-outline-success btn-sm ml-2" name="apply" type="button">Aplicar </button>
            </div>
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th class="align-middle"><input type="checkbox" class="select-all"></th>
                        <th class="align-middle">Name</th>
                        <th class="align-middle">Tasks</th>
                        <th class="align-middle">Activities</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lines as $line)
                        <tr>
                            <td class="align-middle">
                                <input type="checkbox" name="check" class="list-item-checkbox" data-index="{{ $loop->index }}">
                            </td>
                            <td class="align-middle">
                                {{ $line[0] }}
                                {{-- creating JSON with line --}}
                                <input type="hidden" name="time[{{ $loop->index }}][line]" value="{{ json_encode($line) }}"/>
                            </td>
                            <td class="align-middle">
                                {{-- $loop / help in organizing the array $time[] --}}
                                <select id="task" name="time[{{ $loop->index }}][task_id]">
                                    <option value="">Select</option>
                                    @foreach ($tasks as $task)
                                        <option value="{{ $task->id }}"> {{ $task->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="align-middle">
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
            <div class="mt-5 mb-5">
                <button class="btn btn-outline-success btn-sm mr-2" type="submit">Salvar </button>
                <a class="btn btn-outline-danger btn-sm" href="{{ route('import.index')}}">Cancel</a>
            </div>
        </div>
    </form>
@endsection

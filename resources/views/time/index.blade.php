@extends('layouts.header')
<?php
use Carbon\Carbon;
?>
@section('content')
<ul>
    @foreach ($times as $time)
        <a class ="btn btn-outline-dark btn-sm" href="{{ route('time.create') }}">Add Manual Time Entry</a><br><br>
        @if($time->finished == NULL)    {{-- validation automatic time counting  --}}
            <p style="color:red">Stop your time for start automatic Time Counting</p>
        @else
            <a class ="btn btn-outline-dark btn-sm" href="{{ route('auto.create') }}">Start Automatic Time Counting</a><br><br>
        @endif
        @break;
    @endforeach
    <h1>Activities</h1>
    <br>
    <li>
        <table class="table">
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Task</th>
                    <th>Activity</th>
                    <th>Started</th>
                    <th>Finished</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($times as $time)
                    <tr>
                        <td>{{ $time->task->project->name }}</td>
                        <td>{{ $time->task->name }}</td>
                        <td>{{ $time->activity->name }}</td>
                        <td>{{ $time->started }}</td>
                        <td>{{ $time->finished }}</td>
                        @if($time->finished == NULL)
                            <td>
                                <form action="{{ route('auto.update', $time->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}
                                    <?php
                                    echo Carbon::now()->diffInSeconds($time->started);
                                    ?>
                                    <button type="submit" class="btn btn-danger btn-sm stop">Stop </button>
                                </form>
                            </td>
                        @else
                            <td><a class="btn btn-secondary btn-sm" href="{{ route('time.edit', $time->id) }}">Edit</a></td>
                        @endif
                        <td>
                            <form action="{{ route('time.destroy', $time->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                                <button class="btn btn-danger btn-sm" type="submit">Delete </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </li>
</ul>
@endsection

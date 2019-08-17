@extends('layouts.app')

@section('content')
    <h1 class="mt-4 mb-4">Roles</h1>
    <form action="{{route('user.store')}}" method="post">
        {{ csrf_field() }}
        <table class="table pt-3">
            <thead>
                <tr>
                    <th class="align-middle">User</th>
                    <th class="align-middle">Settings</th>
                    <th class="align-middle">Reports</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="align-middle">{{$user->name}}</td>
                        <td class="align-middle"><input name="access[{{ $user->id }}][]" type="checkbox" value="1" @if (in_array(1, $user->access())) checked @endif></td>
                        <td class="align-middle"><input name="access[{{ $user->id }}][]" type="checkbox" value="2" @if (in_array(2, $user->access())) checked @endif></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right">
            <button type="submit" class="btn btn-outline-success btn-sm" name="button">Save</button>
        </div>
    </form>
@endsection

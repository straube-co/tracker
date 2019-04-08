@extends('layouts.header')

@section('content')
    <form action="{{ route('import.store') }}" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        <div>
            <input type="file" name="import_file"/>
            <br>
            <br>
            <label for="project">Project: </label>
            <select id="project" name="project_id">
                <option value="">Select</option>
                @foreach ($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <button type="submit" class="btn btn-primary btn-sm">Importar arquivo </button>
    </form>
@endsection

@extends('layouts.header')

@section('content')
    <form action="{{ route('import.store') }}" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <input type="file" name="import_file"/>
        </div>
        <div class="form-group">
            <label for="importproject">Project: </label>
            <select class="custom-select" id="importproject" name="project_id">
                <option value="">Select</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success btn-sm">Import file</button>
            <a class="btn btn-danger btn-sm" href="{{ route('time.index')}}">Cancel</a>
        </div>
    </form>
@endsection

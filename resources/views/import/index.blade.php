@extends('layouts.header')

@section('content')
    <div class="container mt-5">
        <form action="{{ route('import.store') }}" enctype="multipart/form-data" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="file" name="import_file" required/>
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
                <a class="btn btn-outline-danger btn-sm" href="{{ route('time.index')}}">Cancel</a>
                <button type="submit" class="btn btn-outline-success btn-sm">Import file</button>
            </div>
        </form>
    </div>
@endsection

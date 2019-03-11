@extends('layouts.header')

@section('content')
    <form method="post">
        <input type="file" name="import_file"/>
        <br>
        <br>
        <button type="submit" style="background-color: lightsteelblue;" class="btn btn-primário">Importar arquivo </button>
    </form>
@endsection

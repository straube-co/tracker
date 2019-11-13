@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="text-center mb-4">Folha ponto - {{ $user->name }}</h3>
        <div class="table-responsive">
            <table class="table pt-3">
                <thead>
                    <tr>
                        <th class="align-middle">Data</th>
                        <th class="align-middle">Entrada</th>
                        <th class="align-middle">Saída</th>
                        <th class="text-right">Assinatura do funcionário</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $schedule)
                        <tr>
                            <td class="align-middle">{{ $schedule->started->format('d/m/Y') }}</td>
                            <td class="align-middle">{{ $schedule->started->format('h:m:s') }}</td>
                            <td class="align-middle">{{ $schedule->finished->format('h:m:s') }}</td>
                            <td class="align-middle">
                                <input class="form-control ml-auto signature" type="text" name="signature">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <hr>
        <footer>
            <div class="d-flex align-items-center">
                <p class="mr-3 mb-0">Assinatura do empregador:</p>
                <input class="form-control signature" type="text" name="signature">
            </div>
        </footer>
    </div>
@endsection

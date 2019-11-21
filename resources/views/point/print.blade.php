@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="text-center mb-4">Folha de ponto mensal - {{ $user->name }}</h3>
        <div class="table-responsive">
            <table class="table pt-3">
                <thead>
                    <tr>
                        <th class="align-middle">Data</th>
                        <th class="align-middle">Entrada</th>
                        <th class="align-middle">Saída</th>
                        <th class="align-middle">Entrada</th>
                        <th class="align-middle">Saída</th>
                        <th class="text-right">Assinatura do funcionário</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $date = null;
                        $i = 0;
                    @endphp
                    @foreach ($schedules as $schedule)
                        @if ($schedule->started->format('d/m/Y'))
                            @php
                                $i++;
                            @endphp
                        @endif
                        @if ($schedule->started->format('d/m/Y') !== $date)
                            @php
                                $date = $schedule->started->format('d/m/Y');
                            @endphp
                            @if (!$loop->first && $schedule->started->format('d/m/Y') == $date && $i <= 1)
                                <td class="align-middle">- -</td>
                                <td class="align-middle">- -</td>
                            @endif
                            @if (!$loop->first)
                                    <td class="align-middle">
                                        <input class="form-control ml-auto signature" type="text" name="signature">
                                    </td>
                                    @php
                                        $i = 0;
                                    @endphp
                                </tr>
                            @endif
                            <tr>
                                <td class="align-middle">{{ $schedule->started->format('d/m/Y') }}</td>
                        @endif
                            <td class="align-middle">{{ $schedule->started->format('H:i:s') }}</td>
                            <td class="align-middle">{{ $schedule->finished->format('H:i:s') }}</td>
                    @endforeach
                        <td class="align-middle">
                            <input class="form-control ml-auto signature" type="text" name="signature">
                        </td>
                    </tr>
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

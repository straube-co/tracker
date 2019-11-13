<div class="container-fluid">
    <h1>Folha ponto - {{ $user->name }}</h1>
    <hr>
    @foreach ($schedules as $schedule)
        <p>{{$schedule->started}} / {{$schedule->finished}}</p>
    @endforeach
</div>

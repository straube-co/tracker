<div class="container">
    <form action="{{ route('time.store') }}" method="post">
    {{ csrf_field() }}
        <div>
            <label for="name">Project: </label>
            <input type="text" name="name" value="{{old('name')}}" required>
            {{ $errors->first('name') }}
        </div>
        <br>
        <div>
            <label for="name">Task: </label>
            <input type="text" name="name" value="{{old('name')}}" required>
        </div>
        <br>
        <div>
            <label for="memory">I started my work: </label>
            <input type="number" name="started" required>
        </div>
        <br>
        <div>
            <label for="storage">I finished my work: </label>
            <input type="number" name="finished" required>
        </div>
        <br>
        <div>
            <button type="submit">Create </button>
        </div>
    </form>
</div>

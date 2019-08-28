@php
    $id = $activity->id ?? 0;
    $edit = $id > 0;
    $submitted = old('activity_id') === 'activity_' . $id;
    $old = $submitted ? old() : [];
    $default = $activity ?? new App\Activity();
@endphp
<div class="modal fade" id="{{ $edit ? 'edit-' . $id : 'activity' }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@if ($edit) Edit activity @else Create activity @endif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ $edit ? route('activity.update', $id) : route('activity.store') }}" method="post">
                {{ csrf_field() }}
                @if ($edit)
                    {{ method_field('put') }}
                @endif
                <div class="modal-body">
                    <div>
                        <label>Name: </label>
                        <input type="text" class="form-control @if ($submitted && $errors->has('name')) is-invalid @endif" name="name" value="{{ array_get($old, 'name', $default->name) }}">
                        @if ($submitted)
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="activity_id" value="activity_{{ $id }}">

                    @if ($edit && !$activity->activityUsed())
                        <button class="btn btn-danger btn-sm mr-auto btn-delete-activity" type="button" data-activity="{{ $id }}">Delete </button>
                    @endif
                    <a class="btn btn-outline-danger btn-sm" href="{{ route('activity.index')}}">Cancel</a>
                    <button class="btn btn-outline-success btn-sm" type="submit">Save </button>
                </div>
            </form>
            <form action="{{ route('activity.destroy', $id) }}" method="post" id="activity_delete-{{ $id }}">
                {{ method_field('delete') }}
                {{ csrf_field() }}
            </form>
        </div>
    </div>
</div>

@php
    $submitted = old('report_id') === 'report_0';
@endphp
<div class="modal fade" id="share" tabindex="-1" role="dialog" aria-labelledby="modalShare" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalShare">Save & Share</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input class="form-control @if ($submitted && $errors->has('name')) is-invalid @endif" type="text" name="name">
                    @if ($submitted)
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="report_id" value="report_0">
                <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-outline-success btn-sm" id="btn_share">Create</button>
            </div>
        </div>
    </div>
</div>

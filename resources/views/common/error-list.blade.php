<!-- error list -->
<div class="all-errors alert alert-danger" style="{!! $errors->any() ? '' : 'display: none' !!}">
    @foreach ($errors->all() as $error)
    <div class="block-error">
        <i class="fa fa-exclamation" aria-hidden="true"></i>
        <label class="control-label">
            {{ $error }}
        </label>
    </div>
    @endforeach
</div>
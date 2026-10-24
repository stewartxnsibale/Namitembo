@if (session('status'))
    <div class="alert" data-dismissible role="status">
        <svg class="icon"><use href="#icon-check-circle"></use></svg>
        <span>{{ session('status') }}</span>
        <button type="button" class="icon-btn" data-dismiss aria-label="Dismiss message" style="margin-left:auto;width:28px;height:28px">
            <svg class="icon icon-sm"><use href="#icon-x"></use></svg>
        </button>
    </div>
@endif

@if ($errors->any() && ! $errors->hasBag('userDeletion'))
    <div class="alert alert-danger" data-dismissible role="alert">
        <svg class="icon"><use href="#icon-info"></use></svg>
        <div>
            <strong style="display:block;margin-bottom:2px">Please check the form below.</strong>
            <span>{{ $errors->first() }}</span>
        </div>
        <button type="button" class="icon-btn" data-dismiss aria-label="Dismiss message" style="margin-left:auto;width:28px;height:28px">
            <svg class="icon icon-sm"><use href="#icon-x"></use></svg>
        </button>
    </div>
@endif

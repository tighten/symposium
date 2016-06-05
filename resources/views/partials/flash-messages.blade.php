@if (Session::has('success-message') || Session::has('error-message') || Session::has('message'))
    <div class="container">
        @if(Session::has('success-message'))
            <div class="notice notice-success" onClick="$(this).remove();" data-dismiss="timeout">
                {{ Session::get('success-message') }}
            </div>
        @endif
        @if(Session::has('error-message'))
            <div class="notice notice-error" onClick="$(this).remove();" data-dismiss="timeout">
                {{ Session::get('error-message') }}
            </div>
        @endif
        @if(Session::has('message'))
            <div class="notice notice-info" onClick="$(this).remove();" data-dismiss="timeout">
                {{ Session::get('message') }}
            </div>
        @endif
    </div>
@endif

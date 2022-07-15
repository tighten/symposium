@if (Session::has('success-message'))
    <x-notice.success>
        {{ Session::get('success-message', 'success') }}
    </x-notice.success>
@endif

@if (Session::has('error-message'))
    <x-notice.error>
        {{ Session::get('error-message') }}
    </x-notice.error>
@endif

@if (Session::has('message'))
    <x-notice.info>
        {{ Session::get('message') }}
    </x-notice.info>
@endif

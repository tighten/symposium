@props([
    'action',
    'upload' => false,
])

<form
    method="POST"
    action="{{ $action }}"
    {{ $attributes->except('method') }}
    @if ($upload) enctype="multipart/form-data" @endif
>
    @unless ($attributes->get('method', 'POST') == 'POST')
        @method($attributes->get('method'))
    @endunless
    @csrf
    {{ $slot }}
</form>

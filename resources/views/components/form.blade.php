@props(['upload' => false])

<form
    method="POST"
    {{ $attributes->except('method') }}
    @if ($upload) enctype="multipart/form-data" @endif
>
    @unless ($attributes->get('method', 'POST') == 'POST')
        @method($attributes->get('method'))
    @endunless
    @csrf
    {{ $slot }}
</form>

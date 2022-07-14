

<div
    {{ $attributes->class([
        'cursor-pointer fixed inset-x-0 lg:inset-x-auto mx-auto p-4 lg:right-4 rounded text-center top-32 w-4/5 lg:w-1/5 z-50'
    ]) }}
    data-dismiss="timeout"
    onClick="$(this).remove();"
>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    {{ $slot }}
</div>

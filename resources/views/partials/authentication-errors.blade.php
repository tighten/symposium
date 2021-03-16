@if ($errors->count() > 0)
<div class="text-red-500">
    @foreach ($errors->all() as $error)
        {{ $error }}<br>
    @endforeach
</div>
@endif

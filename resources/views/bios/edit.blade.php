@extends('app', ['title' => 'Edit Bio'])

@section('content')

<ul class="text-red-500">
    @foreach ($errors->all() as $message)
        <li>{{ $message }}</li>
    @endforeach
</ul>

<x-form :action="route('bios.update', $bio->id)" method="PUT">
    <x-panel size="xl">
        @include('bios.form')
    </x-panel>

    <x-button.primary
        type="submit"
        size="md"
        class="mt-8"
    >
        Update
    </x-button.primary>
</x-form>

@endsection

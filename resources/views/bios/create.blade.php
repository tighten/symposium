@extends('app', ['title' => 'Add Bio'])

@section('content')

<ul class="text-red-500">
    @foreach ($errors->all() as $message)
        <li>{{ $message }}</li>
    @endforeach
</ul>

<x-form :action="route('bios.store')">
    <x-panel size="xl">
        @include('bios.form')
    </x-panel>

    <x-button.primary
        type="submit"
        size="md"
        class="mt-8"
    >
        Create
    </x-button.primary>
</x-form>

@endsection

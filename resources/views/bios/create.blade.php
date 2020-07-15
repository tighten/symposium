@extends('layout', ['title' => 'Add Bio'])

@section('content')

<x-panel>
    <ul class="errors">
        @foreach ($errors->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>

    <x-form :action="route('bios.store')">
        @include('partials.bioform')

        <x-button.primary
            type="submit"
            size="md"
            class="mt-8"
        >
            Create
        </x-button.primary>
    </x-form>
</x-panel>

@endsection

@extends('layout', ['title' => 'Edit Bio'])

@section('content')

<x-panel>
    <ul class="text-red-500">
        @foreach ($errors->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>

    <x-form :action="route('bios.update', $bio->id)" method="PUT">
        @include('partials.bioform')

        <x-button.primary
            type="submit"
            size="md"
            class="mt-8"
        >
            Update
        </x-button.primary>
    </x-form>
</x-panel>

@endsection

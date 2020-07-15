@extends('layout', ['title' => 'Create Conference'])

@section('content')

<x-panel class="max-w-md mx-auto sm:max-w-3xl mt-4">
    <ul class="errors">
        @foreach ($errors->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>

    <x-form :action="route('conferences.store')">
        @include('partials.conferenceform')

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

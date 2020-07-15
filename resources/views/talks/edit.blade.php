@extends('layout', ['title' => 'Edit Talk'])

@section('content')

<x-panel class="max-w-md mx-auto sm:max-w-3xl mt-4">
    <ul class="errors">
        @foreach ($errors->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>

    <x-form :action="route('talks.update', $current->talk_id)" method="PUT">
        @include('partials.talk-version-form')

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

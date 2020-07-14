@extends('layout', ['title' => 'Edit Conference'])

@section('content')

<div class="px-10 py-3 max-w-md mx-auto sm:max-w-3xl border-2 border-indigo-200 bg-white rounded mt-4">
    <ul class="errors">
        @foreach ($errors->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>

    <x-form :action="route('conferences.update', $conference->id)" method="PUT">
        @include('partials.conferenceform')

        @if (auth()->user()->isAdmin())
            <x-input.radios
                name="is_approved"
                label="Conference Is Approved?"
                :value="$conference->is_approved"
                :options="[
                    'Yes' => '1',
                    'No' => '0',
                ]"
                class="mt-8"
            ></x-input.radios>
        @endif

        <x-button.primary
            type="submit"
            size="md"
            class="mt-8"
        >
            Update
        </x-button.primary>
    </x-form>
</div>

@endsection

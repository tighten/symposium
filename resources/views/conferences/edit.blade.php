@extends('app', ['title' => 'Edit Conference'])

@section('content')

<ul class="text-red-500">
    @foreach ($errors->all() as $message)
        <li>{{ $message }}</li>
    @endforeach
</ul>

<x-form :action="route('conferences.update', $conference->id)" method="PUT">
    <x-panel size="xl">
        @include('conferences.form')

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

@extends('app', ['title' => 'Create Conference'])

@section('content')

<ul class="text-red-500">
    @foreach ($errors->all() as $message)
        <li>{{ $message }}</li>
    @endforeach
</ul>

<x-form :action="route('conferences.store')">
    <x-panel>
        @include('conferences.form')
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

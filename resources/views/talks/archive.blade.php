@extends('layout', ['title' => 'My Archived Talks'])

@php
    $linkRouteKeysWithDefaults = ['filter' => 'active', 'sort' => 'alpha'];
    $inactiveLinkClasses = 'filter-link py-1 px-5 hover:bg-indigo-100';
@endphp

@section('content')

<div class="flex flex-col md:flex-row py-3 max-w-md mx-auto sm:max-w-3xl">
    <div class="w-full md:w-1/4">
        <div class="flex md:flex-col md:items-center">
            <x-panel size="sm" class="w-1/2 md:w-full font-sans">
                <div class="bg-indigo-150 p-5">Filter</div>
                <div class="flex flex-col py-4">
                    <a href="{{ route('talks.index') }}" class="{{ $inactiveLinkClasses }}">Active</a>
                    {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'talks.archived.index', 'Archived', ['filter' => 'active'], ['class' => $inactiveLinkClasses]) !!}
                </div>
            </x-panel>

            <x-panel size="sm" class="w-1/2 md:w-full ml-4 md:ml-0 mt-4">
                <div class="bg-indigo-150 p-5">Sort</div>
                <div class="flex flex-col py-4">
                    {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'talks.archived.index', 'Title', ['sort' => 'alpha'], ['class' => $inactiveLinkClasses]) !!}
                    {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'talks.archived.index', 'Date', ['sort' => 'date'], ['class' => $inactiveLinkClasses]) !!}
                </div>
            </x-panel>
        </div>
        <x-button.primary
            :href="route('talks.create')"
            icon="plus"
            class="block mt-4 w-full"
        >
            Add Talk
        </x-button.primary>
    </div>
    <div class="w-full md:w-3/4 md:ml-4">
        @each('talks.listing', $talks, 'talk', 'talks.listing-empty')
    </div>
</div>

@endsection

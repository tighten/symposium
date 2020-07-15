@extends('layout', ['title' => 'My Archived Talks'])

@php
    $linkRouteKeysWithDefaults = ['filter' => 'active', 'sort' => 'alpha'];
    $inactiveLinkClasses = 'filter-link p-1 rounded';
@endphp

@section('content')

<div class="flex flex-col md:flex-row py-3 max-w-md mx-auto sm:max-w-3xl">
    <div class="w-full md:w-1/4">
        <div class="flex md:flex-col md:items-center">
            <x-panel class="w-1/2 md:w-full mt-4 font-sans">
                <div class="bg-indigo-150 p-4">Filter</div>
                <div class="flex flex-col p-4">
                    <a href="{{ route('talks.index') }}" class="{{ $inactiveLinkClasses }}">Active</a>
                    {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'talks.archived.index', 'Archived', ['filter' => 'active'], ['class' => $inactiveLinkClasses]) !!}
                </div>
            </x-panel>

            <x-panel class="w-1/2 md:w-full ml-4 md:ml-0 mt-4">
                <div class="bg-indigo-150 p-4">Sort</div>
                <div class="flex flex-col p-4">
                    {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'talks.archived.index', 'Title', ['sort' => 'alpha'], ['class' => $inactiveLinkClasses]) !!}
                    {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'talks.archived.index', 'Date', ['sort' => 'date'], ['class' => $inactiveLinkClasses]) !!}
                </div>
            </x-panel>
        </div>
        <a href="{{ route('talks.create') }}"
           class="mt-4 w-full bg-indigo-500 text-white rounded px-4 py-2 block text-center">
           Add Talk @svg('plus', 'ml-2 w-3 h-3 inline fill-current')
        </a>
    </div>
    <div class="w-full md:w-3/4 md:ml-4">
        @each('partials.talk-in-list', $talks, 'talk', 'talks.listing-empty')
    </div>
</div>

@endsection

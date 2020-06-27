@extends('layouts.index', ['title' => 'My Talks'])

@php
    $linkRouteKeysWithDefaults = ['filter' => 'active', 'sort' => 'alpha'];
    $inactiveLinkClasses = 'filter-link p-1 rounded';
@endphp

@section('content')

@section('sidebar')
    <div class="flex md:flex-col">
        <div class="w-1/2 md:w-full border-2 border-indigo-200 bg-white rounded mt-4 font-sans">
            <div class="bg-indigo-150 p-4">Filter</div>
            <div class="flex flex-col p-4">
                {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'talks.index', 'Active', ['filter' => 'active'], ['class' => $inactiveLinkClasses]) !!}
                <a href="{{ route('talks.archived.index') }}" class="{{ $inactiveLinkClasses }}">Archived</a>
            </div>
        </div>

        <div class="w-1/2 md:w-full ml-4 md:ml-0 border-2 border-indigo-200 bg-white rounded mt-4">
            <div class="bg-indigo-150 p-4">Sort</div>
            <div class="flex flex-col p-4">
                {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'talks.index', 'Title', ['sort' => 'alpha'], ['class' => $inactiveLinkClasses]) !!}
                {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'talks.index', 'Date', ['sort' => 'date'], ['class' => $inactiveLinkClasses]) !!}
            </div>
        </div>
    </div>
    <a href="{{ route('talks.create') }}"
       class="mt-4 w-full bg-indigo-500 text-white rounded px-4 py-2 block text-center">
       Add Talk @svg('plus', 'ml-2 w-3 h-3 inline fill-current')
    </a>
@endsection

@section('list')
    @each('partials.talk-in-list', $talks, 'talk', 'partials.talk-in-list-empty')
@endsection

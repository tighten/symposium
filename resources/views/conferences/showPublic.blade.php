@extends('layout')

@section('content')

<x-panel class="max-w-md mx-auto sm:max-w-3xl mt-4">
    <h2 class="m-0 font-sans text-2xl">
        {{ $conference->title }}
    </h2>
    <div class="mt-8 font-sans">
        @unless (empty($conference->location))
            <div class="text-gray-500">Location:</div>
            {{ $conference->location }}
        @endunless

        <div class="text-gray-500 mt-4">URL:</div>
        <a href="{{ $conference->url }}">{{ $conference->url }}</a>

        <div class="text-gray-500 mt-4">Description:</div>
        {!! str_replace("\n", "<br>", $conference->description) !!}</p>
    </div>
    <x-slot name="footer">
        <div>
            <div class="text-gray-500">Dates</div>
            <div>{{ $conference->startsAtDisplay() }} <span class="text-gray-500">to</span> {{ $conference->endsAtDisplay() }}</div>
        </div>
        @if ($conference->cfp_starts_at && $conference->cfp_ends_at)
            <div>
                <div class="text-gray-500">CFP</div>
                <div>{{ $conference->cfpStartsAtDisplay() }} <span class="text-gray-500">to</span> {{ $conference->cfpEndsAtDisplay() }}</div>
            </div>
        @endif
        <div>
            <div class="text-gray-500">Created</div>
            <div>{{ $conference->created_at->toFormattedDateString() }}</div>
        </div>
    </x-slot>
</x-panel>

@endsection

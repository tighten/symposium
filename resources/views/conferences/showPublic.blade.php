@extends('layout')

@section('content')

<div class="max-w-md mx-auto sm:max-w-3xl border-2 border-indigo-200 rounded mt-4">
    <div class="bg-white p-10">
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
    </div>
    <div class="bg-indigo-150 px-10 py-3 font-sans flex justify-between">
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
    </div>
</div>

@endsection

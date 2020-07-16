@extends('app')

@section('headerScripts')
<script>
    Symposium.talks = {!! json_encode($talks) !!};
</script>
@endsection

@section('content')

<x-panel>
    <div class="flex items-center justify-between">
        <h2 class="m-0 font-sans text-2xl">
            {{ $conference->title }}
            @if (! $conference->is_approved)
                <span style="color: red;">[NOT APPROVED]</span>
            @endif
        </h2>
        <div class="text-indigo-500 text-lg">
            @if ($conference->author_id == Auth::user()->id || auth()->user()->isAdmin())
                <a href="{{ route('conferences.edit', $conference) }}" title="Edit">
                    @svg('compose', 'w-5 fill-current inline')
                </a>
                <a href="{{ route('conferences.delete', ['id' => $conference->id]) }}" class="ml-3" title="Delete">
                    @svg('trash', 'w-5 fill-current inline')
                </a>
            @endif
        </div>
    </div>

    <div class="mt-8 font-sans">
        @unless (empty($conference->location))
            <div class="text-gray-500">Location:</div>
            {{ $conference->location }}
        @endunless

        <div class="text-gray-500 mt-4">URL:</div>
        <a href="{{ $conference->url }}">{{ $conference->url }}</a>

        @if ($conference->cfp_url)
            <div class="text-gray-500 mt-4">URL for CFP page:</div>
            <a href="{{ $conference->cfp_url }}">{{ $conference->cfp_url }}</a></p>
        @endif

        <div class="text-gray-500 mt-4">Description:</div>
        <!-- TODO: Figure out how we will be handling HTML/etc. -->
        {!! str_replace("\n", "<br>", $conference->description) !!}</p>
    </div>
    <hr class="my-4">
    <talks-on-conference-page conference-id="{{ $conference->id }}"></talks-on-conference-page>
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

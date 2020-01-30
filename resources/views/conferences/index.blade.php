@extends('layout', ['title' => 'Conferences'])

@section('content')

<div class="flex py-3 max-w-md mx-auto sm:max-w-3xl">
    <div class="w-1/4">
        @php
            $linkRouteKeysWithDefaults = ['filter' => 'future', 'sort' => 'closing_next'];
            $inactiveLinkClasses = 'filter-link p-1 rounded';
        @endphp

        <div class="border-2 border-indigo-200 rounded mt-4 font-sans">
            <div class="bg-indigo-150 p-4">Filter</div>
            <div class="bg-white flex flex-col p-4">
                {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Future', ['filter' => 'future'], ['class' => $inactiveLinkClasses]) !!}
                {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'CFP is Open', ['filter' => 'open_cfp'], ['class' => $inactiveLinkClasses]) !!}
                {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Unclosed CFP', ['filter' => 'unclosed_cfp'], ['class' => $inactiveLinkClasses]) !!}
                @if (Auth::check())
                    {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Favorites', ['filter' => 'favorites'], ['class' => $inactiveLinkClasses]) !!}
                    {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Dismissed', ['filter' => 'dismissed'], ['class' => $inactiveLinkClasses]) !!}
                @endif
                {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'All time', ['filter' => 'all'], ['class' => $inactiveLinkClasses]) !!}
            </div>
        </div>

        <div class="border-2 border-indigo-200 bg-gray-200 rounded mt-4">
            <div class="bg-indigo-150 p-4">Sort</div>
            <div class="bg-white flex flex-col p-4">
                {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'CFP Closing Next', ['sort' => 'closing_next'], ['class' => $inactiveLinkClasses]) !!}
                {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'CFP Opening Next', ['sort' => 'opening_next'], ['class' => $inactiveLinkClasses]) !!}
                {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Title', ['sort' => 'alpha'], ['class' => $inactiveLinkClasses]) !!}
                {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Date', ['sort' => 'date'], ['class' => $inactiveLinkClasses]) !!}
            </div>
        </div>
        <a href="{{ route('conferences.create') }}"
           class="mt-4 w-full bg-indigo-500 text-white rounded px-4 py-2 block text-center">Add Conference &nbsp;<span
                class="glyphicon glyphicon-plus"
                aria-hidden="true"></span></a>
    </div>
    <div class="w-3/4 ml-4">
        @forelse ($conferences as $conference)
            <div class="border-2 border-indigo-200 rounded mt-4 hover:border-indigo">
                <div class="bg-white p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <h3 class="m-0 font-sans text-2xl">
                                <a href="{{ route('conferences.show', ['id' => $conference->id]) }}">
                                    {{ $conference->title }}
                                </a>
                            </h3>
                            @if ($conference->cfpIsOpen())
                                <span class="bg-indigo-500 font-semibold ml-4 px-1 rounded text-white text-xs">CFP OPEN</span>
                            @endif
                            @if (Auth::check() && $conference->appliedTo())
                                <span class="bg-indigo-500 font-semibold ml-4 px-1 rounded text-white text-xs">Already Sent Proposal</span>
                            @endif
                        </div>
                        <div class="text-indigo-500 text-lg">
                            @if (Auth::check() && !$conference->isDismissed())
                                @if ($conference->isFavorited())
                                    <a href="/conferences/{{ $conference->id }}/unfavorite">
                                        <span class="glyphicon glyphicon-star">
                                    </a>
                                @else
                                    <a href="/conferences/{{ $conference->id }}/favorite" class="ml-3">
                                        <span class="glyphicon glyphicon-star-empty">
                                    </a>
                                @endif
                            @endif

                            @if (Auth::check() && !$conference->isFavorited())
                                @if ($conference->isDismissed())
                                    <a href="/conferences/{{ $conference->id }}/undismiss" title="I am interested in this conference">
                                        <span class="glyphicon glyphicon-plus">
                                    </a>
                                @else
                                    <a href="/conferences/{{ $conference->id }}/dismiss" title="I am not interested in this conference" class="ml-3">
                                        <span class="glyphicon glyphicon-remove">
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="mt-3 font-sans text-gray-500">
                        {{ mb_substr($conference->description, 0, 100) }}...
                    </div>
                </div>


                <div class="bg-indigo-150 p-4 font-sans flex justify-between">
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
                </div>
            </div>
        @empty
            <div class="border-2 border-indigo-200 rounded mt-4 p-4">
                No conferences match this filter
            </div>
        @endforelse
    </div>
</div>

@endsection

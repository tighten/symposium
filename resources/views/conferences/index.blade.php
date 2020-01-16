@extends('layout', ['title' => 'Conferences'])

@section('content')
    <div class="container body">
        <div class="row">
            <div class="flex py-3 max-w-md mx-auto sm:max-w-6xl">
                <div class="w-1/3">
                    <?php $linkRouteKeysWithDefaults = ['filter' => 'future', 'sort' => 'closing_next']; ?>

                    <div class="border-2 border-gray-300 rounded mt-4">
                        <div class="bg-white p-4">Filter</div>
                        <div class="flex flex-col p-4">
                            {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Future', ['filter' => 'future'], ['class' => 'filter-link']) !!}
                            {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'CFP is Open', ['filter' => 'open_cfp'], ['class' => 'filter-link']) !!}
                            {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Unclosed CFP', ['filter' => 'unclosed_cfp'], ['class' => 'filter-link']) !!}
                            @if (Auth::check())
                                {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Favorites', ['filter' => 'favorites'], ['class' => 'filter-link']) !!}
                                {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Dismissed', ['filter' => 'dismissed'], ['class' => 'filter-link']) !!}
                            @endif
                            {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'All time', ['filter' => 'all'], ['class' => 'filter-link']) !!}
                        </div>
                    </div>

                    <div class="border-2 border-gray-300 rounded mt-4">
                        <div class="bg-white p-4">Sort</div>
                        <div class="flex flex-col p-4">
                            {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'CFP Closing Next', ['sort' => 'closing_next'], ['class' => 'filter-link']) !!}
                            {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'CFP Opening Next', ['sort' => 'opening_next'], ['class' => 'filter-link']) !!}
                            {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Title', ['sort' => 'alpha'], ['class' => 'filter-link']) !!}
                            {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Date', ['sort' => 'date'], ['class' => 'filter-link']) !!}
                        </div>
                    </div>
                    <a href="{{ route('conferences.create') }}"
                       class="create-button mt-4 w-full">Create Conference &nbsp;<span
                            class="glyphicon glyphicon-plus"
                            aria-hidden="true"></span></a>
                </div>
                <div class="w-2/3 ml-4">
                    @forelse ($conferences as $conference)
                        <div class="border-2 border-gray-300 rounded mt-4">
                            <div class="bg-white p-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="m-0 font-sans text-2xl">
                                        <a href="{{ route('conferences.show', ['id' => $conference->id]) }}">
                                            {{ $conference->title }}
                                        </a>
                                    </h3>
                                    <div class="text-indigo text-lg">
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

                                {{-- @if ($conference->cfpIsOpen())
                                    <span class="label label-info">CFP OPEN</span>
                                @endif --}}

                            <div class="bg-gray-200 p-4 font-sans flex justify-between">
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
                                {{-- @if (Auth::check() && $conference->appliedTo())
                                    <b>Already Sent Proposal</b>
                                @endif --}}
                            </div>
                        </div>
                    @empty
                        No conferences match this filter
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@stop

@extends('layout', ['title' => 'My Archived Talks'])

@section('content')
    <div class="body">
        <div class="row">
            <div class="flex py-3 max-w-md mx-auto sm:max-w-3xl">
                <div class="w-1/4">
                    @php
                        $linkRouteKeysWithDefaults = ['filter' => 'active', 'sort' => 'alpha'];
                        $inactiveLinkClasses = 'filter-link p-1 rounded';
                    @endphp
                    <div class="border-2 border-indigo-200 rounded mt-4 font-sans">
                        <div class="bg-indigo-150 p-4">Filter</div>
                        <div class="bg-white flex flex-col p-4">
                            <a href="{{ route('talks.index') }}" class="{{ $inactiveLinkClasses }}">Active</a>
                            {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'talks.archived.index', 'Archived', ['filter' => 'active'], ['class' => $inactiveLinkClasses]) !!}
                        </div>
                    </div>

                    <div class="border-2 border-indigo-200 bg-gray-200 rounded mt-4">
                        <div class="bg-indigo-150 p-4">Sort</div>
                        <div class="bg-white flex flex-col p-4">
                            {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'talks.archived.index', 'Title', ['sort' => 'alpha'], ['class' => $inactiveLinkClasses]) !!}
                            {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'talks.archived.index', 'Date', ['sort' => 'date'], ['class' => $inactiveLinkClasses]) !!}
                        </div>
                    </div>
                    <a href="{{ route('talks.create') }}"
                       class="mt-4 w-full bg-indigo-500 text-white rounded px-4 py-2 block text-center">Add Talk &nbsp;<span
                            class="glyphicon glyphicon-plus"
                            aria-hidden="true"></span>
                    </a>
                </div>
                <div class="w-3/4 ml-4">
                    @each('partials.talk-in-list', $talks, 'talk', 'partials.talk-in-list-empty')
                </div>
            </div>
        </div>
    </div>
@stop

            {{-- <div class="col-md-8 col-md-push-2">
                <p>
                    <span class="list-sort">Sort:
                        <a href="{{ route('talks.archived.index', ['sort' => 'alpha']) }}" class="@sorted($sorted_by, 'alpha')">Title</a> |
                        <a href="{{ route('talks.archived.index', ['sort' => 'date']) }}" class="@sorted($sorted_by, 'date')">Date</a>
                    </span>
                    <a href="{{ route('talks.index', ['sort' => 'alpha']) }}" class="btn btn-default btn-xs">Show Active Talks</a>
                </p>
                <ul class="list-talks">
                  @each('partials.talk-in-list', $talks, 'talk', 'partials.talk-in-list-empty')
                </ul>
            </div> --}}

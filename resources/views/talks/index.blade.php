@extends('layout', ['title' => 'My Talks'])

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
                        {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'talks.index', 'Active', ['filter' => 'active'], ['class' => $inactiveLinkClasses]) !!}
                        <a href="{{ route('talks.archived.index') }}" class="{{ $inactiveLinkClasses }}">Archived</a>
                    </div>
                </div>

                <div class="border-2 border-indigo-200 bg-gray-200 rounded mt-4">
                    <div class="bg-indigo-150 p-4">Sort</div>
                    <div class="bg-white flex flex-col p-4">
                        {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'talks.index', 'Title', ['sort' => 'alpha'], ['class' => $inactiveLinkClasses]) !!}
                        {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'talks.index', 'Date', ['sort' => 'date'], ['class' => $inactiveLinkClasses]) !!}
                    </div>
                </div>
                <a href="{{ route('talks.create') }}"
                   class="mt-4 w-full bg-indigo-500 text-white rounded px-4 py-2 block text-center">Add Talk &nbsp;<span
                        class="glyphicon glyphicon-plus"
                        aria-hidden="true"></span>
                </a>
            </div>
                <div class="w-3/4 ml-4">
                    @foreach ($talks as $talk)
                        <div class="border-2 border-indigo-200 rounded mt-4 hover:border-indigo">
                            <div class="bg-white p-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="m-0 font-sans text-2xl">
                                        <a href="{{ route('talks.show', ['id' => $talk->id]) }}">
                                            {{ $talk->current()->title }}
                                        </a>
                                    </h3>
                                    <div class="text-indigo-500 text-lg">
                                        <a href="{{ route('talks.edit', ['id' => $talk->id]) }}" title="Edit">
                                          <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('talks.delete', ['id' => $talk->id]) }}" class="ml-3" title="Delete">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                        </a>
                                        @if ($talk->isArchived())
                                            <a href="{{ route('talks.restore', ['id' => $talk->id]) }}" class="ml-3" title="Restore">
                                                <span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span>
                                            </a>
                                        @else
                                            <a href="{{ route('talks.archive', ['id' => $talk->id]) }}" class="ml-3" title="Archive">
                                                <span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="bg-indigo-150 p-4 font-sans">
                                <div class="text-gray-500">Created</div>
                                <div class="flex justify-between">
                                    <div>{{ $talk->created_at->toFormattedDateString() }}</div>
                                    <div>{{ $talk->current()->length }}-minute {{ $talk->current()->level }} {{ $talk->current()->type }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                  {{-- @each('partials.talk-in-list', $talks, 'talk', 'partials.talk-in-list-empty') --}}
            </div>
        </div>
    </div>
@stop

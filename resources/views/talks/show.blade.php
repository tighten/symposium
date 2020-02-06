@extends('layout')

@section('content')

<div class="max-w-md mx-auto sm:max-w-3xl border-2 border-indigo-200 rounded mt-4">
    <div class="bg-white p-10">
        <div class="flex items-center justify-between">
            @if ($current === null)
                <p>No revisions yet. @todo Throw exception etc.</p>
            @else
                <div>
                    <h2 class="m-0 font-sans text-2xl">{{ $current->title }}</h2>
                    <p style="font-style: italic;">
                        {{ $current->length }} minute {{ $current->level }} {{ $current->type }}
                    </p>
                </div>
            @endif
            <div class="text-indigo-500 text-lg">
                @if ($showingRevision)
                    <a href="/talks/{{ $talk->id }}" class="btn btn-default">Return to talk &nbsp;
                        <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                    </a>
                    <br>
                    <p style="text-align: right">REVISION:<br>
                    {{ $current->created_at }}</p>
                @else
                    <a href="/talks/{{ $talk->id }}?revision={{ $talk->current()->id }}" title="Revisions">
                      <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>
                    <a href="/talks/{{ $talk->id }}/edit" class="ml-3" title="Edit">
                      <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    </a>
                    <a href="/talks/{{ $talk->id }}/delete" class="ml-3" title="Delete">
                      <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                    @if ($talk->isArchived())
                        <a href="{{ route('talks.restore', ['id' => $talk->id]) }}" class="ml-3" title="Restore">
                          <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                        </a>
                    @else
                        <a href="{{ route('talks.archive', ['id' => $talk->id]) }}" class="ml-3" title="Archive">
                          <span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span>
                        </a>
                    @endif
                @endif
            </div>
        </div>
        <h3 class="text-lg font-normal text-gray-500 mt-4">Description/Proposal</h3>

        @markdown($current->getDescription())

        <h3 class="text-lg font-normal text-gray-500 mt-4">Organizer Notes</h3>
        {!! $current->getHtmledOrganizerNotes() !!}

        @if ($current->slides)
            <h3 class="text-lg font-normal text-gray-500 mt-4">Slides</h3>
            <a href="{{ $current->slides }}">{{ $current->slides }}</a>
        @endif

        @if ($showingRevision)
            <h3>Revisions</h3>
            <ul>
                @foreach ($talk->revisions as $revision)
                    <li {{ $revision->id == $current->id ? 'style="font-weight: bold;"' : '' }}>
                        <a href="/talks/{{ $talk->id }}?revision={{ $revision->id }}">{{ $revision->created_at }}</a>
                        {!! $talk->current()->id == $revision->id ? '<i>(current)</i>' : '' !!}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

@stop

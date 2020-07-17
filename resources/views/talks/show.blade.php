@extends('layouts.index')

@php
    $baseLinkClasses = 'py-1 px-5 hover:bg-indigo-100';
    $activeLinkClasses = 'font-bold text-indigo-500'
@endphp

@section('sidebar')
    <x-side-menu title="Revisions">
        <x-slot name="body">
            @foreach ($talk->revisions as $revision)
                @if ($talk->current()->id == $revision->id)
                    <a
                        href="/talks/{{ $talk->id }}"
                        class="{{ $baseLinkClasses }} {{ $revision->id == $current->id ? $activeLinkClasses : '' }}"
                    >
                        {{ $revision->created_at }} <i>(current)</i>
                    </a>
                @else
                    <a
                        href="/talks/{{ $talk->id }}?revision={{ $revision->id }}"
                        class="{{ $baseLinkClasses }} {{ $revision->id == $current->id ? $activeLinkClasses : '' }}"
                    >
                        {{ $revision->created_at }}
                    </a>
                @endif
            @endforeach
        </x-slot>
    </x-side-menu>
@endsection

@section('list')
    <x-panel size="md" :title="$current->title">
        <x-slot name="subtitle">
            <span class="italic">
                {{ $current->length }} minute {{ $current->level }} {{ $current->type }}
            </span>
        </x-slot>
        <x-slot name="actions">
            <div class="text-indigo-500 text-lg">
                @unless ($showingRevision)
                    <a href="/talks/{{ $talk->id }}/edit" class="ml-3" title="Edit">
                        @svg('compose', 'w-5 fill-current inline')
                    </a>
                    <a href="/talks/{{ $talk->id }}/delete" class="ml-3" title="Delete">
                        @svg('trash', 'w-5 fill-current inline')
                    </a>
                    @if ($talk->isArchived())
                        <a href="{{ route('talks.restore', ['id' => $talk->id]) }}" class="ml-3" title="Restore">
                            @svg('folder-outline', 'w-5 fill-current inline')
                        </a>
                    @else
                        <a href="{{ route('talks.archive', ['id' => $talk->id]) }}" class="ml-3" title="Archive">
                            @svg('folder', 'w-5 fill-current inline')
                        </a>
                    @endif
                @endif
            </div>
        </x-slot>
        <h3 class="text-lg font-normal text-gray-500 mt-4">Description/Proposal</h3>

        {!! markdown($current->getDescription()) !!}

        <h3 class="text-lg font-normal text-gray-500 mt-4">Organizer Notes</h3>
        {!! $current->getHtmledOrganizerNotes() !!}

        @if ($current->slides)
            <h3 class="text-lg font-normal text-gray-500 mt-4">Slides</h3>
            <a href="{{ $current->slides }}">{{ $current->slides }}</a>
        @endif
    </x-panel>
@endsection

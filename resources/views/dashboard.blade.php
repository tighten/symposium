@extends('layouts.index', ['title' => 'Dashboard'])

@section('headerScripts')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v1.9.5/dist/alpine.js" defer></script>
@endsection

@section('sidebar')
    <x-panel size="sm" class="w-full">
        <div class="h-16 flex justify-center">
            <div class="bg-white rounded-full w-24 h-24 mt-4 border-2 border-indigo-800 p-1">
                <div class="w-full h-full rounded-full">
                    <img
                        src="{{ auth()->user()->profile_picture_hires }}"
                        class="rounded-full"
                        alt="profile picture"
                    >
                </div>
            </div>
        </div>
        <div class="bg-indigo-100 p-4 pt-12 text-center">
            <h2 class="text-xl">{{ auth()->user()->name }}</h2>
        </div>
    </x-panel>
@endsection

@section('list')
    <x-panel size="md" title="Talks">
        <x-slot name="actions">
            <a href="{{ route('talks.create') }}" class="text-indigo-500 hover:text-indigo-800 flex items-center">
                @svg('plus', 'w-3 fill-current inline')
                <span class="ml-1">Add Talk</span>
            </a>
        </x-slot>
        <div class="-mb-4">
            @forelse ($talks as $talk)
                <div class="bg-indigo-100 -mx-4 px-4 py-2 border-b last:border-b-0 flex flex-row justify-between content-center">
                    <div>
                        <h3 class="font-sans text-lg font-semibold hover:text-indigo-500">
                            <a href="{{ route('talks.show', $talk) }}">
                                {{ $talk->current()->title }}
                            </a>
                        </h3>
                        <p>
                            {{ $talk->current()->length }}-minute {{ $talk->current()->level }} {{ $talk->current()->type }}
                        </p>
                    </div>
                </div>
            @empty
                No Talks
            @endforelse
        </div>
    </x-panel>

    <x-panel size="md" title="Bios">
        <x-slot name="actions">
            <a href="{{ route('bios.create') }}" class="flex items-center text-indigo-500 hover:text-indigo-800">
                @svg('plus', 'w-3 fill-current inline')
                <span class="ml-1">Add Bio</span>
            </a>
        </x-slot>
        <div class="-mb-4">
            @forelse ($bios as $bio)
                <div class="bg-indigo-100 -mx-4 px-4 py-2 border-b last:border-b-0">
                    <h3 class="font-sans text-lg font-semibold hover:text-indigo-500">
                        <a href="{{ route('bios.show', $bio) }}">
                            {{ $bio->nickname }}
                        </a>
                    </h3>
                </div>
            @empty
                No Talks
            @endforelse
        </div>
    </x-panel>
@endsection

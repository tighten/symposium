@extends('layout', ['title' => 'Dashboard'])

@section('headerScripts')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v1.9.5/dist/alpine.js" defer></script>
@endsection

@section('content')

<div class="flex py-4 max-w-md mx-auto sm:max-w-6xl flex-col md:flex-row">
    <div class="w-full md:w-1/2 lg:w-1/3">
        <x-panel size="sm" class="mt-4">
            <div class="bg-white h-16 flex content-end justify-center">
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
                <h2>{{ auth()->user()->name }}</h2>
            </div>
        </x-panel>
    </div>
    <div class="w-full md:w-1/2 lg:w-2/3 md:ml-4">
        <x-panel size="md" class="mt-4">
            <div class="px-4 py-4 flex flex-row content-center justify-between">
                <h2 class="m-0 font-sans text-xl uppercase text-gray-500">Talks</h2>
                <a href="{{ route('talks.create') }}" class="text-indigo flex items-center">
                    @svg('plus', 'w-3 fill-current inline')
                    <span class="ml-1">Add Talk</span>
                </a>
            </div>
            <div class="-mb-4">
                @forelse ($talks as $talk)
                    <div class="bg-indigo-100 -mx-4 px-8 py-2 border-b last:border-b-0 flex flex-row justify-between content-center">
                        <div>
                            <h3 class="font-sans text-lg font-semibold">
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

        <x-panel size="md" class="mt-4">
            <div class="px-4 py-4 flex flex-row content-center justify-between">
                <h2 class="m-0 font-sans text-xl uppercase text-gray-500">Bios</h2>
                <a href="{{ route('bios.create') }}" class="flex items-center text-indigo">
                    @svg('plus', 'w-3 fill-current inline')
                    <span class="ml-1">Add Bio</span>
                </a>
            </div>
            <div class="-mb-4">
                @forelse ($bios as $bio)
                    <div class="bg-indigo-100 -mx-4 px-8 py-2 border-b last:border-b-0">
                        <h3 class="font-sans text-lg font-semibold">
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
    </div>
</div>

@endsection

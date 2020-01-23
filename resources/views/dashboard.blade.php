@extends('layout', ['title' => 'Dashboard'])

@section('headerScripts')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v1.9.5/dist/alpine.js" defer></script>
@stop

@section('content')

    <div class="container body">
        <div class="row">
            <div class="flex py-4 max-w-md mx-auto sm:max-w-6xl flex-col md:flex-row">
                <div class="w-full md:w-1/2 lg:w-1/3">
                    <div class="border-2 border-gray-300 rounded mt-4">
                        <div class="bg-white h-16 flex content-end justify-center mb-8">
                            <div class="bg-white rounded-full w-24 h-24 mt-4 border-2 border-indigo-800 p-1">
                                <div class="bg-indigo w-full h-full rounded-full"></div>
                            </div>
                        </div>
                        <div class="p-4 text-center">
                            <h2>Matt Stauffer</h2>
                            <h3>Co-Founder of Tighten</h3>
                            <ul>
                                <li>Twitter<li>
                                <li>LinkedIn</li>
                                <li>Github</li>
                                <li>Website</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/2 lg:w-2/3 md:ml-4">
                    <div class="border-2 border-gray-300 rounded mt-4">
                        <div class="px-4 py-4 bg-white flex flex-row content-center justify-between">
                            <h2 class="m-0 font-sans text-xl uppercase text-gray-500">Talks</h2>
                            <a href="{{ route('talks.create') }}" class="text-indigo">
                                <span aria-hidden="true" class="glyphicon glyphicon-plus"></span>
                                Add Talk
                            </a>
                        </div>
                        @forelse ($talks as $talk)
                            <div class="px-4 py-2 border-b last:border-b-0 flex flex-row justify-between content-center">
                                <div>
                                    <h3 class="font-sans text-lg font-semibold">{{ $talk->current()->title }}</h3>
                                    <p>
                                        {{ $talk->current()->length }}-minute {{ $talk->current()->level }} {{ $talk->current()->type }}
                                    </p>
                                </div>
                                <div x-data="{open: false}" class="relative">
                                    <a x-on:click="open = true">
                                        @svg('dots', 'w-4 inline')
                                    </a>
                                    <ul class="absolute right-0 mt-1 z-50 bg-white rounded border border-gray-300"
                                        x-show="open"
                                        x-on:click.away="open = false" >
                                        <li class="py-2 px-8 border-b border-gray-300">Edit</li>
                                        <li class="py-2 px-8 border-b border-gray-300">Delete<li>
                                        <li class="py-2 px-8">Archive<li>
                                    </ul>
                                </div>

                            </div>
                        @empty
                            No Talks
                        @endforelse
                    </div>

                    <div class="border-2 border-gray-300 rounded mt-4">
                        <div class="px-4 py-4 bg-white flex flex-row content-center justify-between">
                            <h2 class="m-0 font-sans text-xl uppercase text-gray-500">Bios</h2>
                            <a href="{{ route('bios.create') }}" class="text-indigo">
                                <span aria-hidden="true" class="glyphicon glyphicon-plus"></span>
                                Add Bio
                            </a>
                        </div>
                        @forelse ($bios as $bio)
                            <div class="px-4 py-2 border-b last:border-b-0">
                                <h3 class="font-sans text-lg font-semibold">{{ $bio->nickname }}</h3>
                            </div>
                        @empty
                            No Talks
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

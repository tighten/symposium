@extends('layout')

@section('content')

<x-panel class="max-w-md mx-auto sm:max-w-3xl mt-4">
    <div class="flex items-center justify-between">
        <h2 class="m-0 font-sans text-2xl">{{ $bio->nickname }}</h2>
        <div class="text-indigo-500 text-lg">
            <a href="{{ route('bios.edit', $bio) }}" title="Edit">
                @svg('compose', 'w-5 fill-current inline')
            </a>
            <a href="{{ route('bios.delete', ['id' => $bio->id]) }}" class="ml-3" title="Delete">
                @svg('trash', 'w-5 fill-current inline')
            </a>
        </div>
    </div>
    <div class="mt-3 font-sans">
        <!-- TODO: Figure out how we will be handling HTML/etc. -->
        {!! str_replace("\n", "<br>", $bio->body) !!}
    </div>
    <x-slot name="footer">
        <div>
            <div class="text-gray-500">Created</div>
            <div>{{ $bio->created_at->toFormattedDateString() }}</div>
        </div>
        <div>
            <div class="text-gray-500">Updated</div>
            <div>{{ $bio->updated_at->toFormattedDateString() }}</div>
       </div>
    </x-slot>
</x-panel>

@endsection

@extends('layout')

@section('content')

<div class="max-w-md mx-auto sm:max-w-3xl border-2 border-indigo-200 rounded mt-4">
    <div class="bg-white p-10">
        <div class="flex items-center justify-between">
            <h2 class="m-0 font-sans text-2xl">{{ $bio->nickname }}</h2>
            <div class="text-indigo-500 text-lg">
                <a href="{{ route('bios.edit', ['id' => $bio->id]) }}" title="Edit">
                  <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                </a>
                <a href="{{ route('bios.delete', ['id' => $bio->id]) }}" class="ml-3" title="Delete">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </a>
            </div>
        </div>
        <div class="mt-3 font-sans">
            <!-- TODO: Figure out how we will be handling HTML/etc. -->
            {!! str_replace("\n", "<br>", $bio->body) !!}
        </div>
    </div>
    <div class="bg-indigo-150 px-10 py-3 font-sans flex justify-between">
        <div>
            <div class="text-gray-500">Created</div>
            <div>{{ $bio->created_at->toFormattedDateString() }}</div>
        </div>
        <div>
            <div class="text-gray-500">Updated</div>
            <div>{{ $bio->updated_at->toFormattedDateString() }}</div>
       </div>
    </div>
</div>

@stop

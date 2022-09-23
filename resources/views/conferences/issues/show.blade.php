@extends('app')

@section('content')

<x-panel>
    <x-slot:title>
        <div class="flex items-center">
            Reported Issue
            @unless ($issue->isOpen())
                <x-tag>closed</x-tag>
            @endunless
        </div>
    </x-slot>
    <div class="mt-4 text-gray-500">Reason:</div>
    <p>{{ $issue->description }}</p>

    <div class="mt-4 text-gray-500">Note:</div>
    <p>{{ $issue->note }}</p>

    @if ($issue->isOpen())
        <x-form :action="route('closed-issues.store', $issue)">
                <div class="flex flex-col items-end mt-4">
                <x-button.primary>Close</x-button.primary>
            </div>
        </x-form>
    @endif
</x-panel>

<x-panel.conference
    :conference="$issue->conference"
    class="mt-4"
></x-panel.conference>

@endsection

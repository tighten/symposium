@extends('app')

@section('content')

<x-panel title="Reported Issue">
    <div class="mt-4 text-gray-500">Reason:</div>
    <p>{{ $issue->description }}</p>

    <div class="mt-4 text-gray-500">Note:</div>
    <p>{{ $issue->note }}</p>

    <x-form :action="route('closed-issues.store', $issue)">
        <div class="flex flex-col items-end mt-4">
            <x-button.primary>Close</x-button.primary>
        </div>
    </x-form>
</x-panel>

<x-panel.conference
    :conference="$issue->conference"
    class="mt-4"
></x-panel.conference>

@endsection

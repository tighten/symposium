@extends('app')

@section('content')

<x-panel title="Reported Issue">
    <div class="mt-4 text-gray-500">Reason:</div>
    <p>{{ $issue->description }}</p>

    <div class="mt-4 text-gray-500">Note:</div>
    <p>{{ $issue->note }}</p>
</x-panel>

<x-panel.conference
    :conference="$issue->conference"
    class="mt-4"
></x-panel.conference>

@endsection

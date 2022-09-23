@extends('app')

@section('content')

@if ($conference->isFlagged())
    <x-alert.warning>An issue has been reported for this conference.</x-alert.warning>
@endif

<x-panel.conference
    :conference="$conference"
></x-panel.conference>

<div class="flex flex-col items-end mt-6">
    <x-button.secondary :href="route('conferences.issues.create', $conference)">
        Report an Issue
    </x-button.secondary>
</div>

@endsection

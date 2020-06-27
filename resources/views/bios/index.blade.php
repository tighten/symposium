@extends('layouts.index', ['title' => 'All Bios'])

@section('sidebar')
    <x-buttons.primary
        :href="route('bios.create')"
        icon="plus"
    >
        Add Bio
    </x-buttons.primary>
@endsection

@section('list')
    @each('partials.bio-in-list', $bios, 'bio', 'partials.bio-in-list-empty')
@endsection

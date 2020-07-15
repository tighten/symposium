@extends('layouts.index', ['title' => 'All Bios'])

@section('sidebar')
    <x-button.primary
        :href="route('bios.create')"
        icon="plus"
        class="block mt-4 w-full"
    >
        Add Bio
    </x-button.primary>
@endsection

@section('list')
    @each('bios.listing', $bios, 'bio', 'bios.listing-empty')
@endsection

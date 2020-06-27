@extends('layouts.index', ['title' => 'All Bios'])

@section('sidebar')
    <a href="{{ route('bios.create') }}" class="mt-4 w-full bg-indigo-500 text-white rounded px-4 py-2 block text-center">Add Bio @svg('plus', 'w-3 h-3 fill-current inline ml-2')</a>
@endsection

@section('list')
    @each('partials.bio-in-list', $bios, 'bio', 'partials.bio-in-list-empty')
@endsection

@extends('layout', ['title' => 'All Bios'])

@section('content')

<div class="flex py-3 max-w-md mx-auto sm:max-w-3xl">
    <div class="w-1/4">
        <a href="{{ route('bios.create') }}" class="mt-4 w-full bg-indigo-500 text-white rounded px-4 py-2 block text-center">Add Bio &nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
    </div>
    <div class="w-3/4 ml-4">
      @each('partials.bio-in-list', $bios, 'bio', 'partials.bio-in-list-empty')
    </div>
</div>

@endsection

@extends('layout', ['title' => 'All Bios'])

@section('content')

<div class="flex flex-col md:flex-row py-3 max-w-md mx-auto sm:max-w-3xl">
    <div class="w-full md:w-1/4">
        <a href="{{ route('bios.create') }}" class="mt-4 w-full bg-indigo-500 text-white rounded px-4 py-2 block text-center">Add Bio @svg('plus', 'w-3 h-3 fill-current inline ml-2')</a>
    </div>
    <div class="w-full md:w-3/4 md:ml-4">
      @each('partials.bio-in-list', $bios, 'bio', 'partials.bio-in-list-empty')
    </div>
</div>

@endsection

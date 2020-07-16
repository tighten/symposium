@extends('layout')

@section('content')

<div class="flex flex-col md:flex-row py-3 max-w-md mx-auto sm:max-w-3xl">
    <div class="w-full md:w-1/4">
        <div class="flex md:flex-col space-y-6">
            @yield('sidebar')
        </div>
    </div>
    <div class="w-full md:w-3/4 md:ml-6">
        <div class="space-y-6">
            @yield('list')
        </div>
    </div>
</div>

@endsection

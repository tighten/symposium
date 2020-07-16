@extends('layout')

@section('content')

<div class="flex flex-col md:flex-row py-3 max-w-md mx-auto sm:max-w-3xl">
    <div class="w-full md:w-1/4 space-y-6">
        @hasSection('sidebar')
            <div class="flex items-start flex-wrap md:flex-col space-x-6 space-y-0 md:space-x-0 md:space-y-6">
                @yield('sidebar')
            </div>
        @endif
        @yield('actions')
    </div>
    <div class="w-full md:w-3/4 md:ml-6 mt-6 md:mt-0">
        <div class="space-y-6">
            @yield('list')
        </div>
    </div>
</div>

@endsection

@extends('app')

@section('content')

<x-panel class="w-full md:w-1/2 mx-auto">
    <h2 class="text-2xl text-center my-4">Log in</h2>
    <div class="text-center">
        <a
            class="btn-github-login"
            href="{{ url('login/github') }}"
        >
            Log in with <strong>GitHub</strong>
            @svg('github', 'inline-block align-top h-6 w-6')
        </a>
        <p class="text-base my-2">or</p>
    </div>
    @include('partials.log-in-form')
</x-panel>

@endsection

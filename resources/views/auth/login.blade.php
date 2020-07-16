@extends('app')

@section('content')

<x-panel class="w-full md:w-2/3 mx-auto">
    <h2 class="text-2xl text-center my-4">Log in</h2>
    {!! $errors->first('auth', '<div class="alert alert-danger">:message</div>') !!}
    <div class="text-center">
        <a
            class="btn-github-login"
            href="{{ url('login/github') }}"
        >
            Log in with <strong>GitHub</strong>
            @svg('github', 'inline-block align-top h-6 w-6')
        </a>
        <p class="text-gray-400 text-base my-2">or</p>
    </div>
    @include('partials.log-in-form')
</x-panel>

@endsection

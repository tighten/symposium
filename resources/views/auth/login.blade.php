@extends('layout')

@section('content')

<div class="flex justify-center">
    <div class="w-full md:w-2/3 bg-white my-12 shadow-md p-8 rounded">
        <div class="panel-heading">
            <h2 class="text-2xl text-center my-4">Log in</h2>
        </div>
        <div class="panel-body">
            {!! $errors->first('auth', '<div class="alert alert-danger">:message</div>') !!}
            <div class="text-center">
                <a class="btn-github-login" href="{{ url('login/github') }}">Log in with <strong>GitHub</strong> @svg('github', 'inline-block align-top h-6 w-6')</a>
                <p class="text-gray-400 text-base">or</p>
            </div>
            @include('partials.log-in-form')
        </div>
    </div>
</div>

@endsection

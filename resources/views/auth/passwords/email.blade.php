@extends('layout', ['title' => 'Reset Password'])

@section('content')

@include('partials.authentication-errors')

<form method="POST" action="/password/email">
    {!! csrf_field() !!}

    <x-input.text
        name="email"
        label="Email"
        type="email"
        placeholder="Email address"
        :hideLabel="true"
        autofocus="autofocus"
    ></x-input.text>

    <x-button.primary
        type="submit"
        size="md"
        class="mt-8"
    >
        Send Password Reset Link
    </x-button.primary>
</form>

@endsection

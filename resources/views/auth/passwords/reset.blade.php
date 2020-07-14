@extends('layout', ['title' => 'Reset Password'])

@section('content')

@include('partials.authentication-errors')

<form method="POST" action="/password/reset">
    {!! csrf_field() !!}
    <input type="hidden" name="token" value="{{ $token }}">

    <x-input.text
        name="email"
        label="Email"
        type="email"
        placeholder="Email address"
        :hideLabel="true"
        autofocus="autofocus"
        class="mt-4"
    ></x-input.text>

    <x-input.text
        name="password"
        label="Password"
        type="password"
        placeholder="Password"
        :hideLabel="true"
        class="mt-4"
    ></x-input.text>

    <x-input.text
        name="password_confirmation"
        label="Password"
        type="password"
        placeholder="Confirm Password"
        :hideLabel="true"
        class="mt-4"
    ></x-input.text>

    <x-button.primary
        type="submit"
        size="md"
        class="mt-8"
    >
        Reset Password
    </x-button.primary>
</form>

@endsection

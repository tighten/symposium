@extends('layout', ['title' => "Email {$user->name}"])

@section('headerScripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')

@if (! $errors->isEmpty())
    <ul class="errors">
        @foreach ($errors->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif

<x-form :action="route('speakers-public.email.send', $user->profile_slug)">
    <x-input.text
        type="email"
        name="email"
        label="Email Address"
        placeholder="Email address"
        autofocus="autofocus"
        :hideLabel="true"
        class="mt-4"
    ></x-input.text>

    <x-input.text
        name="name"
        label="Name"
        placeholder="Name"
        :hideLabel="true"
        class="mt-4"
    ></x-input.text>

    <x-input.textarea
        name="message"
        label="Message"
        placeholder="Message"
        class="mt-4"
        :hideLabel="true"
    ></x-input.textarea>

    <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_PUBLIC') }}"></div>

    <div class="block mt-4">
        <x-button.primary
            type="submit"
            class="w-full md:w-auto"
        >
            Send
        </x-button.primary>
    </div>
</x-form>

@endsection

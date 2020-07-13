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

    {!! Form::open() !!}

    <label class="block mt-4">
        {!! Form::label('email', 'Email Address', ['class' => 'hidden']) !!}
        {!! Form::email('email', null, ['autofocus' => 'autofocus', 'class' => 'form-input mt-1 block w-full', 'placeholder' => 'Email address']) !!}
    </label>

    <div class="block mt-4">
        {!! Form::label('name', 'Name', ['class' => 'hidden']) !!}
        {!! Form::text('name', null, ['class' => 'form-input mt-1 block w-full', 'placeholder' => 'Name']) !!}
    </div>

    <div class="block mt-4">
        {!! Form::label('message', 'Message', ['class' => 'hidden']) !!}
        {!! Form::textarea('message', null, ['class' => 'form-textarea mt-1 block w-full', 'placeholder' => 'Message']) !!}
    </div>

    <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_PUBLIC') }}"></div>

    <div class="block mt-4">
        <x-button.primary
            type="submit"
            class="w-full md:w-auto"
        >
            Send
        </x-button.primary>
    </div>

    {!! Form::close() !!}
@endsection

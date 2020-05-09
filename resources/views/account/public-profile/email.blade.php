@extends('layout')

@section('headerScripts')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
    <div class="body">
        <div class="row">
            <div class="my-4">
                <h1 class="text-2xl text-center">Email {{ $user->name }}</h1>

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

                <br>

                <div class="block mt-4">
                    {!! Form::submit('Send', ['class' => 'bg-indigo block w-full md:w-auto lg:px-10 lg:py-5 md:inline-block md:px-8 md:py-4 md:text-left px-4 py-2 rounded-lg text-center text-white whitespace-no-wrap ']) !!}
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

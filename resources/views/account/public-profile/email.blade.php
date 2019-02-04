@extends('layout')

@section('headerScripts')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
    <div class="container body">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <h1>Email {{ $user->name }}</h1>

                @if (! $errors->isEmpty())
                <ul class="errors">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
                @endif

                {!! Form::open() !!}

                <div class="form-group">
                    {!! Form::label('email', '*Email Address', ['class' => 'sr-only']) !!}
                    {!! Form::email('email', null, ['autofocus' => 'autofocus', 'class' => 'form-control', 'placeholder' => 'Email address']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('name', '*Name', ['class' => 'sr-only']) !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('message', '*Message', ['class' => 'sr-only']) !!}
                    {!! Form::textarea('message', null, ['class' => 'form-control', 'placeholder' => 'Message']) !!}
                </div>

                <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_PUBLIC') }}"></div>

                <br>

                <div class="form-group">
                    {!! Form::submit('Send', ['class' => 'btn btn-block btn-primary']) !!}
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

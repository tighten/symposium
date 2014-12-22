@extends('layout')

@section('content')
    <div class="container">
        {{ Form::open(array('action' => 'AuthController@postLogin')) }}
        <h2>Log in</h2>

        <div>
            {{ Form::label('email') }}<br>
            {{ Form::text('email', null, ['autofocus' => 'autofocus']) }}
        </div>
        <div>
            {{ Form::label('password') }}<br>
            {{ Form::password('password') }}
        </div>
        <br>

        {{ Form::submit('Sign in', array('class' => 'button button--primary')) }}
        {{ Form::close() }}
    </div>
@stop

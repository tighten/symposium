@extends('layout')

@section('content')
    <div class="container">
        {{ Form::open(array('action' => 'AuthController@postLogin')) }}
        <h2>Log in</h2>

        <div class="form-group">
            {{ Form::label('email', 'Email', ['class' => 'control-label']) }}<br>
            {{ Form::text('email', null, ['autofocus' => 'autofocus', 'class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('password', 'Password', ['class' => 'control-label']) }}<br>
            {{ Form::password('password', ['class' => 'form-control']) }}
        </div>
        <br>

        {{ Form::submit('Sign in', array('class' => 'button button--primary')) }}
        {{ Form::close() }}
    </div>
@stop

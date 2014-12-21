@extends('layout')

@section('content')
    <div class="container">
        {{ Form::open(array('action' => 'AuthController@postLogin')) }}
        <h2>Log in</h2>

        <div>
            {{ Form::label('email') }}
            <div>
                {{ Form::text('email')}}
            </div>
        </div>
        <div>
            {{ Form::label('password') }}
            <div>
                {{ Form::password('password')}}
            </div>
        </div>
        <br>

        {{ Form::submit('Sign in', array('class' => 'button button--primary')) }}
        {{ Form::close() }}
    </div>
@stop

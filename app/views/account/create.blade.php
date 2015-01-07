@extends('layout')

@section('content')
    <div class="container">
        <h2>Sign up</h2>

        <ul class="errors">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>

        {{ Form::open(array('action' => array('AccountController@store'))) }}

        <div class="form-group">
            {{ Form::label('email', '*Email Address', ['class' => 'control-label']) }}
            {{ Form::email('email', null, ['autofocus' => 'autofocus', 'class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('password', '*Password', ['class' => 'control-label']) }}
            {{ Form::password('password', ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('first_name', '*First Name', ['class' => 'control-label']) }}
            {{ Form::text('first_name', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('last_name', '*Last Name', ['class' => 'control-label']) }}
            {{ Form::text('last_name', null, ['class' => 'form-control']) }}
        </div>

        {{ Form::submit('Save', array('class' => 'button button--primary')) }}

        {{ Form::close() }}
    </div>
@stop

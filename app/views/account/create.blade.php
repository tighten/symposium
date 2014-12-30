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

        {{ Form::label('email', '*Email Address') }}<br>
        {{ Form::email('email', null, ['autofocus' => 'autofocus']) }}<br><br>

        {{ Form::label('password', '*Password') }}<br>
        {{ Form::password('password') }}<br><br>

        {{ Form::label('first_name', '*First Name') }}<br>
        {{ Form::text('first_name') }}<br><br>

        {{ Form::label('last_name', '*Last Name') }}<br>
        {{ Form::text('last_name') }}<br><br>

        {{ Form::submit('Save', array('class' => 'button button--primary')) }}

        {{ Form::close() }}
    </div>
@stop

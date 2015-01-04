@extends('layout')

@section('content')
    <div class="container">
        <h2>Edit Account</h2>

        <ul class="errors">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>

        <h3>User</h3>
        {{ Form::model($user, array('url' => array('account/edit'))) }}

        <div class="form-group">
            {{ Form::label('email', 'Email Address', ['class' => 'control-label']) }}
            {{ Form::email('email', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('password', 'Password (leave empty to keep the same)', ['class' => 'control-label']) }}
            {{ Form::password('password', ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('first_name', 'First Name', ['class' => 'control-label']) }}
            {{ Form::text('first_name', null, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('last_name', 'Last Name', ['class' => 'control-label']) }}
            {{ Form::text('last_name', null, ['class' => 'form-control']) }}
        </div>

        {{ Form::submit('Save', array('class' => 'button button--primary')) }}

        {{ Form::close() }}

    </div>
@stop

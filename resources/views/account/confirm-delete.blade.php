@extends('layout')

@section('content')
    <div class="container">
        <h2>Are you sure?</h2>

        <p>Are you sure you want to delete your account?</p>

        {{ Form::open(array('action' => array('AccountController@destroy'))) }}
        {{ Form::submit('Yes') }} - <a href="/account">No</a
        {{ Form::close() }}

    </div>
@stop

@extends('layout')

@section('content')
    <div class="hero">
        <div class="container">
            <p>Do you want to authenticate <strong>{{ $params['client']->getName() }}</strong> to access your Symposium account data?</p>

            {{ Form::open(array('url' => URL::route('post-oauth-authorize', $params))) }}
                {{ Form::submit('Approve', ['name' => 'approve', 'class' => 'btn btn-primary']) }}
                {{ Form::submit('Deny', ['name' => 'deny', 'class' => 'btn btn-danger']) }}
            {{ Form::close() }}
        </div>
    </div>
@stop

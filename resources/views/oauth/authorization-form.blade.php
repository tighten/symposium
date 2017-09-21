@extends('layout')

@section('content')
    <div class="hero">
        <div class="container">
        <div class="row col-md-6 col-md-push-3">
            <p><strong>{{ $params['client']->getName() }}</strong> is requesting to access your Symposium account data.</p>

            {!! Form::open(['url' => URL::route('post-oauth-authorize', $params), 'class' => 'pull-right']) !!}
                {!! Form::submit('Deny', ['name' => 'deny', 'class' => 'btn btn-default']) !!}
                {!! Form::submit('Approve', ['name' => 'approve', 'class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

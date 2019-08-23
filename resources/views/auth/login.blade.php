@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <div class="panel panel-default panel-on-grey login-box">
                    <div class="panel-heading">
                        <h2 class="panel-title">Log in</h2>
                    </div>
                    <div class="panel-body">
                        {!! $errors->first('auth', '<div class="alert alert-danger">:message</div>') !!}
                        <div class="text-center">
                            <a class="btn-auth btn-github large" href="{{ url('login/github') }}">Sign in with <strong>GitHub</strong></a>
                            <br>
                            <p class="text-muted">or</p>
                        </div>
                        @include('partials.log-in-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

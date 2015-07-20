@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Sign up</h2>
                </div>
                <div class="panel-body">
                    @include ('partials.sign-up-form')
                </div>
            </div>
        </div>
    </div>
@stop

@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Log in</h2>
                    </div>
                    <div class="panel-body">
                        @include ('partials.log-in-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

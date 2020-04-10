@extends('layout')

@section('content')

<div class="row">
    <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
        <div class="panel panel-default panel-on-grey signup-box">
        <div class="panel-heading">
            <h2 class="panel-title">Sign up</h2>
        </div>
        <div class="panel-body">
            @include('partials.sign-up-form')
        </div>
    </div>
</div>

@endsection

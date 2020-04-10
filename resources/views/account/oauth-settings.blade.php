@extends('layout')

@section('content')

<div class="body">
    <div class="row">
        <div class="col-md-8 col-md-push-2">
            <h1>OAuth settings</h1>

            <passport-clients></passport-clients>
            <passport-authorized-clients></passport-authorized-clients>
            <passport-personal-access-tokens></passport-personal-access-tokens>
        </div>
    </div>
</div>

@endsection

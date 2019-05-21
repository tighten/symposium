@extends('layout')

@section('headerScripts')
<link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container body">
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <h1>OAuth settings</h1>

                <passport-clients></passport-clients>
                <passport-authorized-clients></passport-authorized-clients>
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>
    </div>
@stop

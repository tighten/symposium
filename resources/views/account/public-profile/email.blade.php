@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li><a href="{{ route('talks.index') }}">Speakers</a></li>
            <li><a href="{{ route('speakers-public.show', ['profile_slug' => $user->profile_slug]) }}">{{ $user->name }}</a></li>
            <li class="email">Email</li>
        </ol>

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <h1>Email {{ $user->name }}</h1>

                {{ Form::open() }}

                <div class="form-group">
                    {{ Form::submit('Send', ['class' => 'btn btn-block btn-primary']) }}
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

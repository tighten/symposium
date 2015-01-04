@extends('layout')

@section('content')

    <div class="container">
        <h1>Create Conference</h1>

        <ul class="errors">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>

        {{ Form::open(array('action' => 'ConferencesController@store', 'class' => 'new-conference-form')) }}

        @include('partials.conferenceform')

        {{ Form::submit('Create', ['class' => 'btn btn-primary']) }}<br><br>

        {{ Form::close() }}

    </div>
@stop

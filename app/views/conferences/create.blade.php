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

        {{ Form::label('title', 'Title') }}<br>
        {{ Form::text('title') }}<br><br>

        {{ Form::label('description', 'Description') }}<br>
        {{ Form::textarea('description') }}<br><br>

        {{ Form::label('url', 'Url') }}<br>
        {{ Form::text('url') }}<br><br>

        {{ Form::submit('Create') }}<br><br>

        {{ Form::close() }}

    </div>
@stop

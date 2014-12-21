@extends('layout')

@section('content')

    <div class="container">
        <h1>Edit Talk</h1>

        <ul class="errors">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>

        {{ Form::open(array('action' => array('ConferencesController@update', $talk->id), 'class' => 'edit-talk-form')) }}

        {{ Form::label('title', 'Title') }}<br>
        {{ Form::text('title', $talk->title) }}<br><br>

        {{ Form::label('description', 'Description') }}<br>
        {{ Form::textarea('description', $talk->description) }}<br><br>

        {{ Form::label('url', 'URL') }}<br>
        {{ Form::text('url', $talk->url) }}<br><br>

        {{ Form::submit('Update') }}<br><br>

        {{ Form::close() }}

    </div>
@stop

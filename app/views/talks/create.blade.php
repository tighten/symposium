@extends('layout')

@section('content')

    <div class="container">
        <h1>Create Talk</h1>

        <ul class="errors">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>

        {{ Form::open(array('action' => 'TalksController@store', 'class' => 'new-talk-form')) }}

        <div class="form-group">
            {{ Form::label('title', 'Title', ['class' => 'control-label']) }}
            {{ Form::text('title', null, ['class' => 'form-control']) }}

            <span class="help-block">This is the name of the talk as you'd like to refer to it internally. For example, if you're considering several names for your talk, use one here that will help <em>you</em> remember and recognize this talk.</span>
        </div>

        {{ Form::submit('Create', ['class' => 'btn btn-default']) }}<br><br>

        {{ Form::close() }}

    </div>
@stop

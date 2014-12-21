@extends('layout')

@section('content')

    <div class="container">
        <h1>Edit Conference</h1>

        <ul class="errors">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>

        {{ Form::open(array('action' => array('ConferencesController@update', $conference->id), 'class' => 'edit-talk-form')) }}

        {{ Form::label('title', 'Title') }}<br>
        {{ Form::text('title', $conference->title) }}<br><br>

        {{ Form::label('description', 'Description') }}<br>
        {{ Form::textarea('description', $conference->description) }}<br><br>

        {{ Form::label('url', 'URL') }}<br>
        {{ Form::text('url', $conference->url) }}<br><br>

        {{ Form::label('starts_at', 'Conference Start Date') }}<br>
        {{ Form::input('date', 'starts_at', $conference->starts_at->format('Y-m-d')) }}<br><br>

        {{ Form::label('ends_at', 'Conference End Date') }}<br>
        {{ Form::input('date', 'ends_at', $conference->ends_at->format('Y-m-d')) }}<br><br>

        {{ Form::label('cfp_starts_at', 'CFP Open Date') }}<br>
        {{ Form::input('date', 'cfp_starts_at', $conference->cfp_starts_at->format('Y-m-d')) }}<br><br>

        {{ Form::label('cfp_ends_at', 'CFP Close Date') }}<br>
        {{ Form::input('date', 'cfp_ends_at', $conference->cfp_ends_at->format('Y-m-d')) }}<br><br>

        {{ Form::submit('Update') }}<br><br>

        {{ Form::close() }}

    </div>
@stop

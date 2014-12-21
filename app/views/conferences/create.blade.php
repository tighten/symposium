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

        {{ Form::label('starts_at', 'Conference Start Date') }}<br>
        {{ Form::input('date', 'starts_at') }}<br><br>

        {{ Form::label('ends_at', 'Conference End Date') }}<br>
        {{ Form::input('date', 'ends_at') }}<br><br>

        {{ Form::label('cfp_starts_at', 'CFP Open Date') }}<br>
        {{ Form::input('date', 'cfp_starts_at') }}<br><br>

        {{ Form::label('cfp_ends_at', 'CFP Close Date') }}<br>
        {{ Form::input('date', 'cfp_ends_at') }}<br><br>


        {{ Form::submit('Create') }}<br><br>

        {{ Form::close() }}

    </div>
@stop

@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/talks/">Talks</a></li>
            <li><a href="/talks/{{ $version->talk->id }}">Talk: {{ $version->talk->title }}</a></li>
            <li class="active"><a href="/talks/{{ $version->talk->id }}/versions/{{ $version->id }}">Version: {{ $version->nickname }}</a></li>
        </ol>

        <p><strong>{{ $version->talk->title }} - {{ $version->nickname }}</strong></p>

        <h1>Edit Talk Version</h1>

        <ul class="errors">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>

        {{ Form::open(array('action' => array('TalkVersionsController@update', $version->talk->id, $version->id), 'class' => 'edit-talk-form')) }}

        <div class="form-group">
            {{ Form::label('nickname', 'Nickname for this talk version', ['class' => 'control-label']) }}
            {{ Form::text('nickname', $version->nickname, ['class' => 'form-control']) }}

            <span class="help-block">Each version of each talk has a nickname to distinguish it from the other versions. Something like "Extended Workshop" or "Business Owners version".</span>
        </div>

        <hr>

        <div class="form-group">
            {{ Form::label('title', 'Title', ['class' => 'control-label']) }}
            {{ Form::text('title', $current->title, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('type', 'Type of Talk', ['class' => 'control-label']) }}<br>
            <label class="radio-inline">
                {{ Form::radio('type', 'lightning', true); }} Lightning
            </label>
            <label class="radio-inline">
                {{ Form::radio('type', 'seminar', false); }} Seminar
            </label>
            <label class="radio-inline">
                {{ Form::radio('type', 'keynote', false); }} Keynote
            </label>
            <label class="radio-inline">
                {{ Form::radio('type', 'workshop', false); }} Workshop
            </label>
        </div>

        <div class="form-group">
            {{ Form::label('level', 'Difficulty Level', ['class' => 'control-label']) }}<br>
            <label class="radio-inline">
                {{ Form::radio('level', 'beginner', true); }} Beginner
            </label>
            <label class="radio-inline">
                {{ Form::radio('level', 'intermediate', false); }} Intermediate
            </label>
            <label class="radio-inline">
                {{ Form::radio('level', 'advanced', false); }} Advanced
            </label>
        </div>

        <div class="form-group">
            {{ Form::label('length', 'Length', ['class' => 'control-label']) }}
            <div class="input-group">
                {{ Form::text('length', $current->length, ['class' => 'form-control']) }}
                <div class="input-group-addon">mins</div>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('description', 'Description', ['class' => 'control-label']) }}
            {{ Form::textarea('description', $current->description, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('outline', 'Outline', ['class' => 'control-label']) }}
            {{ Form::textarea('outline', $current->outline, ['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('organizer_notes', 'Organizer Notes', ['class' => 'control-label']) }}
            {{ Form::textarea('organizer_notes', $current->organizer_notes, ['class' => 'form-control']) }}
        </div>


        {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}<br><br>

        {{ Form::close() }}

    </div>
@stop

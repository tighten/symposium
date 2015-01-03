@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/talks/">Talks</a></li>
            <li><a href="/talks/{{ $talk->id }}">Talk: {{ $talk->title }}</a></li>
            <li class="active">Create version</li>
        </ol>

        <p><strong>{{ $talk->title }}</strong></p>

        <h1>Create Talk Version</h1>

        <ul class="errors">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>

        {{ Form::open(array('action' => array('TalkVersionsController@store', $talk->id), 'class' => 'new-talk-form')) }}

        @include('partials.talkversionform')

        {{ Form::submit('Create', ['class' => 'btn btn-default']) }}<br><br>

        {{ Form::close() }}

    </div>
@stop

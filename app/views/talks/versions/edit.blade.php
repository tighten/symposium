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

        @include('partials.talkversionform')

        {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}<br><br>

        {{ Form::close() }}

    </div>
@stop

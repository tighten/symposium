@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/talks/">Talks</a></li>
            <li><a href="/talks/{{ $version->talk->id }}">Talk: {{ $version->talk->title }}</a></li>
            <li class="active"><a href="/talks/{{ $version->talk->id }}/versions/{{ $version->id }}">Version: {{ $version->nickname }}</a></li>
        </ol>

        <h1>Edit Talk Version</h1>

        <ul class="errors">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
        <div class="row">
            {{ Form::open(array('action' => array('TalkVersionsController@update', $version->talk->id, $version->id), 'class' => 'edit-talk-form', 'method' => 'put')) }}
            <div class="col-lg-5 pull-right">
                <h3>Meta data</h3>
                <p><strong>Talk nickname:</strong> {{ $version->talk->title }}<br>
                <strong>Version nickname:</strong> {{ $version->nickname }}</p>
                @include('partials.talkversionformheader')
            </div>
            <div class="col-lg-6">
                @include('partials.talkversionform')

                {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}<br><br>

                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

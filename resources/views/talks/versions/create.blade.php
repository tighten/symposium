@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/talks/">Talks</a></li>
            <li><a href="/talks/{{ $talk->id }}">Talk: {{ $talk->title }}</a></li>
            <li class="active">Create version</li>
        </ol>

        <h1>Create Talk Version</h1>

        <ul class="errors">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>

        <div class="row">
            {{ Form::open(array('action' => array('TalkVersionsController@store', $talk->id), 'class' => 'new-talk-form')) }}

            <div class="col-lg-5 pull-right">
                <h3>Meta data</h3>
                <p><strong>Talk nickname:</strong> {{ $talk->title }}</p>

                @include('partials.talkversionformheader')
            </div>
            <div class="col-lg-6 col-md-8">
                @include('partials.talkversionform')

                {{ Form::submit('Create', ['class' => 'btn btn-default']) }}<br><br>

                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

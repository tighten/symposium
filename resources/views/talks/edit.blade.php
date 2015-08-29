@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li><a href="{{ route('talks.index') }}">Talks</a></li>
            <li><a href="{{ route('talks.show', ['id' => $current->talk_id]) }}">Talk: {{ $current->title }}</a></li>
        </ol>

        <h1>Edit Talk Nickname</h1>

        <ul class="errors">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>

        <div class="row">
            <div class="col-lg-6 col-md-8">
                {{ Form::open(array('action' => array('TalksController@update', $current->talk_id), 'class' => 'edit-talk-form', 'method' => 'put')) }}

                @include('partials.talk-version-form')

                <div class="form-group">
                    {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
                </div>

                {{ Form::close() }}
            </div>
        </div>

    </div>
@stop

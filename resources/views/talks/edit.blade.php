@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li><a href="{{ route('talks.index') }}">Talks</a></li>
            <li><a href="{{ route('talks.show', ['id' => $current->talk_id]) }}">{{ $current->title }}</a></li>
        </ol>

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <h1>Edit Talk</h1>

                <ul class="errors">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>

                {{ Form::open(['action' => ['TalksController@update', $current->talk_id], 'class' => 'edit-talk-form', 'method' => 'put']) }}

                @include('partials.talk-version-form')

                <div class="form-group">
                    {{ Form::submit('Update', ['class' => 'btn btn-block btn-primary']) }}
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

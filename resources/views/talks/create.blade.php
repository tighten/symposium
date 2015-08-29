@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li><a href="{{ route('talks.index') }}">Talks</a></li>
        </ol>

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <h1>Create Talk</h1>

                <ul class="errors">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>

                {{ Form::open(['action' => 'TalksController@store', 'class' => 'new-talk-form']) }}

                @include('partials.talkversionform')

                <div class="form-group">
                    {{ Form::submit('Create', ['class' => 'btn btn-block btn-primary']) }}
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

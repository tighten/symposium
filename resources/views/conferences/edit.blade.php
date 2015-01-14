@extends('layout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Edit Conference</h1>

                <ul class="errors">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>

                {{ Form::open(array('action' => array('ConferencesController@update', $conference->id), 'class' => 'edit-talk-form')) }}

                @include('partials.conferenceform')

                {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}<br><br>

                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

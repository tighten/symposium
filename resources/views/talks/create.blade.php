@extends('layout')

@section('content')

    <div class="container">
        <h1>Create Talk</h1>

        <ul class="errors">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>

        <div class="row">
            {{ Form::open(array('action' => 'TalksController@store', 'class' => 'new-talk-form')) }}

            <div class="col-lg-6">
                @include('partials.talkversionform')

                {{ Form::submit('Create', ['class' => 'btn btn-default']) }}<br><br>

                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

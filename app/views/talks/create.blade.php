@extends('layout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-8">
                <h1>Create Talk</h1>

                <ul class="errors">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>

                {{ Form::open(array('action' => 'TalksController@store', 'class' => 'new-talk-form')) }}

                @include('partials.talkversionform', ['hideVersion' => true])

                {{ Form::submit('Create', ['class' => 'btn btn-default']) }}<br><br>

                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

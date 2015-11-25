@extends('layout')

@section('content')
    <div class="container body">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 create-edit-form">
                <h1 class="page-title">Edit Talk</h1>

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

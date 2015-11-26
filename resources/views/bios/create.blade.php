@extends('layout')

@section('content')
    <div class="container body">
        <div class="row">
            <div class="col-md-6 col-md-push-3 create-edit-form">
                <h1 class="page-title">Create Bio</h1>

                <ul class="errors">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>

                {{ Form::open(array('action' => 'BiosController@store', 'class' => 'new-bio-form')) }}

                @include('partials.bioform')

                {{ Form::submit('Create', ['class' => 'btn btn-primary']) }}

                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

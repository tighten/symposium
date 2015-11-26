@extends('layout')

@section('content')
    <div class="container body">
        <div class="row">
            <div class="col-md-6 col-md-push-3 create-edit-form">
                <h1 class="page-title">Create Conference</h1>

                <ul class="errors">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>

                {{ Form::open(['route' => 'conferences.store', 'class' => 'new-conference-form']) }}

                @include('partials.conferenceform')

                {{ Form::submit('Create', ['class' => 'btn btn-primary']) }}

                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

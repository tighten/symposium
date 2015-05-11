@extends('layout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Create Bio</h1>

                <ul class="errors">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>

                {{ Form::open(array('action' => 'BiosController@store', 'class' => 'new-bio-form')) }}

                @include('partials.bioform')

                {{ Form::submit('Create', ['class' => 'btn btn-primary']) }}<br><br>

                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

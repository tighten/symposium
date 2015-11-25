@extends('layout')

@section('content')

    <div class="container body">
        <div class="row">
            <div class="col-md-6 col-md-push-3 create-edit-form">
                <h1 class="page-title">Edit Bio</h1>

                <ul class="errors">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>

                {{ Form::open(array('action' => array('BiosController@update', $bio->id), 'class' => 'edit-bio-form', 'method' => 'put')) }}

                @include('partials.bioform')

                {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}<br><br>

                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

@extends('layout')

@section('content')
    <div class="container body">
        <div class="row">
            <div class="col-md-6 col-md-push-3 create-edit-form">
                <h1 class="page-title">Edit Conference</h1>

                <ul class="errors">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>

                {!! Form::open(array('action' => array('ConferencesController@update', $conference->id), 'class' => 'edit-conference-form', 'method' => 'put')) !!}

                @include('partials.conferenceform')

                @if (auth()->user()->isAdmin())
                <div class="form-group">
                    {!! Form::label('is_approved', 'Conference Is Approved?', ['class' => 'control-label']) !!}
                    <br>
                    {!! Form::radio('is_approved', true, $conference->is_approved) !!} Yes&nbsp;&nbsp;
                    {!! Form::radio('is_approved', false, !$conference->is_approved) !!} No
                </div>
                @endif

                {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}<br><br>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

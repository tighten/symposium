@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Reset Password</h2>
                    </div>
                    <div class="panel-body">
                        @include('partials.authentication-errors')

                        <form method="POST" action="/password/reset">
                            {{ csrf_field() }}
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                {{ Form::label('email', 'Email', ['class' => 'sr-only']) }}
                                {{ Form::text('email', null, ['autofocus' => 'autofocus', 'class' => 'form-control', 'placeholder' => 'Email address']) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('password', 'Password', ['class' => 'sr-only']) }}
                                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
                            </div>

                            <div class="form-group">
                                {{ Form::label('password_confirmation', 'Password', ['class' => 'sr-only']) }}
                                {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) }}
                            </div>

                            <div class="text-right">
                                {{ Form::submit('Reset Password', ['class' => 'button button--primary']) }}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop




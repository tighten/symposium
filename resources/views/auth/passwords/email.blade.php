@extends('layout')

@section('content')

<div class="row">
    <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
        <div class="panel panel-default panel-on-grey login-box">
            <div class="panel-heading">
                <h2 class="panel-title">Reset Password</h2>
            </div>
            <div class="panel-body">
                @include('partials.authentication-errors')

                <form method="POST" action="/password/email">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        {!! Form::label('email', 'Email', ['class' => 'sr-only']) !!}
                        {!! Form::text('email', null, ['autofocus' => 'autofocus', 'class' => 'form-control', 'placeholder' => 'Email address']) !!}
                    </div>

                    <div class="text-right">
                        {!! Form::submit('Send Password Reset Link', ['class' => 'btn btn-primary']) !!}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

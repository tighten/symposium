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

                    <x-input.text
                        name="email"
                        label="Email"
                        type="email"
                        placeholder="Email address"
                        :hideLabel="true"
                        autofocus="autofocus"
                    ></x-input.text>

                    <x-button.primary
                        type="submit"
                        size="md"
                        class="mt-8"
                    >
                        Send Password Reset Link
                    </x-button.primary>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

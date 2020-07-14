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

                <form method="POST" action="/password/reset">
                    {!! csrf_field() !!}
                    <input type="hidden" name="token" value="{{ $token }}">

                    <x-input.text
                        name="email"
                        label="Email"
                        type="email"
                        placeholder="Email address"
                        :hideLabel="true"
                        autofocus="autofocus"
                    ></x-input.text>

                    <x-input.text
                        name="password"
                        label="Password"
                        type="password"
                        placeholder="Password"
                        :hideLabel="true"
                        class="mt-4"
                    ></x-input.text>

                    <x-input.text
                        name="password_confirmation"
                        label="Password"
                        type="password"
                        placeholder="Confirm Password"
                        :hideLabel="true"
                        class="mt-4"
                    ></x-input.text>

                    <x-button.primary
                        type="submit"
                        size="md"
                    >
                        Reset Password
                    </x-button.primary>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

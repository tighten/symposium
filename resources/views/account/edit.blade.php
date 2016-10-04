@extends('layout')

@section('content')
    <div class="container body">
        <div class="row">
            <div class="col-md-10 col-md-push-1">
                <h2>Edit Account</h2>

                <ul class="errors">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{ Form::model($user, ['route' => 'account.edit', 'method' => 'put', 'files' => 'true']) }}

        <div class="row">
            <div class="col-md-5 col-md-push-1">
                <h3>User</h3>
                <div class="form-group">
                    {{ Form::label('email', 'Email Address', ['class' => 'control-label']) }}
                    {{ Form::email('email', null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('password', 'Password (leave empty to keep the same)', ['class' => 'control-label']) }}
                    {{ Form::password('password', ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('name', 'Name', ['class' => 'control-label']) }}
                    {{ Form::text('name', null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('profile_picture', 'Profile Picture', ['class' => 'control-label']) }}
                    <div class="private-profile-pic">
                        <img src="{{ Auth::user()->profile_picture_hires }}" class="public-speaker-picture" alt="">
                    </div>
                    @if($user->profile_picture == null)
                        <div class="alert alert-warning">
                            <strong>Your current public profile picture is sourced from Gravatar.</strong><br>
                            Please upload a custom profile picture.
                        </div>
                    @endif
                    <span class="help-block">Please use a high resolution image, as it will be provided to conference organizers.</span>
                    {{ Form::file('profile_picture', null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-5 col-md-push-1">
                <h3>Public Profile</h3>

                <div class="form-group">
                    {{ Form::label('enable_profile', 'Show Public Speaker Profile?', ['class' => 'control-label']) }}<br>
                    <span class="help-block">Do you want a public speaker page that you can show to conference organizers?</span>
                    <label class="radio-inline">
                        {{ Form::radio('enable_profile', true, ['id' => 'enable_profile_true']) }} Yes
                    </label>
                    <label class="radio-inline">
                        {{ Form::radio('enable_profile', false, ['id' => 'enable_profile_false']) }} No
                    </label>
                </div>

                <div class="form-group">
                    {{ Form::label('allow_profile_contact', 'Allow contact from your Public Speaker Profile?', ['class' => 'control-label']) }}<br>
                    <span class="help-block">Do you want a contact form on your public speaker profile? Messages will be sent to your email but your email address will remain private.</span>
                    <label class="radio-inline">
                        {{ Form::radio('allow_profile_contact', true, ['id' => 'allow_profile_contact_true']) }} Yes
                    </label>
                    <label class="radio-inline">
                        {{ Form::radio('allow_profile_contact', false, ['id' => 'allow_profile_contact_false']) }} No
                    </label>
                </div>

                <div class="form-group">
                    {{ Form::label('profile_slug', 'Profile URL slug', ['class' => 'control-label']) }}
                    <span class="help-block">The URL slug to be used for your public speaker profile. This will make your profile available at {{ route('speakers-public.show', ['your_slug_here']) }}</span>
                    {{ Form::text('profile_slug', null, ['class' => 'form-control']) }}
                </div>

                <div class="form-group">
                    {{ Form::label('profile_intro', 'Profile Intro', ['class' => 'control-label']) }}
                    <span class="help-block">This paragraph will go at the top of your public speaker profile page. You can use it to communicate any message you'd like to conference organizers.</span>
                    {{ Form::textarea('profile_intro', null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-push-1">
                {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
            </div>
        </div>

        {{ Form::close() }}
    </div>
@stop

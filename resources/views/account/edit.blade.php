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

        {{ Form::model($user, ['route' => 'account.edit', 'method' => 'put']) }}

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
            </div>
            <div class="col-md-5 col-md-push-1">
                <h3>Public Profile</h3>

                <div class="form-group">
                    {{ Form::label('enable_profile', 'Show Public Speaker Profile?', ['class' => 'control-label']) }}<br>
                    <label class="radio-inline">
                        {{ Form::radio('enable_profile', true, ['id' => 'enable_profile_true']) }} Yes
                    </label>
                    <label class="radio-inline">
                        {{ Form::radio('enable_profile', false, ['id' => 'enable_profile_false']) }} No
                    </label>
                    <span class="help-block">Do you want a public speaker page that you can show to conference organizers?</span>
                </div>

               <div class="form-group">
                    {{ Form::label('profile_slug', 'Profile URL slug', ['class' => 'control-label']) }}
                    {{ Form::text('profile_slug', null, ['class' => 'form-control']) }}
                    <span class="help-block">The URL slug to be used for your public speaker profile. This will make your profile available at https://symposiumapp.com/u/your_slug_here</span>
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

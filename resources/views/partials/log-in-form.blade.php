{{ Form::open(['action' => 'AuthController@postLogin']) }}
<div class="form-group">
    {{ Form::label('email', 'Email', ['class' => 'sr-only']) }}
    {{ Form::text('email', null, ['autofocus' => 'autofocus', 'class' => 'form-control', 'placeholder' => 'Email address']) }}
</div>
<div class="form-group">
    {{ Form::label('password', 'Password', ['class' => 'sr-only']) }}
    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
</div>

{{ Form::submit('Sign in', ['class' => 'button button--primary']) }}
{{ Form::close() }}

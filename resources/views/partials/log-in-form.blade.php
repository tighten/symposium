{{ Form::open(['route' => 'login']) }}
<div class="form-group">
    {{ Form::label('email', 'Email', ['class' => 'sr-only']) }}
    {{ Form::text('email', null, ['autofocus' => 'autofocus', 'class' => 'form-control', 'placeholder' => 'Email address']) }}
</div>
<div class="form-group">
    {{ Form::label('password', 'Password', ['class' => 'sr-only']) }}
    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
</div>
<div class="text-right">
    <a href="/password/email" class="btn btn-default">Reset Password</a>
    {{ Form::submit('Log in', ['class' => 'btn btn-primary']) }}
</div>
{{ Form::close() }}

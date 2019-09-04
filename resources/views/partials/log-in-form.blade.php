{!! Form::open(['route' => 'login']) !!}
    {{ csrf_field() }}

    <div class="form-group">
        {!! Form::label('email', 'Email', ['class' => 'sr-only']) !!}
        {!! Form::text('email', null, ['autofocus' => 'autofocus', 'class' => 'form-control', 'placeholder' => 'Email address']) !!}
        <p class="mt-2 text-sm text-red-500 italic">{{ $errors->loginForm->first('email') }}</p>
    </div>

    <div class="form-group">
        {!! Form::label('password', 'Password', ['class' => 'sr-only']) !!}
        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
        <p class="mt-2 text-sm text-red-500 italic">{{ $errors->loginForm->first('password') }}</p>
    </div>

    <div class="text-right">
        <a href="/password/reset" class="btn btn-default">Reset Password</a>
        {!! Form::submit('Log in', ['class' => 'btn btn-primary']) !!}
    </div>
{!! Form::close() !!}

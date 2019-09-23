{!! Form::open(['route' => 'login']) !!}
    {{ csrf_field() }}

    @if ($errors->default->first('email'))
        <p class="mt-2 text-sm text-red-500 italic">{{ $errors->default->first('email') }}</p>
    @endif

    <div class="form-group">
        {!! Form::label('email', 'Email', ['class' => 'sr-only']) !!}
        {!! Form::text('email', null, ['required', 'autofocus' => 'autofocus', 'class' => 'form-control', 'placeholder' => 'Email address']) !!}
        @if ($errors->loginForm->first('email'))
            <p class="mt-2 text-sm text-red-500 italic">{{ $errors->loginForm->first('email') }}</p>
        @endif
    </div>

    <div class="form-group">
        {!! Form::label('password', 'Password', ['class' => 'sr-only']) !!}
        {!! Form::password('password', ['required', 'class' => 'form-control', 'placeholder' => 'Password']) !!}
        @if ($errors->loginForm->first('password'))
            <p class="mt-2 text-sm text-red-500 italic">{{ $errors->loginForm->first('password') }}</p>
        @endif
    </div>

    <div class="text-right">
        <a href="/password/reset" class="btn btn-default">Reset Password</a>
        {!! Form::submit('Log in', ['class' => 'btn btn-primary']) !!}
    </div>
{!! Form::close() !!}

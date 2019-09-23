{!! Form::open(['route' => 'register']) !!}
    <div class="form-group">
        {!! Form::label('email', '*Email Address', ['class' => 'sr-only']) !!}
        {!! Form::email('email', null, ['required', 'autofocus' => 'autofocus', 'class' => 'form-control', 'placeholder' => 'Email address']) !!}
        @if ($errors->registerForm->first('email'))
            <p class="mt-2 text-sm text-red-500 italic">{{ $errors->registerForm->first('email') }}</p>
        @endif
    </div>

    <div class="form-group">
        {!! Form::label('password', '*Password', ['class' => 'sr-only']) !!}
        {!! Form::password('password', ['required', 'class' => 'form-control', 'placeholder' => 'Password']) !!}
        @if ($errors->registerForm->first('password'))
            <p class="mt-2 text-sm text-red-500 italic">{{ $errors->registerForm->first('password') }}</p>
        @endif
    </div>

    <div class="form-group">
        {!! Form::label('name', '*Name', ['class' => 'sr-only']) !!}
        {!! Form::text('name', null, ['required', 'class' => 'form-control', 'placeholder' => 'Name']) !!}
        @if ($errors->registerForm->first('name'))
            <p class="mt-2 text-sm text-red-500 italic">{{ $errors->registerForm->first('name') }}</p>
        @endif
    </div>

    <div class="text-right">
        {!! Form::submit('Sign up', ['class' => 'btn btn-primary']) !!}
    </div>
{!! Form::close() !!}

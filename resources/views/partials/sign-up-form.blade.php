{!! Form::open(['route' => 'register']) !!}
    <div class="form-group">
        {!! Form::label('email', '*Email Address', ['class' => 'sr-only']) !!}
        {!! Form::email('email', null, ['autofocus' => 'autofocus', 'class' => 'form-control', 'placeholder' => 'Email address']) !!}
        <p class="mt-2 text-sm text-red-500 italic">{{ $errors->registerForm->first('email') }}</p>
    </div>

    <div class="form-group">
        {!! Form::label('password', '*Password', ['class' => 'sr-only']) !!}
        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
        <p class="mt-2 text-sm text-red-500 italic">{{ $errors->registerForm->first('password') }}</p>
    </div>

    <div class="form-group">
        {!! Form::label('name', '*Name', ['class' => 'sr-only']) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
        <p class="mt-2 text-sm text-red-500 italic">{{ $errors->registerForm->first('name') }}</p>
    </div>

    <div class="text-right">
        {!! Form::submit('Sign up', ['class' => 'btn btn-primary']) !!}
    </div>
{!! Form::close() !!}

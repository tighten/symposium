@if (!$errors->registerForm->isEmpty())
    <ul class="errors">
        <li>{{ $errors->registerForm->first() }}</li>
    </ul>
@endif

{!! Form::open(['route' => 'register']) !!}
    <div class="form-group">
        {!! Form::label('email', '*Email Address', ['class' => 'sr-only']) !!}
        {!! Form::email('email', null, ['autofocus' => 'autofocus', 'class' => 'form-control', 'placeholder' => 'Email address']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password', '*Password', ['class' => 'sr-only']) !!}
        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('name', '*Name', ['class' => 'sr-only']) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
    </div>

    <div class="text-right">
        {!! Form::submit('Sign up', ['class' => 'btn btn-primary']) !!}
    </div>
{!! Form::close() !!}

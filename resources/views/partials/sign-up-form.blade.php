@if (! $errors->isEmpty())
<ul class="errors">
    @foreach ($errors->all() as $message)
        <li>{{ $message }}</li>
    @endforeach
</ul>
@endif

{{ Form::open(['action' => ['AccountController@store']]) }}
<div class="form-group">
    {{ Form::label('email', '*Email Address', ['class' => 'sr-only']) }}
    {{ Form::email('email', null, ['autofocus' => 'autofocus', 'class' => 'form-control', 'placeholder' => 'Email address']) }}
</div>

<div class="form-group">
    {{ Form::label('password', '*Password', ['class' => 'sr-only']) }}
    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
</div>

<div class="form-group">
    {{ Form::label('name', '*Name', ['class' => 'sr-only']) }}
    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) }}
</div>

<div class="text-right">
    {{ Form::submit('Sign up', ['class' => 'button button--primary']) }}
</div>

{{ Form::close() }}

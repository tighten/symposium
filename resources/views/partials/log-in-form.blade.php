{!! Form::open(['route' => 'login']) !!}
    {{ csrf_field() }}

    @if ($errors->default->first('email'))
        <p class="mt-2 text-sm text-red-500 italic">{{ $errors->default->first('email') }}</p>
    @endif

    <div class="form-group">
        {!! Form::label('email', 'Email', ['class' => 'sr-only']) !!}
        {!! Form::text('email', null, ['required', 'autofocus' => 'autofocus', 'class' => 'form-input mt-1 block w-full rounded-lg', 'placeholder' => 'Email address']) !!}
        @if ($errors->loginForm->first('email'))
            <p class="mt-2 text-sm text-red-500 italic">{{ $errors->loginForm->first('email') }}</p>
        @endif
    </div>

    <div class="mt-2">
        {!! Form::label('password', 'Password', ['class' => 'sr-only']) !!}
        {!! Form::password('password', ['required', 'class' => 'form-input mt-1 block w-full rounded-lg', 'placeholder' => 'Password']) !!}
        @if ($errors->loginForm->first('password'))
            <p class="mt-2 text-sm text-red-500 italic">{{ $errors->loginForm->first('password') }}</p>
        @endif
    </div>

    <div class="mt-8 md:flex md:justify-between">
        <x-button.primary
            type="submit"
            size="md"
            class="block"
        >
            Log in
        </x-button.primary>

        <a href="/password/reset" class="block hover:border-indigo lg:ml-10 lg:mt-0 lg:px-10 lg:py-5 md:inline-block md:px-8 md:py-4 md:text-left mt-4 px-4 py-2 rounded rounded-lg text-center text-indigo whitespace-no-wrap">Reset Password</a>
    </div>
{!! Form::close() !!}

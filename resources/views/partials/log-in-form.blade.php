{!! Form::open(['route' => 'login']) !!}
    {{ csrf_field() }}

    @if ($errors->default->first('email'))
        <p class="mt-2 text-sm text-red-500 italic">
            {{ $errors->default->first('email') }}
        </p>
    @endif

    <x-input.text
        name="email"
        label="Email"
        placeholder="Email address"
        :hideLabel="true"
        autofocus="autofocus"
    ></x-input.text>
    @if ($errors->loginForm->first('email'))
        <p class="mt-2 text-sm text-red-500 italic">
            {{ $errors->loginForm->first('email') }}
        </p>
    @endif

    <x-input.text
        name="password"
        label="Password"
        type="password"
        placeholder="Password"
        :hideLabel="true"
        class="mt-2"
    ></x-input.text>
    @if ($errors->loginForm->first('password'))
        <p class="mt-2 text-sm text-red-500 italic">
            {{ $errors->loginForm->first('password') }}
        </p>
    @endif

    <div class="mt-8 md:flex md:justify-between">
        <x-button.primary
            type="submit"
            size="md"
            class="block w-full md:w-auto"
        >
            Log in
        </x-button.primary>

        <x-button.secondary
            type="submit"
            size="md"
            href="/password/reset"
            class="block mt-4 w-full md:w-auto md:mt-0"
        >
            Reset Password
        </x-button.secondary>
    </div>
{!! Form::close() !!}

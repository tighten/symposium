@extends('layout')

@section('content')

<div class="bg-white py-10 px-10 lg:px-56 mt-8">
    <h2 class="text-4xl mt-8">Are you sure?</h2>

    <p class="mt-8">Are you sure you want to delete your account?</p>

    {!! Form::open(['action' => ['AccountController@destroy']]) !!}
        {!! Form::submit('Yes', [
            'class' => 'bg-indigo-500 font-semibold mt-8 px-8 py-2 rounded text-white text-lg'
        ]) !!}
        <a href="{{ route('account.show') }}" class="border border-indigo-500 text-indigo-500 font-semibold mt-8 px-8 py-2 rounded text-lg inline-block">No</a>
    {!! Form::close() !!}
</div>

@endsection

@extends('layout', ['title' => 'Add Talk'])

@section('content')

<div class="px-10 py-3 max-w-md mx-auto sm:max-w-3xl border-2 border-indigo-200 bg-white rounded mt-4">
    <ul class="errors">
        @foreach ($errors->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>

    {!! Form::open(['action' => 'TalksController@store', 'class' => 'new-talk-form']) !!}

    @include('partials.talk-version-form')

    {!! Form::submit('Create', [
        'class' => 'bg-indigo-500 font-semibold mt-8 px-8 py-2 rounded text-white text-lg cursor-pointer'
    ]) !!}

    {!! Form::close() !!}
</div>

@endsection

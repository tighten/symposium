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

    <x-button.primary
        type="submit"
        size="md"
        class="mt-8"
    >
        Create
    </x-button.primary>

    {!! Form::close() !!}
</div>

@endsection

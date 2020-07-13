@extends('layout', ['title' => 'Add Bio'])

@section('content')

<div class="px-10 py-3 max-w-md mx-auto sm:max-w-3xl border-2 border-indigo-200 bg-white rounded mt-4">
    <ul class="errors">
        @foreach ($errors->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>

    {!! Form::open(array('action' => 'BiosController@store', 'class' => 'new-bio-form')) !!}

    @include('partials.bioform')

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

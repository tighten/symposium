@extends('layout', ['title' => 'Edit Bio'])

@section('content')

<div class="px-10 py-3 max-w-md mx-auto sm:max-w-3xl border-2 border-indigo-200 bg-white rounded mt-4">
    <ul class="errors">
        @foreach ($errors->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>

    {!! Form::open([
        'action' => ['BiosController@update', $bio->id],
        'class' => 'edit-bio-form', 'method' => 'put'
    ]) !!}

    @include('partials.bioform')

    <x-button.primary
        type="submit"
        size="md"
        class="mt-8"
    >
        Update
    </x-button.primary>

    {!! Form::close() !!}
</div>

@endsection

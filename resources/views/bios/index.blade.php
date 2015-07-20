@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="active"><a href="{{ route('bios.index') }}">Bios</a></li>
        </ol>

        <a href="{{ route('bios.create') }}" class="create-button">Create Bio &nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>

        <h2>All Bios</h2>

        <ul class="list-bios">
            @forelse ($bios as $bio)
                <li>
                    @include ('partials.bio-in-list', ['bio' => $bio])
                </li>
            @empty
                <li>No bios yet.</li>
            @endforelse
        </ul>
    </div>
@stop

@extends('layout')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li><a href="{{ route('bios.index') }}">Bios</a></li>
            <li class="active"><a href="{{ route('bios.show', ['id' => $bio->id]) }}">Bio: {{ $bio->nickname }}</a></li>
        </ol>

        <p class="pull-right">
            <a href="{{ route('bios.edit', ['id' => $bio->id]) }}" class="btn btn-default">Edit &nbsp;<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
            <a href="{{ route('bios.delete', ['id' => $bio->id]) }}" class="btn btn-danger">Delete &nbsp;<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
        </p>

        <h1>{{ $bio->nickname }}</h1>

        <p class="bio-meta">Created {{ $bio->created_at->toFormattedDateString() }} | Updated {{ $bio->updated_at->toFormattedDateString() }}</p>

        <p><!-- TODO: Figure out how we will be handling HTML/etc. -->
            {{ str_replace("\n", "<br>", $bio->body) }}</p>

    </div>
@stop

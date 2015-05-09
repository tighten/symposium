@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/bios/">Bios</a></li>
            <li class="active"><a href="/bios/{{ $bio->id }}">Bio: {{ $bio->nickname }}</a></li>
        </ol>

        <p class="pull-right">
            <a href="/bios/{{ $bio->id }}/edit" class="btn btn-default">Edit &nbsp;<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
            <a href="/bios/{{ $bio->id }}/delete" class="btn btn-danger">Delete &nbsp;<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
        </p>

        <h1>{{ $bio->nickname }}</h1>

        <p class="bio-meta">Created {{ $bio->created_at->toFormattedDateString() }} | Updated {{ $bio->updated_at->toFormattedDateString() }}</p>

        <p><!-- TODO: Figure out how we will be handling HTML/etc. -->
            {{ str_replace("\n", "<br>", $bio->body) }}</p>

    </div>
@stop

@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/bios/">Bios</a></li>
            <li class="active"><a href="/bios/{{ $bio->id }}">Bio: {{ $bio->nickname }}</a></li>
        </ol>

        <h1>{{ $bio->nickname }}</h1>

        <p class="pull-right">
            <a href="/bios/{{ $bio->id }}/edit" class="btn btn-default">Edit &nbsp;<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
            <a href="/bios/{{ $bio->id }}/delete" class="btn btn-danger">Delete &nbsp;<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
        </p>

        <p><b>Date created:</b>
            {{ $bio->created_at->toFormattedDateString() }}</p>

        <p><b>Body:</b><br>
            <!-- TODO: Figure out how we will be handling HTML/etc. -->
            {{ str_replace("\n", "<br>", $bio->body) }}</p>

    </div>
@stop

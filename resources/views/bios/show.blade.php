@extends('layout')

@section('content')
    <div class="container body">
        <div class="row">
            <div class="col-md-6 col-md-push-3">
                <p class="pull-right">
                    <a href="{{ route('bios.edit', ['id' => $bio->id]) }}" class="btn btn-default">Edit &nbsp;<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                    <a href="{{ route('bios.delete', ['id' => $bio->id]) }}" class="btn btn-danger">Delete &nbsp;<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                </p>

                <h1>{{ $bio->nickname }}</h1>

                <p class="bio-meta">Created {{ $bio->created_at->toFormattedDateString() }} | Updated {{ $bio->updated_at->toFormattedDateString() }}</p>

                <p><!-- TODO: Figure out how we will be handling HTML/etc. -->
                    {!! str_replace("\n", "<br>", $bio->body) !!}</p>
            </div>
        </div>
    </div>
@stop

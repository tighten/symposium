@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active"><a href="/bios/">Bios</a></li>
        </ol>

        <a href="/bios/create" class="create-button">Create Bio &nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>

        <h2>All Bios</h2>

        <ul class="list-bios">
            @if ($bios->count() == 0)
                <li>No bios yet.</li>
            @endif
            @foreach ($bios as $bio)
                <li>
                    <h3><a href="/bios/{{ $bio->id }}">{{ $bio->nickname }}</a></h3>
                    <?php /* TODO: cleaner substr */ ?>
                    <p>{{ substr($bio->body, 0, 100) }}...</p>
                </li>
            @endforeach
        </ul>
    </div>
@stop

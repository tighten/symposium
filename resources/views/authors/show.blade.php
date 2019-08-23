@extends('layout')

@section('content')

    <div class="container">

        <h1>{{ $author->title }}</h1>

        <h2>User info</h2>
        Name: {{ $author->name }}<br>

        <h2>Talks</h2>
        <ul>
            @foreach ($author->talks as $talk)
                <li><a href="{{ route('talks.show', ['id' => $talk->id]) }}">{{ $talk->title }}</a></li>
            @endforeach
        </ul>
    </div>
@stop

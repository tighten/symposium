@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="active"><a href="{{ route('talks.index') }}">Talks</a></li>
        </ol>
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <p class="pull-right">
                    <a href="{{ route('talks.create') }}" class="btn btn-primary">Create Talk &nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
                </p>

                <h2>My Talks</h2>

                <p class="list-sort">Sort: <a href="{{ route('talks.index') }}?sort=alpha"{{ $sorting_talk['alpha'] }}>Title</a> | <a
                            href="{{ route('talks.index') }}?sort=date"{{ $sorting_talk['date'] }}>Date</a></p>
                <ul class="list-talks">
                    @forelse ($talks as $talk)
                        <li>
                            @include ('partials.talk-in-list', ['talk' => $talk])
                        </li>
                    @empty
                        <li>
                            No talks yet.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@stop

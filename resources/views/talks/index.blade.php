@extends('layout')

@section('content')

    <div class="container body">
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <a href="{{ route('talks.create') }}" class="create-button">Create Talk &nbsp;
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
                <h2 class="page-title">My Talks</h2>
                <a href="{{ route('talks.archived.index') }}" class="btn btn-default btn-xs">Archive</a>
                <p class="list-sort">Sort:
                    <a href="{{ route('talks.index') }}?sort=alpha"{{ $sorting_talk['alpha'] }}>Title</a> |
                    <a href="{{ route('talks.index') }}?sort=date"{{ $sorting_talk['date'] }}>Date</a>
                </p>
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

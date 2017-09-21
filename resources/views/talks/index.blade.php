@extends('layout')

@section('content')

    <div class="container body">
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <a href="{{ route('talks.create') }}" class="create-button">Create Talk &nbsp;
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
                <h2 class="page-title">My Talks</h2>
                <p>
                    <span class="list-sort">Sort: {{ $sorted_by }}
                        <a href="{{ route('talks.index', ['sort' => 'alpha']) }}" class="@sorted($sorted_by, 'alpha')">Title</a> |
                        <a href="{{ route('talks.index', ['sort' => 'date']) }}" class="@sorted($sorted_by, 'date')">Date</a>
                    </span>
                    <a href="{{ route('talks.archived.index') }}" class="btn btn-default btn-xs">Show Archived Talks</a>
                </p>
                <ul class="list-talks">
                  @each('partials.talk-in-list', $talks, 'talk', 'partials.talk-in-list-empty')
                </ul>
            </div>
        </div>
    </div>
@stop

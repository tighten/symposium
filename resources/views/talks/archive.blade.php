@extends('layout')

@section('content')
    <div class="container body">
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <h2 class="page-title">My Archived Talks</h2>
                <p>
                    <span class="list-sort">Sort:
                        <a href="{{ route('talks.archived.index', ['sort' => 'alpha']) }}" class="@sorted($sorted_by, 'alpha')">Title</a> |
                        <a href="{{ route('talks.archived.index', ['sort' => 'date']) }}" class="@sorted($sorted_by, 'date')">Date</a>
                    </span>
                    <a href="{{ route('talks.index', ['sort' => 'alpha']) }}" class="btn btn-default btn-xs">Show Active Talks</a>
                </p>
                <ul class="list-talks">
                  @each('partials.talk-in-list', $talks, 'talk', 'partials.talk-in-list-empty')
                </ul>
            </div>
        </div>
    </div>
@stop

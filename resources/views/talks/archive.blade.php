@extends('layout')

@section('content')
    <div class="container body">
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <h2 class="page-title">My Archived Talks</h2>
                <a href="/talks" class="btn btn-default btn-xs">Show Active Talks</a>
                <p class="list-sort">Sort:
                    <a href="{{ route('talks.archived.index', ['sort' => 'alpha']) }}" class="@sorted($sorted_by, 'alpha')">Title</a> |
                    <a href="{{ route('talks.archived.index', ['sort' => 'date']) }}" class="@sorted($sorted_by, 'date')">Date</a>
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

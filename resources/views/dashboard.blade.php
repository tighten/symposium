@extends('layout')

@section('content')

    <div class="container body">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('talks.create') }}" class="btn btn-primary pull-right btn-sm">Create Talk &nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>

                <a href="{{ route('talks.index') }}"><h2 class="page-title">My Talks</h2></a>

                <p class="list-sort">(sorted by title)</p>
                <ul class="list-talks">
                  @each('partials.talk-in-list', $talks, 'talk', 'partials.talk-in-list-empty')
                </ul>
            </div>
            <div class="col-md-6">
                <a href="{{ route('bios.create') }}" class="btn btn-primary pull-right btn-sm">Create Bio &nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>

                <a href="{{ route('bios.index') }}"><h2 class="page-title">My Bios</h2></a>

                <p class="list-sort">(sorted by title)</p>
                <ul class="list-talks">
                  @each('partials.bio-in-list', $bios, 'bio', 'partials.bio-in-list-empty')
                </ul>
            </div>
        </div>
    </div>
@stop

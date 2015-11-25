@extends('layout')

@section('content')

    <div class="container body">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('talks.create') }}" class="btn btn-primary pull-right btn-sm">Create Talk &nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>

                <a href="{{ route('talks.index') }}"><h2 class="page-title">My Talks</h2></a>

                <p class="list-sort">(sorted by title)</p>
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
            <div class="col-md-6">
                <a href="{{ route('bios.create') }}" class="btn btn-primary pull-right btn-sm">Create Bio &nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>

                <a href="{{ route('bios.index') }}"><h2 class="page-title">My Bios</h2></a>

                <p class="list-sort">(sorted by title)</p>
                <ul class="list-talks">
                    @forelse ($bios as $bio)
                        <li>
                            @include ('partials.bio-in-list')
                        </li>
                    @empty
                        <li>
                            No bios yet.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@stop

@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
        </ol>

        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('talks.index') }}"><h2>My Talks</h2></a>

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
                <a href="{{ route('bios.index') }}"><h2>My Bios</h2></a>

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

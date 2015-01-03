@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active"><a href="/conferences/">Conferences</a></li>
        </ol>

        <h2>All Conferences</h2>
        <a href="/conferences/create" class="create-button">Create Conference</a>

        <p>Sort by: <a href="/conferences?sort=alpha"{{ $sorting_conference['alpha'] }}>Title</a> | <a
                    href="/conferences?sort=date"{{ $sorting_conference['date'] }}>Date</a></p>
        <ul class="list-conferences">
            @foreach ($conferences as $conference)
                <li><h3 @if ($conference->isFavorited())
                        style="font-weight: bold;"
                            @endif ><a href="/conferences/{{ $conference->id }}">{{ $conference->title }}</a></h3>
                    @if ($conference->cfpIsOpen())
                        <span class="label label-info">CFP OPEN</span>
                    @endif

                    <p class="talk-meta"><i>{{ $conference->starts_at->toFormattedDateString()  }} to {{ $conference->ends_at->toFormattedDateString()  }} | CFP open {{ $conference->cfp_starts_at->toFormattedDateString()  }} to {{ $conference->cfp_ends_at->toFormattedDateString()  }}</i></p>
                    @if ($conference->isFavorited())
                    <a href="/conferences/{{ $conference->id  }}/unfavorite">Un-Favorite</a>
                    @else
                        <a href="/conferences/{{ $conference->id  }}/favorite">Favorite</a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@stop

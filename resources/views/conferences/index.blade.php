@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active"><a href="/conferences/">Conferences</a></li>
        </ol>

        <h2>All Conferences</h2>
        <a href="/conferences/create" class="create-button">Create Conference</a>

        <p>
            Sort by:
            {{ HTML::activeLinkRoute('conferences.index', 'Title', ['sort' => 'alpha'], ['class' => 'filter-link']) }} |
            {{ HTML::activeLinkRoute('conferences.index', 'Date', ['sort' => 'date'], ['class' => 'filter-link']) }} |
            {{ HTML::activeLinkRoute('conferences.index', 'CFP is Open', ['sort' => 'cfp_is_open'], ['class' => 'filter-link']) }} |
            {{ HTML::activeLinkRoute('conferences.index', 'CFP Closing Next', ['sort' => 'closing_next'], ['class' => 'filter-link']) }}

        </p>
        <ul class="list-conferences">
            @foreach ($conferences as $conference)
                <li><h3 @if ($conference->isFavorited())
                        style="font-weight: bold;"
                            @endif ><a href="/conferences/{{ $conference->id }}">{{ $conference->title }}</a></h3>
                    @if ($conference->cfpIsOpen())
                        <span class="label label-info">CFP OPEN</span>
                    @endif

                    <p class="talk-meta">
                        <i>Dates: {{ $conference->startsAtDisplay()  }} to {{ $conference->endsAtDisplay()  }}
                            | CFP open dates: {{ $conference->cfpStartsAtDisplay()  }} to {{ $conference->cfpEndsAtDisplay()  }}
                        </i></p>
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

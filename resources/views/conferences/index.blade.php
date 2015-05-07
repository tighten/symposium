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
            Sort:
            {{ HTML::activeLinkRoute('conferences.index', 'Title', ['sort' => 'alpha'], ['class' => 'filter-link']) }} |
            {{ HTML::activeLinkRoute('conferences.index', 'Date', ['sort' => 'date'], ['class' => 'filter-link']) }} |
            {{ HTML::activeLinkRoute('conferences.index', 'CFP is Open', ['sort' => 'cfp_is_open'], ['class' => 'filter-link']) }} |
            {{ HTML::activeLinkRoute('conferences.index', 'CFP Closing Next', ['sort' => 'closing_next'], ['class' => 'filter-link']) }}
        </p>
        <ul class="list-conferences">
            @foreach ($conferences as $conference)
                <li>
                    @if ($conference->isFavorited())
                        <a href="/conferences/{{ $conference->id  }}/unfavorite" class="fav-button fav-button--faved">FAV</a>
                    @else
                        <a href="/conferences/{{ $conference->id  }}/favorite" class="fav-button">FAV</a>
                    @endif
                    <h3 @if ($conference->isFavorited())
                        style="font-weight: bold;"
                            @endif ><a href="/conferences/{{ $conference->id }}">{{ $conference->title }}</a></h3>
                    @if ($conference->cfpIsOpen())
                        <span class="label label-info">CFP OPEN</span>
                    @endif

                    <p class="conference-meta">
                        <i>Dates: <b>{{ $conference->startsAtDisplay() }}</b> to <b>{{ $conference->endsAtDisplay() }}</b>
                            <span {{ $conference->cfpIsOpen() ? '' : 'style="color: #aaa;"' }}>
                            <br>CFP: <b>{{ $conference->cfpStartsAtDisplay() }}</b> to <b>{{ $conference->cfpEndsAtDisplay() }}</b>
                            </span>
                        </i></p>
                    @if ($conference->appliedTo())
                        | Already Sent Proposal
                    @endif

                    <?php /* TODO: cleaner substr */ ?>
                    <p>{{ substr($conference->description, 0, 100) }}...</p>
                </li>
            @endforeach
        </ul>
    </div>
@stop

@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active"><a href="/conferences/">Conferences</a></li>
        </ol>

        <a href="/conferences/create" class="create-button">Create Conference &nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>

        <h2>All Conferences</h2>

        <?php $linkRouteKeys = ['filter' => 'future', 'sort' => 'alpha']; ?>

        <p class="list-sort">
            Filter:
            {{ HTML::activeLinkRoute($linkRouteKeys, 'conferences.index', 'Future', ['filter' => 'future'], ['class' => 'filter-link']) }} |
            {{ HTML::activeLinkRoute($linkRouteKeys, 'conferences.index', 'CFP is Open', ['filter' => 'cfp_is_open'], ['class' => 'filter-link']) }} |
            {{ HTML::activeLinkRoute($linkRouteKeys, 'conferences.index', 'Future CFP', ['filter' => 'future_cfp'], ['class' => 'filter-link']) }} |
            {{ HTML::activeLinkRoute($linkRouteKeys, 'conferences.index', 'All time', ['filter' => 'all'], ['class' => 'filter-link']) }}
        </p>

        <p class="list-sort">
            Sort:
            {{ HTML::activeLinkRoute($linkRouteKeys, 'conferences.index', 'Title', ['sort' => 'alpha'], ['class' => 'filter-link']) }} |
            {{ HTML::activeLinkRoute($linkRouteKeys, 'conferences.index', 'Date', ['sort' => 'date'], ['class' => 'filter-link']) }} |
            {{ HTML::activeLinkRoute($linkRouteKeys, 'conferences.index', 'CFP is Open', ['sort' => 'cfp_is_open'], ['class' => 'filter-link']) }} |
            {{ HTML::activeLinkRoute($linkRouteKeys, 'conferences.index', 'CFP Closing Next', ['sort' => 'closing_next'], ['class' => 'filter-link']) }}
        </p>
        <ul class="list-conferences">
            @foreach ($conferences as $conference)
                <li>
                    @if ($conference->isFavorited())
                        <a href="/conferences/{{ $conference->id  }}/unfavorite" class="fav-button fav-button--faved"><span class="glyphicon glyphicon-star"></a>
                    @else
                        <a href="/conferences/{{ $conference->id  }}/favorite" class="fav-button"><span class="glyphicon glyphicon-star-empty"></a>
                    @endif
                    <h3><a href="/conferences/{{ $conference->id }}">{{ $conference->title }}</a></h3>
                    @if ($conference->cfpIsOpen())
                        <span class="label label-info">CFP OPEN</span>
                    @endif
                    @if ($conference->joindin_id)
                        <a href="http://joind.in/event/view/{{ $conference->joindin_id }}">
                        <span class="label-joindin"><img src="/img/joindin-button.png"></span>
                        </a>
                    @endif

                    <p class="conference-meta">
                        <i>Dates: <b>{{ $conference->startsAtDisplay() }}</b> to <b>{{ $conference->endsAtDisplay() }}</b>
                            <span {{ $conference->cfpIsOpen() ? '' : 'style="color: #aaa;"' }}>
                            <br>CFP: <b>{{ $conference->cfpStartsAtDisplay() }}</b> to <b>{{ $conference->cfpEndsAtDisplay() }}</b>
                            </span>
                        </i></p>
                    @if ($conference->appliedTo())
                        <b>Already Sent Proposal</b>
                    @endif

                    <?php /* TODO: cleaner substr */ ?>
                    <p>{{ substr($conference->description, 0, 100) }}...</p>
                </li>
            @endforeach
        </ul>
    </div>
@stop

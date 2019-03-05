@extends('layout')

@section('content')
    <div class="container body">
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <a href="{{ route('conferences.create') }}"
                   class="create-button">Create Conference &nbsp;<span
                        class="glyphicon glyphicon-plus"
                        aria-hidden="true"></span></a>

                <h2 class="page-title">All Conferences</h2>

                <?php $linkRouteKeysWithDefaults = ['filter' => 'future', 'sort' => 'closing_next']; ?>

                <p class="list-sort">
                    Filter:
                    {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Future', ['filter' => 'future'], ['class' => 'filter-link']) !!}
                    |
                    {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'CFP is Open', ['filter' => 'open_cfp'], ['class' => 'filter-link']) !!}
                    |
                    {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Unclosed CFP', ['filter' => 'unclosed_cfp'], ['class' => 'filter-link']) !!}
                    |
                    @if (Auth::check())
                        {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Favorites', ['filter' => 'favorites'], ['class' => 'filter-link']) !!} |
                        {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Dismissed', ['filter' => 'dismissed'], ['class' => 'filter-link']) !!} |
                    @endif
                    {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'All time', ['filter' => 'all'], ['class' => 'filter-link']) !!}
                </p>

                <p class="list-sort">
                    Sort:
                    {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'CFP Closing Next', ['sort' => 'closing_next'], ['class' => 'filter-link']) !!}
                    |
                    {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'CFP Opening Next', ['sort' => 'opening_next'], ['class' => 'filter-link']) !!}
                    |
                    {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Title', ['sort' => 'alpha'], ['class' => 'filter-link']) !!}
                    |
                    {!! HTML::activeLinkRoute($linkRouteKeysWithDefaults, 'conferences.index', 'Date', ['sort' => 'date'], ['class' => 'filter-link']) !!}
                </p>
                <ul class="list-conferences">
                    @forelse ($conferences as $conference)
                        <li>
                            <div class="conference-actions">
                                @if (Auth::check() && !$conference->isDismissed())
                                    @if ($conference->isFavorited())
                                        <a href="/conferences/{{ $conference->id  }}/unfavorite" class="action-button action-button--faved"><span class="glyphicon glyphicon-star"></a>
                                    @else
                                        <a href="/conferences/{{ $conference->id  }}/favorite" class="action-button"><span class="glyphicon glyphicon-star-empty"></a>
                                    @endif
                                @endif

                                @if (Auth::check() && !$conference->isFavorited())
                                    @if ($conference->isDismissed())
                                        <a href="/conferences/{{ $conference->id  }}/undismiss" class="action-button" title="I am interested in this conference"><span class="glyphicon glyphicon-plus"></a>
                                    @else
                                        <a href="/conferences/{{ $conference->id  }}/dismiss" class="action-button" title="I am not interested in this conference"><span class="glyphicon glyphicon-remove"></a>
                                    @endif
                                @endif
                            </div>

                            <div class="details">
                                <h3><a href="{{ route('conferences.show', ['id' => $conference->id]) }}">{{ $conference->title }}</a></h3>

                                @if ($conference->cfpIsOpen())
                                    <span class="label label-info">CFP OPEN</span>
                                @endif

                                @if ($conference->joindin_id)
                                    <a href="http://joind.in/event/view/{{ $conference->joindin_id }}">
                                        <span class="label-joindin">
                                            <img src="/img/joindin-button.png">
                                        </span>
                                    </a>
                                @endif

                                <p class="conference-meta">
                                    <i>Dates:
                                        <b>{{ $conference->startsAtDisplay() }}</b>
                                        to <b>{{ $conference->endsAtDisplay() }}</b>
                                        <span {{ $conference->cfpIsOpen() ? '' : 'style="color: #aaa;"' }}>
                                        <br>CFP: <b>{{ $conference->cfpStartsAtDisplay() }}</b> to <b>{{ $conference->cfpEndsAtDisplay() }}</b>
                                        </span>
                                    </i>
                                </p>

                                @if (Auth::check() && $conference->appliedTo())
                                    <b>Already Sent Proposal</b>
                                @endif

                                {{-- TODO: cleaner substr --}}
                                <p>{{ mb_substr($conference->description, 0, 100) }}...</p>
                            </div>
                        </li>

                    @empty
                        <li style="margin-left: 0;">
                            No conferences match this filter
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@stop

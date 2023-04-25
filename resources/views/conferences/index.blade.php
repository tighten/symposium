@extends('app', ['title' => 'Conferences'])

@php
    $filterLinks = [
        'future' => [
            'label' => 'Future',
            'route' => 'conferences.index',
            'query' => ['filter' => 'future'],
        ],
        'open_cfp' => [
            'label' => 'CFP is Open',
            'route' => 'conferences.index',
            'query' => ['filter' => 'open_cfp'],
        ],
        'unclosed_cfp' => [
            'label' => 'Unclosed CFP',
            'route' => 'conferences.index',
            'query' => ['filter' => 'unclosed_cfp'],
        ],
    ];

    if (auth()->check()) {
        $filterLinks['favorites'] = [
            'label' => 'Favorites',
            'route' => 'conferences.index',
            'query' => ['filter' => 'favorites'],
        ];
        $filterLinks['dismissed'] = [
            'label' => 'Dismissed',
            'route' => 'conferences.index',
            'query' => ['filter' => 'dismissed'],
        ];
    }

    $filterLinks['all'] = [
        'label' => 'All time',
        'route' => 'conferences.index',
        'query' => ['filter' => 'all'],
    ];
@endphp

@php
    $sortLinks = [
        'closing_next' => [
            'label' => 'CFP Closing Next',
            'route' => 'conferences.index',
            'query' => ['sort' => 'closing_next'],
        ],
        'opening_next' => [
            'label' => 'CFP Opening Next',
            'route' => 'conferences.index',
            'query' => ['sort' => 'opening_next'],
        ],
        'alpha' => [
            'label' => 'Title',
            'route' => 'conferences.index',
            'query' => ['sort' => 'alpha'],
        ],
        'date' => [
            'label' => 'Date',
            'route' => 'conferences.index',
            'query' => ['sort' => 'date'],
        ],
    ];
@endphp

@section('content')
    <x-panel size="xl">
        @each('conferences.listing', $conferences, 'conference', 'conferences.listing-empty')
    </x-panel>

    @if (auth()->user())
        <div class="mt-4 text-right">
            <x-button.primary
                :href="route('conferences.create')"
                icon="plus"
            >
                Suggest a Missing Conference
            </x-button.primary>
        </div>
    @endif
@endsection

@extends('layouts.index', ['title' => 'Conferences'])

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

@section('sidebar')
    <x-side-menu
        title="Filter"
        :links="$filterLinks"
        :defaults="['filter' => 'future', 'sort' => 'closing_next']"
    ></x-side-menu>

    <x-side-menu
        title="Sort"
        :links="$sortLinks"
        :defaults="['filter' => 'future', 'sort' => 'closing_next']"
    ></x-side-menu>
@endsection

@if (auth()->user())
    @section('actions')
        <x-button.primary
            :href="route('conferences.create')"
            icon="plus"
            class="block w-full"
        >
            Add Conference
        </x-button.primary>
    @endsection
@endif


@section('list')
    @each('conferences.listing', $conferences, 'conference', 'conferences.listing-empty')
@endsection

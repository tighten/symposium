@extends('app', ['title' => 'Conferences'])

@php
    $filterOptions = [
        ['label' => 'All', 'value' => 'all'],
        ['label' => 'CFP is Open', 'value' => 'open_cfp'],
        ['label' => 'Unclosed CFP', 'value' => 'unclosed_cfp'],
    ];

    if (auth()->check()) {
        $filterOptions[] = ['label' => 'Favorites', 'value' => 'favorites'];
        $filterOptions[] = ['label' => 'Dismissed', 'value' => 'dismissed'];
    }
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
    <div class="flex">
        <h2 class="text-2xl leading-8 font-semibold text-indigo-600 w-52">
            {{ $date->format('F Y') }}
        </h2>
        <x-button.secondary
            icon="chevron-left"
            aria-label="Previous"
            class="rounded-r-none ml-4"
            :href="route('conferences.index', [
                'year' => $date->subMonth()->year,
                'month' => $date->subMonth()->month,
            ])"
        />
        <x-button.secondary
            icon="chevron-right"
            aria-label="Next"
            class="rounded-l-none border-l-0"
            :href="route('conferences.index', [
                'year' => $date->addMonth()->year,
                'month' => $date->addMonth()->month,
            ])"
        />
    </div>
    <x-input.select
        name="filter"
        label="Filter by"
        option-text="label"
        option-value="value"
        :options="$filterOptions"
    />
    <x-panel size="xl" :padding="false" class="mt-5">
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

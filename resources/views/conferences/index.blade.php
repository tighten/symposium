@extends('app', ['title' => 'Conferences'])

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
    <div>
        <livewire:conference-list/>
    </div>

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

@extends('layout', ['title' => 'My Archived Talks'])

@section('content')

<div class="flex flex-col md:flex-row py-3 max-w-md mx-auto sm:max-w-3xl">
    <div class="w-full md:w-1/4">
        <div class="flex md:flex-col md:items-center">
            <x-side-menu
                title="Filter"
                :links="[
                    'active' => [
                        'label' => 'Active',
                        'route' => 'talks.index',
                        'query' => ['filter' => 'active'],
                    ],
                    'archived' => [
                        'label' => 'Archived',
                        'route' => 'talks.archived.index',
                        'query' => ['filter' => 'archived'],
                    ],
                ]"
                :defaults="['filter' => 'archived', 'sort' => 'alpha']"
            ></x-side-menu>

            <x-side-menu
                title="Sort"
                :links="[
                    'alpha' => [
                        'label' => 'Title',
                        'route' => 'talks.archived.index',
                        'query' => ['sort' => 'alpha']
                    ],
                    'date' => [
                        'label' => 'Date',
                        'route' => 'talks.archived.index',
                        'query' => ['sort' => 'date']
                    ],
                ]"
                :defaults="['filter' => 'archived', 'sort' => 'alpha']"
                class="mt-4"
            ></x-side-menu>
        </div>
        <x-button.primary
            :href="route('talks.create')"
            icon="plus"
            class="block mt-4 w-full"
        >
            Add Talk
        </x-button.primary>
    </div>
    <div class="w-full md:w-3/4 md:ml-4">
        @each('talks.listing', $talks, 'talk', 'talks.listing-empty')
    </div>
</div>

@endsection

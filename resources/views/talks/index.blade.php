@extends('layouts.index', ['title' => 'My Talks'])

@section('content')

@section('sidebar')
    <div class="flex md:flex-col">
        <x-side-menu
            title="Filter"
            :links="[
                'alpha' => [
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
            :defaults="['filter' => 'active', 'sort' => 'alpha']"
        ></x-side-menu>

        <x-side-menu
            title="Sort"
            :links="[
                'alpha' => [
                    'label' => 'Title',
                    'route' => 'talks.index',
                    'query' => ['sort' => 'alpha']
                ],
                'date' => [
                    'label' => 'Date',
                    'route' => 'talks.index',
                    'query' => ['sort' => 'date']
                ],
            ]"
            :defaults="['filter' => 'active', 'sort' => 'alpha']"
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
@endsection

@section('list')
    @each('talks.listing', $talks, 'talk', 'talks.listing-empty')
@endsection

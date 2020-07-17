@extends('layouts.index', ['title' => 'Account'])

@section('sidebar')
    <x-side-menu
        title="Actions"
        :links="[
            'edit' => [
                'label' => 'Edit account',
                'route' => 'account.edit',
            ],
            'delete' => [
                'label' => 'Delete account',
                'route' => 'account.delete',
            ],
            'export' => [
                'label' => 'Export data',
                'route' => 'account.export',
            ],
            'oauth' => [
                'label' => 'oAuth settings',
                'route' => 'account.oauth-settings',
            ],
        ]"
    ></x-side-menu>
@endsection

@section('list')
    <x-panel size="md" title="User">
        <div class="mt-4">
            <div class="text-gray-500">Email</div>
            {{ $user->email }}
        </div>
        <div class="mt-4">
            <div class="text-gray-500">Name</div>
            {{ $user->name }}
        </div>
        <div class="mt-4">
            <div class="text-gray-500">Speaker profile enabled?</div>
            {{ $user->enable_profile ? 'Yes' : 'No' }}
        </div>
        <div class="mt-4">
            <div class="text-gray-500">Speaker public contact allowed?</div>
            {{ $user->allow_profile_contact ? 'Yes' : 'No' }}
        </div>

        @if ($user->profile_slug)
            <div class="mt-4">
                <div class="text-gray-500">Speaker profile URL slug</div>
                <a href="{{ route('speakers-public.show', $user->profile_slug) }}">{{ route('speakers-public.show', [$user->profile_slug]) }}</a>
            </div>
        @endif

        @if ($user->location)
            <div class="mt-4">
                <div class="text-gray-500">Location</div>
                {{ $user->location }}
            </div>
        @endif

        <div class="mt-4">
            <div class="text-gray-500">Notifications enabled?</div>
            {{ $user->wants_notifications ? 'Yes' : 'No' }}
        </div>
    </x-panel>

    <x-panel size="md" class="mt-4" title="Dismissed Conferences">
        @forelse ($user->dismissedConferences as $conference)
            <div class="mt-4">
                <a href="{{ route('conferences.show', ['id' => $conference->id]) }}">{{  $conference->title }}</a>
            </div>
        @empty
            <div class="mt-4">(none)</div>
        @endforelse
    </x-panel>
@endsection


@extends('layout', ['title' => 'Account'])

@section('content')

<div class="flex flex-col md:flex-row py-3 max-w-md mx-auto sm:max-w-3xl">
    <div class="w-full md:w-1/4">
        <div class="border-2 border-indigo-200 bg-white rounded mt-4 font-sans">
            <div class="bg-indigo-150 p-4">Actions</div>
            <div class="flex flex-col p-4">
                <a href="{{ route('account.edit') }}" class="m-1">Edit account</a>
                <a href="{{ route('account.delete') }}" class="m-1">Delete account</a>
                <a href="{{ route('account.export') }}" class="m-1">Export data</a>
                <a href="{{ route('account.oauth-settings') }}" class="m-1">oAuth settings</a>
            </div>
        </div>
    </div>
    <div class="w-full md:w-3/4 md:ml-4">
        <div class="bg-white p-4 border-2 border-indigo-200 rounded mt-4">
            <h3 class="font-sans m-0">User</h3>
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
                    <a href="{{ route('speakers-public.show', [$user->profile_slug]) }}">{{ route('speakers-public.show', [$user->profile_slug]) }}</a>
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
        </div>
        <div class="bg-white p-4 border-2 border-indigo-200 rounded mt-4">
            <h3 class="font-sans m-0">Dismissed Conferences</h3>
            @forelse ($user->dismissedConferences as $conference)
                <div class="mt-4">
                    <a href="{{ route('conferences.show', ['id' => $conference->id]) }}">{{  $conference->title }}</a>
                </div>
            @empty
                <div class="mt-4">(none)</div>
            @endforelse
        </div>
    </div>
</div>

@endsection

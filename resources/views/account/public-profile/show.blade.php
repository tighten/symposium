@extends('app')

@section('content')

<x-panel>
    <div class="flex flex-col items-center sm:flex-none sm:items-start">
        <a href="{{ $user->profile_picture_hires }}">
            <img src="{{ $user->profile_picture_hires }}" class="rounded-full h-56 w-56">
        </a>
        @if ($user->allow_profile_contact)
            <a
                href="{{ route('speakers-public.email', $user->profile_slug) }}"
                class="no-underline block mt-10 text-indigo"
            >
                Contact {{ $user->name }}
            </a>
        @endif
    </div>
    <div class="flex-shrink pr-10">
        <h2 class="text-4xl">{{ $user->name }}</h2>
        <p>{!! str_replace("\n", "<br>", htmlentities($user->profile_intro)) !!}</p>

        <h3 class="text-3xl mt-8">Talks</h3>
        @forelse ($talks as $talk)
            <h4 class="text-2xl text-indigo">
                <a href="{{ route('speakers-public.talks.show', ['profileSlug' => $user->profile_slug, 'talkId' => $talk->id]) }}">
                    {{ $talk->current()->title }}
                </a>
            </h4>
            <p class="text-sm text-gray-500">
                {{ $talk->current()->length }}-minute {{ $talk->current()->type }} talk at {{ $talk->current()->level }} level
            </p>
        @empty
            This speaker has not made any of their talks public yet.
        @endforelse

        @if ($bios->count() == 0)
            <h3 class="text-3xl mt-8">Bios</h3>
            This speaker has not made any of their bios public yet.
        @elseif ($bios->count() == 1)
            <h3 class="text-3xl mt-8">Bio ({{ $bios->first()->nickname }})</h3>
            <p>{!! str_replace("\n", "<br>", $bios->first()->body) !!}</p>
        @else
            <h3 class="text-3xl mt-8">Bios</h3>
            @foreach ($bios as $bio)
                <h4 class="text-2xl text-indigo">
                    <a href="{{ route('speakers-public.bios.show', ['profileSlug' => $user->profile_slug, 'bioId' => $bio->id]) }}">
                        {{ $bio->nickname }}
                    </a>
                </h4>
            @endforeach
        @endif

        @if ($user->location)
            <h3 class="text-3xl mt-8">Location</h3>
            <p>{{ $user->location }}</p>
        @endif
    </div>
</x-panel>

@endsection


@extends('app')

@section('content')

<x-panel>
    <div class="flex flex-col items-center sm:flex-none sm:items-start">
        <a href="{{ $user->profile_picture_hires }}">
            <img src="{{ $user->profile_picture_hires }}" class="rounded-full h-56 w-56">
        </a>

        <h2 class="text-4xl">{{ $user->name }}</h2>

        @if ($user->location)
            <small class="text-lg text-gray-500">{{ $user->location }}</small>
        @endif

        <p class="mt-8">
            {!! str_replace("\n", "<br>", htmlentities($user->profile_intro)) !!}
        </p>

        @if ($user->allow_profile_contact)
            <a
                href="{{ route('speakers-public.email', $user->profile_slug) }}"
                class="no-underline block mt-8 text-indigo"
            >
                Contact {{ $user->name }}
            </a>
        @endif
    </div>
</x-panel>

<x-panel title="Talks" class="mt-6">
    <div class="space-y-4">
        @forelse ($talks as $talk)
            <h4 class="text-2xl text-indigo">
                <a href="{{ route('speakers-public.talks.show', ['profileSlug' => $user->profile_slug, 'talkId' => $talk->id]) }}">
                    {{ $talk->currentRevision->title }}
                </a>
            </h4>
            <span class="text-sm text-gray-500">
                {{ $talk->currentRevision->length }}-minute {{ $talk->currentRevision->type }} talk at {{ $talk->currentRevision->level }} level
            </span>
        @empty
            This speaker has not made any of their talks public yet.
        @endforelse
    </div>
</x-panel>

<x-panel title="Bios" class="mt-6">
    <div class="space-y-4">
        @if ($bios->count() == 0)
            This speaker has not made any of their bios public yet.
        @elseif ($bios->count() == 1)
            <h3 class="text-3xl mt-8">Bio ({{ $bios->first()->nickname }})</h3>
            <p>{!! str_replace("\n", "<br>", $bios->first()->body) !!}</p>
        @else
            @foreach ($bios as $bio)
                <h4 class="text-2xl text-indigo">
                    <a href="{{ route('speakers-public.bios.show', ['profileSlug' => $user->profile_slug, 'bioId' => $bio->id]) }}">
                        {{ $bio->nickname }}
                    </a>
                </h4>
            @endforeach
        @endif
    </div>
</x-panel>

@endsection


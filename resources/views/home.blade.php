@extends('app')

@section('content')

<div class="flex flex-col items-center justify-around max-w-md px-8 pt-0 pb-6 mx-auto md:flex-row md:py-12 sm:max-w-6xl pm-12 sm:mt-3">
    <div class="space-y-8">
        <h1 class="font-sans text-5xl leading-none text-black">Connecting<br>Speakers<br>&amp; Conferences</h1>
        <a
            class="block px-10 py-5 transition duration-150 ease-in-out border rounded rounded-lg md:inline-block border-indigo text-indigo hover:text-white hover:bg-indigo"
            href="https://www.youtube.com/watch?v=60hxVJpEXhw"
            target="_blank"
        >
            @svg('rectangle', 'inline w-2 mr-2')
            Watch Demo
        </a>
    </div>
    @svg('home', 'max-w-md md:order-first sm:pr-4')
</div>

<div class="relative bg-indigo-100">
    <div class="max-w-md px-1 py-12 pb-40 mx-auto sm:max-w-6xl">
        <div class="flex flex-col items-center mx-auto mb-16">
            @svg('podium', 'mw-24')
            <h2 class="font-sans text-5xl text-center text-indigo">Conference Speakers</h2>
            <div class="max-w-2xl font-sans text-3xl text-center">Symposium helps conference speakers plan and manage talk abstracts, CFP submissions, bios, photos, and speaking schedule.</div>
        </div>
        <div class="flex flex-wrap">
            <div class="w-full px-6 pb-6 mb-8 md:w-1/2 lg:w-1/3 lg:pl-0 md:pb-0">
                @svg('icon_tracktalks', 'mx-auto md:ml-3 w-16')
                <div class="mt-5 mb-4 font-sans text-2xl font-semibold text-center md:text-left">Track talks</div>
                <div class="font-sans text-xl">Track all of your talks, each with one or more versions and each version with a full revision history.</div>
            </div>
            <div class="w-full px-6 pb-6 mb-8 md:w-1/2 lg:w-1/3 md:pb-0">
                @svg('icon_versioncontrol', 'mx-auto md:ml-3 w-16')
                <div class="mt-5 mb-4 font-sans text-2xl font-semibold text-center md:text-left">Talk version control</div>
                <div class="font-sans text-xl">Look at which of each talk you submitted to each conference, and how many times each talk has been accepted and rejected.</div>
            </div>
            <div class="w-full px-6 pb-6 mb-8 md:w-1/2 lg:w-1/3 lg:pr-0 md:pb-0">
                @svg('icon_trackconferences', 'mx-auto md:ml-3 w-16')
                <div class="mt-5 mb-4 font-sans text-2xl font-semibold text-center md:text-left">Track conferences</div>
                <div class="font-sans text-xl">Track which conferences have accepted or rejected your talk submissions.</div>
            </div>
            <div class="w-full px-6 pb-6 mb-8 md:w-1/2 lg:w-1/3 lg:pl-0 md:pb-0">
                @svg('icon_find', 'mx-auto md:ml-3 w-16')
                <div class="mt-5 mb-4 font-sans text-2xl font-semibold text-center md:text-left">Find conferences</div>
                <div class="font-sans text-xl">Find which conferences you're interested in applying to speak at; favorite them, track them, and get reminders when their CFPs open and close.</div>
            </div>
            <div class="w-full px-6 pb-6 mb-8 md:w-1/2 lg:w-1/3 md:pb-0">
                @svg('icon_bios', 'mx-auto md:ml-3 w-16')
                <div class="mt-5 mb-4 font-sans text-2xl font-semibold text-center md:text-left">Bios</div>
                <div class="font-sans text-xl">Store and version multiple biographies for sending in with your talk submissions.</div>
            </div>
            <div class="w-full px-6 pb-6 mb-8 md:w-1/2 lg:w-1/3 lg:pr-0 md:pb-0">
                @svg('icon_photos', 'mx-auto md:ml-3 w-16')
                <div class="mt-5 mb-4 font-sans text-2xl font-semibold text-center md:text-left">Photos</div>
                <div class="font-sans text-xl">Store multiple revisions of your bio photos, ready to grab snd upload with your talk submissions.</div>
            </div>
        </div>
    </div>
</div>

<div class="pb-24 bg-indigo-500">
    <div class="relative max-w-md px-0 py-12 mx-auto -mt-20 bg-white rounded-lg shadow sm:mx-10 lg:mx-auto sm:max-w-6xl md:max-w-4xl">
        <div class="flex flex-col items-center">
            @svg('badge')
            <h2 class="mb-12 font-sans text-3xl text-indigo lg:text-5xl">Conference Organizers</h2>
            <div class="max-w-3xl px-6 mx-auto font-sans text-xl text-center md:text-2xl lg:text-3xl">Symposium helps conference organizers receive submissions by allowing speakers to submit to any conference powered by a CFP platform that's compatible with Symposium-right now we're working toward an OpenCFP integration.</div>
        </div>
    </div>
    <div class="max-w-md mx-auto mt-20 sm:max-w-6xl">
        <h2 class="font-sans text-5xl text-center text-white">Our Speakers</h2>
        <div class="flex flex-wrap justify-between mt-16">
            @foreach ($speakers as $speaker)
                <div class="flex flex-col items-center w-1/2 sm:w-1/3 xl:w-1/6">
                    <img
                        class="w-32 h-32 rounded-full"
                        style="filter:grayscale(100%);"
                        src="{{ $speaker->profile_picture_hires }}"
                        alt="{{ $speaker->name }} profile picture"
                    >
                    <div class="p-8 text-center text-white">{{ $speaker->name }}</div>
                </div>
            @endforeach
        </div>
        <div class="mt-20 text-center">
            <a
                class="px-8 py-6 font-sans text-xl font-semibold text-white transition duration-150 ease-in-out border rounded hover:bg-white hover:text-indigo-800"
                href="{{ route('speakers-public.index') }}"
            >
                View all speakers
            </a>
        </div>
    </div>
</div>

<div class="bg-indigo-800">
    <div class="flex flex-col max-w-md px-8 py-32 mx-auto sm:max-w-6xl">
        <h2 class="font-sans text-5xl text-center text-white">Conferences</h2>
        <div class="flex flex-wrap justify-between mt-20 mb-16 lg:flex-nowrap">
            @foreach ($conferences as $conference)
                <div class="relative w-full px-8 pt-12 pb-24 mb-10 font-sans bg-white rounded-lg shadow lg:w-1/3 lg:first:mr-8 lg:last:ml-8 last:mb-0 lg:mb-0">
                    <div class="mb-12 text-2xl text-center text-indigo-800">{{ $conference->title }}</div>
                    <div class="text-xl font-medium">{{ $conference->event_dates_display }}</div>
                    <div class="mt-6 text-xl">{{ str($conference->description)->limit(100) }}</div>
                    <div class="absolute bottom-0 block my-10">
                        <a
                            class="text-xl font-semibold text-indigo-800"
                            href="{{ route('conferences.show', $conference) }}"
                        >
                            More Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-16 text-center">
            <a
                class="px-8 py-6 font-sans text-xl font-semibold text-white transition duration-150 ease-in-out border rounded hover:bg-white hover:text-indigo-800"
                href="{{ route('conferences.index') }}"
            >
                View all conferences
            </a>
        </div>
    </div>
</div>

@endsection

@include('partials.flash-messages')
<header class="bg-indigo-600">
    <nav class="max-w-xl h-16 px-2 sm:px-0 mx-auto sm:max-w-7xl flex items-center justify-between">
        <menu-toggle>
            <div slot-scope="{show, toggle}" class="flex items-center justify-between">
                <div
                    class="bg-indigo-600 block gap-4 text-sm text-white lg:flex lg:items-center"
                    :class="show ? 'absolute w-full top-4' : ''"
                >
                    <a
                        href="{{ auth()->check() ? route('dashboard') : url('/') }}"
                        class="block px-4"
                        :class="show ? 'pb-4' : ''"
                    >
                        @svg('logo')
                    </a>
                    @if (auth()->check())
                        <x-nav-item route="dashboard">Dashboard</x-nav-item>
                        <x-nav-item route="bios.index">Bios</x-nav-item>
                        <x-nav-item route="conferences.index">Conferences</x-nav-item>
                        <x-nav-item route="calendar.index">Calendar</x-nav-item>
                        <x-nav-item route="talks.index">Talks</x-nav-item>
                    @else
                        <x-nav-item route="what-is-this">How it Works</x-nav-item>
                        <x-nav-item route="speakers-public.index">Our speakers</x-nav-item>
                        <x-nav-item route="conferences.index">Conferences</x-nav-item>
                    @endif
                </div>
                <x-button.mobile-nav/>
            </div>
        </menu-toggle>

        @if (auth()->guest())
            <x-menu>
                <x-slot
                    name="trigger"
                    class="bg-indigo-700 border border-white px-3 py-2 rounded text-sm text-white"
                >
                    Sign in
                </x-slot>
                <x-slot name="items">
                    <x-menu.item route="login">Sign in with email</x-menu.item>
                    <x-menu.item url="login/github">Sign in with GitHub</x-menu.item>
                </x-slot>
            </x-menu>
        @else
            <x-menu>
                <x-slot name="trigger" class="pr-4">
                    <img
                        src="{{ auth()->user()->profile_picture_thumb }}"
                        class="hidden inline rounded-full w-8 lg:block"
                    >
                </x-slot>
                <x-slot name="items">
                    <x-menu.item route="account.show">Account</x-menu.item>
                    <x-menu.item
                        url="{{ route('speakers-public.show', auth()->user()->profile_slug) }}"
                        :show="auth()->user()->enable_profile"
                    >
                        Public Speaker Profile
                    </x-menu.item>
                    <x-menu.item route="log-out">Log out</x-menu.item>
                </x-slot>
            </x-menu>
        @endif
    </nav>
</header>

@if ($title)
    @php
        $app_header = $is_conferences ? 'sm:max-w-5xl' : 'sm:max-w-3xl'
    @endphp
    <div class="max-w-md mx-auto mt-3 border-t border-gray-300 sm:max-w-6xl">
        <div class="mx-auto {{ $app_header }}">
            <h2 class="mt-3 font-sans text-2xl text-black">{{ $title }}</h2>
        </div>
    </div>
@endif

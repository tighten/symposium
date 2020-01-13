<nav :class="slotProps.showNav ? 'block' : 'hidden'" class="pt-2 py-2 pl-4 sm:pl-0 sm:flex font-sans font-semibold text-sm text-indigo items-center block">
    @if (Auth::check())
        @php
            $menuItems = [
                [
                    'title' => 'Dashboard',
                    'url' => route('dashboard'),
                    'classes' => 'mr-4 sm:mr-2 md:mr-4',
                ],
                [
                    'title' => 'Bios',
                    'url' => route('bios.index'),
                    'classes' => 'mr-4 sm:mx-2 md:mx-4 mt-2 sm:mt-0',
                ],
                [
                    'title' => 'Conferences',
                    'url' => route('conferences.index'),
                    'classes' => 'mr-4 sm:mx-2 md:mx-4 mt-2 sm:mt-0',
                ],
                [
                    'title' => 'Calendar',
                    'url' => route('calendar.index'),
                    'classes' => 'mr-4 sm:mx-2 md:mx-4 mt-2 sm:mt-0',
                ],
                [
                    'title' => 'Talks',
                    'url' => route('talks.index'),
                    'classes' => 'mr-4 sm:mx-2 md:mx-4 mt-2 sm:mt-0 border-none',
                ],

            ];
        @endphp
        {{-- <li class="" role="presentation">
            <a class="" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                <img src="{{ Auth::user()->profile_picture_thumb }}" class="nav-profile-picture inline"> Me <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <a href="{{ route('account.show') }}">Account</a>
                @if (Auth::user()->enable_profile)
                <a href="{{ route('speakers-public.show', [Auth::user()->profile_slug]) }}">Public Speaker Profile</a>
                @endif
                <a href="{{ route('log-out') }}">Log out</a>
            </ul> --}}

    @else
        @php
            $menuItems = [
                [
                    'title' => 'How it Works',
                    'url' => url('what-is-this'),
                    'classes' => 'mr-4 sm:mr-2 md:mr-4',
                ],
                [
                    'title' => 'Our speakers',
                    'url' => url('speakers'),
                    'classes' => 'mr-4 sm:mx-2 md:mx-4 mt-2 sm:mt-0',
                ],
                [
                    'title' => 'Conferences',
                    'url' => route('conferences.index'),
                    'classes' => 'mr-4 sm:mx-2 md:mx-4 mt-2 sm:mt-0',
                ],
            ];
        @endphp
    @endif

    @foreach ($menuItems as $item)
        <a class="block border-b border-indigo border-solid hover-bg-indigo-800 py-1 sm:border-none uppercase {{ $item['classes'] }}"
           href="{{ $item['url'] }}"
        >
            {{ $item['title'] }}
        </a>
    @endforeach

    @if (! Auth::check())
        <a class="border border-indigo hover-bg-indigo-800 inline-block md:ml-4 mt-4 px-8 py-2 rounded rounded-lg sm:block sm:ml-2 sm:mt-0 sm:mt-1 sm:px-4" href="{{ route('login') }}">Sign in</a>
    @endif
    {{-- Disable email registration --}}
    {{-- <a href="{{ route('register') }}">Sign up</a> --}}
</nav>

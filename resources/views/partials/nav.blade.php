<nav :class="slotProps.showNav ? 'block' : 'hidden'" class="pt-2 py-2 pl-4 lg:pl-0 lg:flex font-sans font-semibold text-sm text-indigo-500 items-center block relative">
    @if (Auth::check())
        @php
            $menuItems = [
                [
                    'title' => 'Dashboard',
                    'url' => route('dashboard'),
                    'classes' => 'ml-0 mr-4 sm:mx-2 md:mx-4',
                ],
                [
                    'title' => 'Bios',
                    'url' => route('bios.index'),
                    'classes' => 'mr-4 sm:mx-2 md:mx-4 mt-2 lg:mt-0',
                ],
                [
                    'title' => 'Conferences',
                    'url' => route('conferences.index'),
                    'classes' => 'mr-4 sm:mx-2 md:mx-4 mt-2 lg:mt-0',
                ],
                [
                    'title' => 'Calendar',
                    'url' => route('calendar.index'),
                    'classes' => 'mr-4 sm:mx-2 md:mx-4 mt-2 lg:mt-0',
                ],
                [
                    'title' => 'Talks',
                    'url' => route('talks.index'),
                    'classes' => 'mr-4 sm:ml-2 md:ml-4 mt-2 lg:mt-0',
                ],

            ];
        @endphp
    @else
        @php
            $menuItems = [
                [
                    'title' => 'How it Works',
                    'url' => url('what-is-this'),
                    'classes' => 'ml-0 mr-4 sm:mx-2 md:mx-4',
                ],
                [
                    'title' => 'Our speakers',
                    'url' => url('speakers'),
                    'classes' => 'mr-4 sm:mx-2 md:mx-4 mt-2 lg:mt-0',
                ],
                [
                    'title' => 'Conferences',
                    'url' => route('conferences.index'),
                    'classes' => 'mr-4 sm:mx-2 md:mx-4 sm:mr-0 mt-2 lg:mt-0',
                ],
            ];
        @endphp
    @endif

    @foreach ($menuItems as $item)
        <a class="block border-b border-indigo border-solid hover:text-indigo-800 py-1 lg:border-none uppercase {{ $item['classes'] }}"
           href="{{ $item['url'] }}"
        >
            {{ $item['title'] }}
        </a>
    @endforeach

    @if (! Auth::check())
        <div class="sm:ml-2 my-4 lg:mb-0 lg:mt-0 flex lg:block">
            <a class="border border-indigo hover-bg-indigo-800 inline-block md:ml-2 lg:ml-4 mt-4 px-8 py-2 rounded rounded-lg lg:block lg:ml-2 lg:mt-0 lg:mt-0 lg:px-4" href="#" v-on:click="slotProps.toggleSignInDropdown">
                Sign in
            </a>
            <div class="ml-32 mr-4 lg:mx-0 mt-0 lg:mt-2 py-1 flex flex-col absolute bg-white border border-indigo rounded z-50 xl:right-0" :class="slotProps.showSignInDropdown ? 'block' : 'hidden'">
                <a class="px-2 py-1 hover:bg-indigo-100" href="{{ route('login') }}">Sign in with email</a>
                <a class="px-2 py-1 hover:bg-indigo-100" href="{{ url('login/github') }}">Sign in with GitHub</a>
            </div>
        </div>
    @else
        <div class="mt-4 lg:mt-0">
            <a class="mr-4 lg:mx-2 md:mx-4 mt-2 lg:mt-0 flex lg:flex-row-reverse items-center" href="#" v-on:click="slotProps.toggleAccountDropdown">
                <img src="{{ Auth::user()->profile_picture_thumb }}" class="nav-profile-picture inline ml-2">
                <div class="inline text-indigo-500 hover:text-indigo-800">
                    <span class="caret"></span>
                    <span class="mx-2">Me</span>
                </div>
            </a>
            <div class="mr-4 lg:mx-2 md:mx-4 mt-2 px-2 py-1 flex flex-col absolute bg-white border border-indigo rounded" :class="slotProps.showAccountDropdown ? 'block' : 'hidden'">
                <a class="py-1" href="{{ route('account.show') }}">Account</a>
                @if (Auth::user()->enable_profile)
                    <a class="py-1" href="{{ route('speakers-public.show', Auth::user()->profile_slug) }}">Public Speaker Profile</a>
                @endif
                <a class="py-1" href="{{ route('log-out') }}">Log out</a>
            </div>
        </div>
    @endif
    {{-- Disable email registration --}}
    {{-- <a href="{{ route('register') }}">Sign up</a> --}}
</nav>

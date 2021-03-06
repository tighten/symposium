<nav :class="slotProps.showNav ? 'block' : 'hidden'" class="relative items-center block py-2 pt-2 pl-4 font-sans text-sm font-semibold text-indigo-800 lg:pl-0 lg:flex">
    @if (auth()->check())
        @php
            $menuItems = [
                [
                    'title' => 'Dashboard',
                    'url' => route('dashboard'),
                    'classes' => 'font-medium ml-0 mr-4 sm:mx-2 md:mx-4',
                ],
                [
                    'title' => 'Bios',
                    'url' => route('bios.index'),
                    'classes' => 'font-medium mr-4 sm:mx-2 md:mx-4 mt-2 lg:mt-0',
                ],
                [
                    'title' => 'Conferences',
                    'url' => route('conferences.index'),
                    'classes' => 'font-medium mr-4 sm:mx-2 md:mx-4 mt-2 lg:mt-0',
                ],
                [
                    'title' => 'Calendar',
                    'url' => route('calendar.index'),
                    'classes' => 'font-medium mr-4 sm:mx-2 md:mx-4 mt-2 lg:mt-0',
                ],
                [
                    'title' => 'Talks',
                    'url' => route('talks.index'),
                    'classes' => 'font-medium mr-4 sm:ml-2 md:ml-4 mt-2 lg:mt-0',
                ],

            ];
        @endphp
    @else
        @php
            $menuItems = [
                [
                    'title' => 'How it Works',
                    'url' => url('what-is-this'),
                    'classes' => 'font-medium ml-0 mr-4 sm:mx-2 md:mx-4',
                ],
                [
                    'title' => 'Our speakers',
                    'url' => url('speakers'),
                    'classes' => 'font-medium mr-4 sm:mx-2 md:mx-4 mt-2 lg:mt-0',
                ],
                [
                    'title' => 'Conferences',
                    'url' => route('conferences.index'),
                    'classes' => 'font-medium mr-4 sm:mx-2 md:mx-4 sm:mr-0 mt-2 lg:mt-0',
                ],
            ];
        @endphp
    @endif

    @foreach ($menuItems as $item)
        <a class="block border-b border-indigo border-solid hover:text-indigo-500 py-1 lg:border-none uppercase {{ $item['classes'] }}"
           href="{{ $item['url'] }}"
        >
            {{ $item['title'] }}
        </a>
    @endforeach

    @if (auth()->guest())
        <div class="flex my-4 sm:ml-2 lg:mb-0 lg:mt-0 lg:block">
            <a class="inline-block px-8 py-2 mt-4 border rounded border-indigo hover:text-indigo-500 md:ml-2 lg:ml-4 lg:block lg:ml-2 lg:mt-0 lg:px-4" href="#" v-on:click="slotProps.toggleSignInDropdown">
                Sign in
            </a>
            <div class="absolute z-50 flex flex-col py-1 mt-0 ml-32 mr-4 bg-white border rounded lg:mx-0 lg:mt-2 border-indigo xl:right-0" :class="slotProps.showSignInDropdown ? 'block' : 'hidden'">
                <a class="px-4 py-1 hover:bg-indigo-100" href="{{ route('login') }}">Sign in with email</a>
                <a class="px-4 py-1 hover:bg-indigo-100" href="{{ url('login/github') }}">Sign in with GitHub</a>
            </div>
        </div>
    @else
        <div class="mt-4 lg:mt-0">
            <a class="flex items-center mt-2 mr-4 lg:mx-2 md:mx-4 lg:mt-0 lg:flex-row-reverse" href="#" v-on:click="slotProps.toggleAccountDropdown">
                <img
                    src="{{ auth()->user()->profile_picture_thumb }}"
                    class="hidden inline w-12 ml-2 rounded-full lg:block"
                >
                <div class="flex items-center text-indigo-800 hover:text-indigo-500 lg:flex-row-reverse">
                    <span class="mr-2 uppercase lg:mr-0 lg:ml-2">Me</span>
                    <span class="caret"></span>
                </div>
            </a>
            <div class="absolute z-50 flex flex-col py-1 mt-2 mr-4 bg-white border rounded lg:mx-2 md:mx-4 border-indigo lg:right-0" :class="slotProps.showAccountDropdown ? 'block' : 'hidden'">
                <a class="px-4 py-1 hover:bg-indigo-100 hover:text-indigo-500" href="{{ route('account.show') }}">Account</a>
                @if (auth()->user()->enable_profile)
                    <a
                        class="px-4 py-1 whitespace-no-wrap hover:bg-indigo-100 hover:text-indigo-500"
                        href="{{ route('speakers-public.show', auth()->user()->profile_slug) }}"
                    >
                        Public Speaker Profile
                    </a>
                @endif
                <a class="px-4 py-1 hover:bg-indigo-100 hover:text-indigo-500" href="{{ route('log-out') }}">Log out</a>
            </div>
        </div>
    @endif
    {{-- Disable email registration --}}
    {{-- <a href="{{ route('register') }}">Sign up</a> --}}
</nav>

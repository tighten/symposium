<nav :class="slotProps.showNav ? 'block' : 'hidden'" class="absolute left-0 items-center block w-full p-4 font-sans font-semibold text-indigo-800 bg-white shadow-sm text-md lg:w-auto lg:relative lg:shadow-none lg:flex">
    @if (auth()->check())
        @php
            $menuItems = [
                [
                    'title' => 'Dashboard',
                    'url' => route('dashboard'),
                    'classes' => 'font-medium ml-0 lg:mr-2 sm:mx-2 md:mx-4',
                ],
                [
                    'title' => 'Bios',
                    'url' => route('bios.index'),
                    'classes' => 'font-medium lg:mr-2 sm:mx-2 md:mx-4 mt-2 lg:mt-0',
                ],
                [
                    'title' => 'Conferences',
                    'url' => route('conferences.index'),
                    'classes' => 'font-medium lg:mr-2 sm:mx-2 md:mx-4 mt-2 lg:mt-0',
                ],
                [
                    'title' => 'Calendar',
                    'url' => route('calendar.index'),
                    'classes' => 'font-medium lg:mr-2 sm:mx-2 md:mx-4 mt-2 lg:mt-0',
                ],
                [
                    'title' => 'Talks',
                    'url' => route('talks.index'),
                    'classes' => 'font-medium lg:mr-2 sm:ml-2 md:ml-4 mt-2 lg:mt-0',
                ],

            ];
        @endphp
    @else
        @php
            $menuItems = [
                [
                    'title' => 'How it Works',
                    'url' => url('what-is-this'),
                    'classes' => 'font-medium ml-0 lg:mr-2 sm:mx-2 md:mx-4',
                ],
                [
                    'title' => 'Our speakers',
                    'url' => url('speakers'),
                    'classes' => 'font-medium lg:mr-2 sm:mx-2 md:mx-4 mt-2 lg:mt-0',
                ],
                [
                    'title' => 'Conferences',
                    'url' => route('conferences.index'),
                    'classes' => 'font-medium lg:mr-2 sm:mx-2 md:mx-4 sm:mr-0 mt-2 lg:mt-0',
                ],
            ];
        @endphp
    @endif

    @foreach ($menuItems as $item)
        <a class="block border-b border-indigo hover:text-indigo-500 hover:underline border-solid py-5 lg:border-none uppercase {{ $item['classes'] }}"
           href="{{ $item['url'] }}"
        >
            {{ $item['title'] }}
        </a>
    @endforeach

    @if (auth()->guest())
        <div class="flex my-4 sm:ml-2 lg:mb-0 lg:mt-0 lg:block">
            <a class="inline-block px-8 py-2 mt-4 text-indigo-800 transition duration-150 ease-in-out border rounded border-indigo hover:text-white hover:bg-indigo-800 md:ml-2 lg:ml-4 lg:block lg:ml-2 lg:mt-0 lg:px-4" href="#" v-on:click="slotProps.toggleSignInDropdown">
                Sign in
            </a>
            <div class="absolute z-50 flex flex-col py-1 mt-0 ml-32 bg-white border rounded lg:mr-4 lg:w-1/3 lg:right-0 lg:mx-0 lg:mt-2 border-indigo xl:right-0" :class="slotProps.showSignInDropdown ? 'block' : 'hidden'">
                <a class="px-4 py-1 hover:bg-indigo-100" href="{{ route('login') }}">Sign in with email</a>
                <a class="px-4 py-1 hover:bg-indigo-100" href="{{ url('login/github') }}">Sign in with GitHub</a>
            </div>
        </div>
    @else
        <div class="mt-4 lg:mt-0">
            <a class="flex items-center mt-2 lg:mr-4 lg:mx-2 md:mx-4 lg:mt-0 lg:flex-row-reverse" href="#" v-on:click="slotProps.toggleAccountDropdown">
                <img
                    src="{{ auth()->user()->profile_picture_thumb }}"
                    class="hidden inline w-12 ml-2 rounded-full lg:block"
                >
                <div class="flex items-center text-indigo-800 hover:text-indigo-500 lg:flex-row-reverse">
                    <span class="ml-2 mr-2 uppercase lg:mr-0">Me</span>
                    <span class="caret"></span>
                </div>
            </a>
            <div class="absolute z-50 flex flex-col py-1 mt-2 bg-white border rounded lg:mr-4 lg:mx-2 md:mx-4 border-indigo lg:right-0" :class="slotProps.showAccountDropdown ? 'block' : 'hidden'">
                <a class="px-4 py-1 hover:bg-indigo-100 hover:text-indigo-500" href="{{ route('account.show') }}">Account</a>
                @if (auth()->user()->enable_profile)
                    <a
                        class="px-4 py-1 whitespace-nowrap hover:bg-indigo-100 hover:text-indigo-500"
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

@include('partials.flash-messages')
<div class="bg-indigo-600">
    <main-header class="max-w-xl h-16 px-4 mx-auto sm:max-w-6xl flex items-center justify-between">
        <template slot-scope="slotProps">
            <div class="sm:px-4 flex items-center justify-between">
                <a href="{{ auth()->check() ? route('dashboard') : url('/') }}">
                    @svg('logo')
                </a>
                @include('partials.nav')
                <div class="lg:hidden">
                    <button v-on:click="slotProps.toggleNav" type="button" class="mobileMenuBtn focus:outline-none transform-gpu">
                        <div :class="slotProps.showNav ? 'invisible h-0 bg-opacity-0' : 'visible w-6 h-0.5 bg-indigo-800 bg-opacity-100'"></div>
                    </button>
                </div>
            </div>
            @if (auth()->guest())
                <div class="flex my-4 sm:ml-2 lg:mb-0 lg:mt-0 lg:block">
                    <a class="inline-block px-8 py-2 mt-4 text-indigo-800 transition duration-150 ease-in-out border rounded border-indigo hover:text-white hover:bg-indigo-800 md:ml-2 lg:ml-4 lg:block lg:mt-0 lg:px-4" href="#" v-on:click="slotProps.toggleSignInDropdown">
                        Sign in
                    </a>
                    <div class="absolute z-50 flex flex-col py-1 mt-0 ml-32 bg-white border rounded lg:mr-4 lg:w-1/3 lg:right-0 lg:mx-0 lg:mt-2 border-indigo xl:right-0" :class="slotProps.showSignInDropdown ? 'block' : 'hidden'">
                        <a class="px-4 py-1 hover:bg-indigo-100" href="{{ route('login') }}">Sign in with email</a>
                        <a class="px-4 py-1 hover:bg-indigo-100" href="{{ url('login/github') }}">Sign in with GitHub</a>
                    </div>
                </div>
            @else
                <div class="lg:mt-0">
                    <a class="items-center lg:mt-0" href="#" v-on:click="slotProps.toggleAccountDropdown">
                        <img
                            src="{{ auth()->user()->profile_picture_thumb }}"
                            class="hidden inline w-12 rounded-full lg:block"
                        >
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
        </template>
    </main-header>
</div>




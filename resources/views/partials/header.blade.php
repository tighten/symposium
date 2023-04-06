@include('partials.flash-messages')
<div class="bg-indigo-600">
    <main-header class="max-w-xl h-16 px-2 sm:px-0 mx-auto sm:max-w-7xl flex items-center justify-between">
        <template slot-scope="slotProps">
            @include('partials.nav')
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
                    <x-slot name="trigger">
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
            <div
                class="lg:hidden"
                :class="slotProps.showNav ? 'mr-3' : ''"
            >
                <button
                    v-on:click="slotProps.toggleNav"
                    class="mobileMenuBtn focus:outline-none transform-gpu"
                >
                    <div :class="slotProps.showNav ? 'invisible h-0 bg-opacity-0' : 'visible w-6 h-0.5 bg-white bg-opacity-100'"></div>
                </button>
            </div>
        </template>
    </main-header>
</div>

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




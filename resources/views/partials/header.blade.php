@include('partials.flash-messages')
<div class="bg-white">
    <main-header class="max-w-xl px-4 py-6 mx-auto lg:pt-3 sm:max-w-6xl">
        <template slot-scope="slotProps">
            <div class="lg:flex lg:justify-between lg:items-center">
                <div class="py-3 sm:px-4">
                    <div class="flex items-center justify-between">
                        <a href="{{ auth()->check() ? route('dashboard') : url('/') }}">
                            <img class="h-10 sm:h-8 md:h-10" src="/img/symposium-logo.svg" alt="Symposium">
                        </a>
                        <div class="lg:hidden">
                            <button v-on:click="slotProps.toggleNav" type="button" class="mobileMenuBtn focus:outline-none transform-gpu">
                                <div :class="slotProps.showNav ? 'invisible h-0 bg-opacity-0' : 'visible w-6 h-0.5 bg-indigo-800 bg-opacity-100'"></div>
                            </button>
                        </div>
                    </div>
                </div>
                @include('partials.nav')
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
        </template>
    </main-header>
</div>




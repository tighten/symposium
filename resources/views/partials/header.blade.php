@include('partials.flash-messages')
<div class="bg-white">
    <main-header class="pt-12 sm:pt-3 pb-3 px-4 max-w-md mx-auto sm:max-w-6xl">
        <template slot-scope="slotProps">
            <div class="sm:flex sm:justify-between sm:items-center">
                <div class="px-4 py-3 sm:p-0">
                    <div class="flex items-center justify-between">
                        <img class="h-10 sm:h-8 md:h-10" src="/img/symposium-logo.svg" alt="Symposium">
                        <div class="sm:hidden">
                            <button v-on:click="slotProps.toggleNav" type="button" class="block text-indigo hover:text-black focus:outline-none">
                                <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
                                    <path v-if="slotProps.showNav" fill-rule="evenodd" d="M18.278 16.864a1 1 0 0 1-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 0 1-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 0 1 1.414-1.414l4.829 4.828 4.828-4.828a1 1 0 1 1 1.414 1.414l-4.828 4.829 4.828 4.828z"/>
                                    <path v-else fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                @include('partials.nav')
            </div>
            @if ($title)
                <div class="max-w-md mx-auto sm:max-w-6xl border-t border-gray-300 mt-3">
                    <h2 class="mt-3 text-black font-sans text-2xl" style="margin-left:2.35rem">{{ $title }}</h2>
                </div>
            @endif
        </template>
    </main-header>
</div>

{{-- @include('partials.nav') --}}
{{-- <div class="primary-header" role="navigation">
    <div class="container">
        <div class="primary-header__title">
            <button type="button" class="primary-header__toggle" data-toggle="collapse"
                    data-target=".primary-header__collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="{{ Auth::check() ? route('dashboard') : url('/') }}" class="logo">
                <img src="{{ url('/img/symposium-logo.png') }}" alt="Symposium">
            </a>
        </div>
        <div class="primary-header__collapse">
            @include('partials.nav')
        </div>
    </div>
</div> --}}

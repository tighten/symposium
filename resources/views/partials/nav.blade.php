<nav
    class="bg-indigo-600 block gap-4 text-sm text-white lg:flex lg:items-center"
    :class="slotProps.showNav ? 'absolute w-full top-4' : ''"
>
    @if (auth()->check())
        @php
            $menuItems = [
                ['route' => 'dashboard', 'title' => 'Dashboard'],
                ['route' => 'bios.index', 'title' => 'Bios'],
                ['route' => 'conferences.index', 'title' => 'Conferences'],
                ['route' => 'calendar.index', 'title' => 'Calendar'],
                ['route' => 'talks.index', 'title' => 'Talks'],

            ];
        @endphp
    @else
        @php
            $menuItems = [
                ['route' => 'what-is-this', 'title' => 'How it Works'],
                ['route' => 'speakers-public.index', 'title' => 'Our speakers'],
                ['route' => 'conferences.index', 'title' => 'Conferences'],
            ];
        @endphp
    @endif

    <a
        href="{{ auth()->check() ? route('dashboard') : url('/') }}"
        class="block px-4"
        :class="slotProps.showNav ? 'pb-4' : ''"
    >
        @svg('logo')
    </a>

    @foreach ($menuItems as $item)
        <a
            href="{{ route($item['route']) }}"
            :class="slotProps.showNav ? 'block py-4' : 'hidden lg:block py-2'"
            class="px-3 rounded hover:underline
            @if (request()->isContainedBy($item['route'])) bg-indigo-700 @endif"
        >
            {{ $item['title'] }}
        </a>
    @endforeach
</nav>

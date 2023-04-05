<nav :class="slotProps.showNav ? 'block' : 'hidden'" class="absolute left-0 items-center block w-full font-sans font-semibold text-white shadow-sm text-sm leading-5 font-medium lg:w-auto lg:relative lg:shadow-none lg:flex">
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
        <a class="block border-b border-indigo hover:text-indigo-500 hover:underline border-solid lg:border-none uppercase {{ $item['classes'] }}"
           href="{{ $item['url'] }}"
        >
            {{ $item['title'] }}
        </a>
    @endforeach
</nav>

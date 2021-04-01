@php
    $styles = $is_home ? 'bg-black text-gray-500' : 'text-gray-600 bg-white border-t border-gray-300';
@endphp

<div class="{{ $styles }} py-4 w-full">
    <div class="max-w-md mx-auto font-sans text-lg sm:max-w-6xl">
        <footer>
            <div class="flex flex-col justify-between px-8 text-center lg:flex-row xl:px-0 lg:text-left">
                <div class="hover:underline">
                    <a href="http://tighten.co/" target="_blank">&copy; Tighten Co. {{ date('Y') }}</a>
                </div>
                <div class="invisible lg:visible">|</div>
                <div class="hover:underline">
                    <a href="https://github.com/tightenco/symposium" target="_blank">Source &amp; roadmap on GitHub</a>
                </div>
                <div class="invisible lg:visible">|</div>
                <div class="hover:underline">
                    <a href="http://rdohms.github.io/pronto/" target="_blank">Submit your talks easily with  Pronto!</a>
                </div>
            </div>
        </footer>
    </div>
</div>


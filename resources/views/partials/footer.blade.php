@php
    $styles = $is_home ? 'bg-black' : 'bg-white border-t border-gray-300';
@endphp

<div class="{{ $styles }} py-4 w-full">
    <div class="font-sans text-lg text-gray-500 max-w-md mx-auto sm:max-w-6xl">
        <footer>
            <div class="flex flex-col lg:flex-row justify-between px-8 xl:px-0 text-center lg:text-left">
                <div>
                    <a href="http://tighten.co/">&copy; Tighten Co. {{ date('Y') }}</a>
                </div>
                <div class="invisible lg:visible">|</div>
                <div>
                    <a href="https://github.com/tightenco/symposium">Source &amp; roadmap on GitHub</a>
                </div>
                <div class="invisible lg:visible">|</div>
                <div>
                    <a href="http://rdohms.github.io/pronto/">Submit your talks easily with  Pronto!</a>
                </div>
            </div>
        </footer>
    </div>
</div>


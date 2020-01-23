@php
    $bg_color = $is_home ? 'bg-black' : 'bg-indigo-100';
@endphp

<div class="{{ $bg_color }} pb-12 pt-4 bottom-0 absolute w-full">
    <div class="font-sans text-lg text-gray-500 max-w-md mx-auto sm:max-w-6xl">
        <footer>
            <div class="flex flex-col lg:flex-row justify-between px-8 xl:px-0 text-center lg:text-left">
                <div>&copy; <a href="http://tighten.co/">Tighten Co.</a> {{ date('Y') }}</div>
                <div class="invisible lg:visible">|</div>
                <div>Source &amp; roadmap on <a href="https://github.com/tightenco/symposium">GitHub</a></div>
                <div class="invisible lg:visible">|</div>
                <div>Submit your talks easily with <a href="http://rdohms.github.io/pronto/">Pronto!</a></div>
            </div>
        </footer>
    </div>
</div>


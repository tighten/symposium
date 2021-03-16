@php
    $styles = $is_home ? 'bg-black' : 'bg-white border-t border-gray-300';
@endphp

<<<<<<< HEAD
    <footer>
        <p>&copy; <a href="http://tighten.co/">Tighten Co.</a> {{ date('Y') }}
            | Source &amp; roadmap on <a href="https://github.com/tighten/symposium">GitHub</a>
            | Submit your talks easily with <a href="http://rdohms.github.io/pronto/">Pronto!</a>
        </p>
    </footer>
=======
<div class="{{ $styles }} py-4 w-full">
    <div class="font-sans text-lg text-gray-500 max-w-md mx-auto sm:max-w-6xl">
        <footer>
            <div class="flex flex-col lg:flex-row justify-between px-8 xl:px-0 text-center lg:text-left">
                <div>
                    <a href="http://tighten.co/" target="_blank">&copy; Tighten Co. {{ date('Y') }}</a>
                </div>
                <div class="invisible lg:visible">|</div>
                <div>
                    <a href="https://github.com/tightenco/symposium" target="_blank">Source &amp; roadmap on GitHub</a>
                </div>
                <div class="invisible lg:visible">|</div>
                <div>
                    <a href="http://rdohms.github.io/pronto/" target="_blank">Submit your talks easily with  Pronto!</a>
                </div>
            </div>
        </footer>
    </div>
>>>>>>> develop
</div>


<div
    class="absolute right-0 lg:hidden"
    :class="{'mr-3': show}"
>
    <button
        v-on:click="toggle"
        :class="{'isActive': show}"
        class="mobileMenuBtn focus:outline-none transform-gpu"
    >
        <div :class="{
           'invisible h-0 bg-opacity-0': show,
            'visible w-6 h-0.5 bg-white bg-opacity-100': !show,
        }"></div>
    </button>
</div>

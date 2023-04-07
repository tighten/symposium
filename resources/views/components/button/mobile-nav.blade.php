<div
    class="absolute right-0 lg:hidden"
    :class="slotProps.show ? 'mr-3' : ''"
>
    <button
        v-on:click="slotProps.toggle"
        :class="slotProps.show ? 'isActive' : ''"
        class="mobileMenuBtn focus:outline-none transform-gpu"
    >
        <div :class="slotProps.show ? 'invisible h-0 bg-opacity-0' : 'visible w-6 h-0.5 bg-white bg-opacity-100'"></div>
    </button>
</div>

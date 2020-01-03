<template>
    <header>
        <slot :show-nav="showNav" :toggleNav="toggleNav"></slot>
    </header>
</template>

<script>
    export default {
        name: 'MainHeader',
        data() {
            return {
                showNav: false,
            };
        },
        methods: {
            toggleNav() {
                this.showNav = !this.showNav;
            },
        },
    }
</script>

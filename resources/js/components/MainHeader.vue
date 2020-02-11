<template>
    <header>
        <slot
            :show-nav="showNav"
            :toggleNav="toggleNav"
            :show-account-dropdown="showAccountDropdown"
            :toggle-account-dropdown="toggleAccountDropdown"
        ></slot>
    </header>
</template>

<script>
    export default {
        name: 'MainHeader',
        data() {
            return {
                showNav: false,
                showAccountDropdown: false,
            };
        },
        methods: {
            toggleNav() {
                this.showNav = !this.showNav;
            },
            toggleAccountDropdown() {
                console.log('test');
                this.showAccountDropdown = !this.showAccountDropdown;
            },
        },
    }
</script>

<template>
    <header>
        <slot
            :show-nav="showNav"
            :toggleNav="toggleNav"
            :show-account-dropdown="showAccountDropdown"
            :toggle-account-dropdown="toggleAccountDropdown"
            :show-sign-in-dropdown="showSignInDropdown"
            :toggle-sign-in-dropdown="toggleSignInDropdown"
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
                showSignInDropdown: false,
            };
        },
        methods: {
            toggleNav() {
                this.showNav = !this.showNav;
            },
            toggleAccountDropdown() {
                this.showAccountDropdown = !this.showAccountDropdown;
            },
            toggleSignInDropdown() {
                this.showSignInDropdown = !this.showSignInDropdown;
            },
        },
    }
</script>

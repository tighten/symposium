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
        mounted() {
            const listener = e => {
                if (e.target === this.$el || this.$el.contains(e.target)) {
                    return
                }
                this.showSignInDropdown = false;
                this.showAccountDropdown = false;
            }
            document.addEventListener('click', listener);
            this.$once('hook:beforeDestroy', () => {
                document.removeEventListener('click', listener)
            });
        },
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

                const menuBtn = document.querySelector('.mobileMenuBtn');
                
                if (this.showNav) {                  
                    menuBtn.classList.add('isActive');
                } else {
                    menuBtn.classList.remove('isActive');
                }
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

<template>
    <header>
        <slot
            :show-nav="showNav"
            :toggleNav="toggleNav"
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
            }
            document.addEventListener('click', listener);
            this.$once('hook:beforeDestroy', () => {
                document.removeEventListener('click', listener)
            });
        },
        data() {
            return {
                showNav: false,
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
        },
    }
</script>

<script>
    export default {
        name: 'MenuToggle',
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
                show: false,
            };
        },
        methods: {
            toggle() {
                this.show = !this.show;
            },
        },
        render() {
            return this.$scopedSlots.default({
                show: this.show,
                toggle: this.toggle,
            });
        },
    }
</script>

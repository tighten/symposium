<script>
    export default {
        name: 'updateQueryString',

        data() {
            return {
                url: new URL(window.location.href),
                queryValue: '',
            };
        },

        render() {
            return this.$scopedSlots.default({
                queryValue: this.queryValue,
                updateQueryString: this.updateQueryString,
            });
        },

        methods: {
            updateQueryString(name, value) {
                this.url.searchParams.set(name, value);
                window.location.href = this.url.toString();
            },
        },
    }
</script>

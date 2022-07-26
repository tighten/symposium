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
                clearQueryString: this.clearQueryString,
            });
        },

        methods: {
            updateQueryString(name, value) {
                this.url.searchParams.set(name, value);
                this.updateUrl();
            },
            clearQueryString(name) {
                this.url.searchParams.delete(name);
                this.updateUrl();
            },
            updateUrl() {
                window.location.href = this.url.toString();
            },
        },
    }
</script>

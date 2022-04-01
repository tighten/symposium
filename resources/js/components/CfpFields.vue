<script>
export default {
    name: 'CfpFields',
    props: {
        data: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            form: this.data,
        };
    },
    watch: {
        'form.hasCfp'(newValue) {
            if (! newValue) {
                this.form.cfpUrl = null;
                this.form.cfpStartsAt = null;
                this.form.cfpEndsAt = null;
            }
        },
    },
    render() {
        return this.$scopedSlots.default({
            form: this.form,
        });
    },
};
</script>

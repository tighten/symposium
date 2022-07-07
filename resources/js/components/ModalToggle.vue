<script>
export default {
    name: 'ModalToggle',
    data() {
        return {
            isVisible: false,
        };
    },
    methods: {
        toggleModal() {
            this.isVisible = ! this.isVisible;
        },
    },
    render() {
        return this.$scopedSlots.default({
            isVisible: this.isVisible,
            toggleModal: this.toggleModal,
        });
    },
}
</script>

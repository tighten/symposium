<script>
export default {
    name: 'CurrencySelection',
    props: {
        currencies: Object,
        initialCurrency: String,
    },
    data() {
        return {
            form: {
                selectedCurrency: this.initialCurrency,
            },
        };
    },
    computed: {
        selectedCurrencySymbol() {
            return Object.values(this.currencies).find(({code}) => code == this.form.selectedCurrency).symbol;
        },
    },
    render() {
        return this.$scopedSlots.default({
            form: this.form,
            symbol: this.selectedCurrencySymbol,
        });
    },
}
</script>

<template>
<div name="speaker_package">
    <div class="mt-8">
        <label
            for="currency"
            class="font-extrabold text-indigo-900"
        >
            Currency
        </label>

        <select
            name="speaker_package[currency]"
            id="currency"
            :value="selectedCurrency"
            @change="(e) => updateSelectedCurrency(e.target.value)"
        >
            <option v-for="currency in currencies" :value="currency.code" :key="currency.code">
                {{ currency.code }}
            </option>
        </select>
    </div>

    <div class="flex mt-2">
        <span class="p-2 bg-indigo-300 rounded-l-md">{{ selectedCurrencySymbol }}</span>
        <input name="speaker_package[travel]" :value="speakerPackage && speakerPackage.travel" class="bg-white border-form-200 form-input placeholder-form-400 rounded-r-md">
    </div>
    
    <div class="flex mt-2">
        <span class="p-2 bg-indigo-300 rounded-l-md">{{ selectedCurrencySymbol }}</span>
        <input name="speaker_package[hotel]" :value="speakerPackage && speakerPackage.hotel" class="bg-white border-form-200 form-input placeholder-form-400 rounded-r-md">
    </div>
    
    <div class="flex mt-2">
        <span class="p-2 bg-indigo-300 rounded-l-md">{{ selectedCurrencySymbol }}</span>
        <input name="speaker_package[food]" :value="speakerPackage && speakerPackage.food" class="bg-white border-form-200 form-input placeholder-form-400 rounded-r-md">
    </div>
</div>
</template>


<script>
export default {
    name: 'SpeakerPackage',
    props: {
        currencies: Object,
        initialCurrency: String,
        speakerPackage: Object,
    },
    data() {
        return {
            selectedCurrency: this.initialCurrency,
            selectedCurrencySymbol: this.initialCurrency,
        };
    },
    mounted() {
        this.selectedCurrencySymbol = Object.values(this.currencies).find(({code}) => code == this.initialCurrency).symbol
    },
    methods: {
        updateSelectedCurrency(e) {
            this.selectedCurrency = e;
            this.selectedCurrencySymbol = Object.values(this.currencies).find(({code}) => code == e).symbol;
        }
    },
}
</script>

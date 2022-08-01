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
                @change="(e) => selectedCurrency = e.target.value"
            >
                <option v-for="currency in currencies" :value="currency.code" :key="currency.code">
                    {{ currency.symbol || currency.code }}
                </option>
            </select>
    </div>

    <div class="flex mt-2">
        <span class="p-2 bg-indigo-300 rounded-l-md">{{ selectedCurrency }}</span>
        <input name="speaker_package[travel]" type="number" class="bg-white border-form-200 form-input placeholder-form-400 rounded-r-md">
    </div>
    
    <div class="flex mt-2">
        <span class="p-2 bg-indigo-300 rounded-l-md">{{ selectedCurrency }}</span>
        <input name="speaker_package[hotel]" type="number" class="bg-white border-form-200 form-input placeholder-form-400 rounded-r-md">
    </div>
    
    <div class="flex mt-2">
        <span class="p-2 bg-indigo-300 rounded-l-md">{{ selectedCurrency }}</span>
        <input name="speaker_package[food]" type="number" class="bg-white border-form-200 form-input placeholder-form-400 rounded-r-md">
    </div>
</div>
</template>


<script>
export default {
    name: 'SpeakerPackage',
    props: {
        currencies: Array,
    },
    data() {
        return {
            selectedCurrency: 'USD',
        };
    },
}
</script>

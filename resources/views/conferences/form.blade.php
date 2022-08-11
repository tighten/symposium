<x-panel>
    <x-input.text
        name="title"
        label="*Title"
        :value="$conference->title"
    ></x-input.text>

    <location-lookup class="mt-8">
        <template slot-scope="location">
            <x-input.text
                name="location"
                label="Location"
                :value="$conference->location"
                @input="location.lookup"
                @keydown.enter.prevent="true"
            ></x-input.text>
        </template>
    </location-lookup>

    <x-input.textarea
        name="description"
        label="*Description"
        class="mt-8"
        :value="$conference->description"
    ></x-input.textarea>

    <x-input.text
        name="url"
        label="*URL"
        :value="$conference->url"
        class="mt-8"
    ></x-input.text>

    <x-input.date
        name="starts_at"
        label="Conference Start Date"
        :value="$conference->startsAtSet() ? $conference->starts_at->format('Y-m-d') : ''"
        class="mt-8"
    ></x-input.date>

    <x-input.date
        name="ends_at"
        label="Conference End Date"
        :value="$conference->endsAtSet() ? $conference->ends_at->format('Y-m-d') : ''"
        class="mt-8"
    ></x-input.date>
</x-panel>

<x-panel class="mt-4">
    <cfp-fields :data="{{ json_encode([
        'hasCfp' => old('has_cfp', $conference->has_cfp),
        'cfpUrl' => old('cfp_url', $conference->cfp_url),
        'cfpStartsAt' => old('cfp_starts_at', $conference->cfp_starts_at ? $conference->cfp_starts_at->format('Y-m-d') : ''),
        'cfpEndsAt' => old('cfp_ends_at', $conference->cfp_ends_at ? $conference->cfp_ends_at->format('Y-m-d') : ''),
    ]) }}">
        <template #default="{ form }">
            <div>
                <div class="flex items-center justify-between">
                    <h2 class="text-4xl">CFP</h2>

                    <x-input.toggle
                        name="has_cfp"
                        label="Has CFP"
                        v-model="form.hasCfp"
                    ></x-input.toggle>
                </div>

                <div v-show="form.hasCfp">
                    <x-input.text
                        name="cfp_url"
                        label="URL to CFP page"
                        v-model="form.cfpUrl"
                        class="mt-8"
                    ></x-input.text>

                    <x-input.date
                        name="cfp_starts_at"
                        label="CFP Open Date"
                        v-model="form.cfpStartsAt"
                        class="mt-8"
                    ></x-input.date>

                    <x-input.date
                        name="cfp_ends_at"
                        label="CFP Close Date"
                        v-model="form.cfpEndsAt"
                        class="mt-8"
                    ></x-input.date>
                </div>
            </div>
        </template>
    </cfp-fields>
</x-panel>

<x-panel class="mt-4">
    <h2 class="text-4xl">Speaker Packages</h2>

    <currency-selection
        :currencies="{{ json_encode($currencies) }}"
        :initial-currency="{{ json_encode($conference->speaker_package['currency'] ?? 'USD') }}"
    >
        <template #default="{symbol, form}">
            <div>
                <div class="mt-8">
                    <label
                        for="currency"
                        class="font-extrabold text-indigo-900"
                    >
                        Currency
                    </label>

                    <select
                        name="speaker_package[currency]"
                        v-model="form.selectedCurrency"
                    >
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency['code'] }}">
                                {{ $currency['code'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex mt-2">
                    <span class="p-2 bg-indigo-300 rounded-l-md" v-text="symbol"></span>
                    <input name="speaker_package[travel]" value="{{ $package['travel'] ?? 0 }}" class="bg-white border-form-200 form-input placeholder-form-400 rounded-r-md">
                </div>

                <div class="flex mt-2">
                    <span class="p-2 bg-indigo-300 rounded-l-md" v-text="symbol"></span>
                    <input name="speaker_package[hotel]" value="{{ $package['hotel'] ?? 0 }}" class="bg-white border-form-200 form-input placeholder-form-400 rounded-r-md">
                </div>
                
                <div class="flex mt-2">
                    <span class="p-2 bg-indigo-300 rounded-l-md" v-text="symbol"></span>
                    <input name="speaker_package[food]" value="{{ $package['food'] ?? 0 }}" class="bg-white border-form-200 form-input placeholder-form-400 rounded-r-md">
                </div>
            </div>
        </template>
    </currency-selection>
</x-panel>

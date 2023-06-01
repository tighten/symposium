<x-panel size="xl">
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

<x-panel size="xl" class="mt-4">
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

<x-panel size="xl" class="mt-4">
    <h2 class="text-4xl">Speaker Package</h2>

    <currency-selection
        :currencies="{{ json_encode($currencies) }}"
        initial-currency="{{ $conference->speaker_package->currency ?? 'USD' }}"
    >
        <template #default="{symbol, form}">
            <div class="w-full md:w-1/3 space-y-4">
                <x-input.select
                    name="speaker_package[currency]"
                    label="Currency"
                    label-class="w-20 text-right"
                    :options="$currencies"
                    option-text="code"
                    option-value="code"
                    :inline="true"
                    class="mt-8"
                    v-model="form.selectedCurrency"
                ></x-input.select>

                @foreach (App\Casts\SpeakerPackage::CATEGORIES as $category)
                    <x-input.group
                        :name='"speaker_package[{$category}]"'
                        :label="str($category)->title()"
                        label-class="w-20 text-right"
                        v-text="symbol"
                    >
                        <x-input.text
                            :name='"speaker_package[{$category}]"'
                            :value="$conference->speaker_package->toDecimal($category)"
                            :hide-label="true"
                            rounded-class="rounded-r"
                        ></x-input.text>
                    </x-input.group>
                @endforeach
            </div>
        </template>
    </currency-selection>
</x-panel>

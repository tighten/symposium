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
    <div class="flex items-center justify-between">
        <h2 class="text-4xl">CFP</h2>

        <x-input.toggle
            name="has_cfp"
            label="Has CFP"
            :value="$conference->has_cfp"
        ></x-input.toggle>
    </div>

    <x-input.text
        name="cfp_url"
        label="URL to CFP page"
        :value="$conference->cfp_url"
        class="mt-8"
    ></x-input.text>

    <x-input.date
        name="cfp_starts_at"
        label="CFP Open Date"
        :value="$conference->cfpStartsAtSet() ? $conference->cfp_starts_at->format('Y-m-d') : ''"
        class="mt-8"
    ></x-input.date>

    <x-input.date
        name="cfp_ends_at"
        label="CFP Close Date"
        :value="$conference->cfpEndsAtSet() ? $conference->cfp_ends_at->format('Y-m-d') : ''"
        class="mt-8"
    ></x-input.date>
</x-panel>

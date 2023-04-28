<div>
    <div class="flex">
        <h2 class="text-2xl leading-8 font-semibold text-indigo-600 w-52">
            {{ $date->format('F Y') }}
        </h2>
        <x-button.secondary
            icon="chevron-left"
            aria-label="Previous"
            class="rounded-r-none ml-4"
            :href="route('conferences.index', [
                'year' => $date->subMonth()->year,
                'month' => $date->subMonth()->month,
            ])"
        />
        <x-button.secondary
            icon="chevron-right"
            aria-label="Next"
            class="rounded-l-none border-l-0"
            :href="route('conferences.index', [
                'year' => $date->addMonth()->year,
                'month' => $date->addMonth()->month,
            ])"
        />
    </div>
    <x-input.select
        name="filter"
        label="Filter by"
        option-text="label"
        option-value="value"
        :options="$this->filter_options"
        wire:model="filter"
    />
    <x-panel size="xl" :padding="false" class="mt-5">
        @each('conferences.listing', $conferences, 'conference', 'conferences.listing-empty')
    </x-panel>
</div>

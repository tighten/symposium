<div>
    <div class="flex">
        <h2 class="text-2xl leading-8 font-semibold text-indigo-600 w-52">
            {{ $date->format('F Y') }}
        </h2>
        <x-button.secondary
            icon="chevron-left"
            aria-label="Previous"
            class="rounded-r-none ml-4"
            wire:click.prevent="previous"
            :href="route('conferences.index', [
                'year' => $date->subMonth()->year,
                'month' => $date->subMonth()->month,
            ])"
        />
        <x-button.secondary
            icon="chevron-right"
            aria-label="Next"
            class="rounded-l-none border-l-0"
            wire:click.prevent="next"
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
    <x-input.select
        name="sort"
        label="Sort by"
        option-text="label"
        option-value="value"
        :options="$this->sort_options"
        wire:model="sort"
    />
    <x-panel size="xl" :padding="false" class="mt-5">
        @each('conferences.listing', $conferences, 'conference', 'conferences.listing-empty')
    </x-panel>

    @if (auth()->user())
        <div class="mt-4 text-right">
            <x-button.primary
                :href="route('conferences.create')"
                icon="plus"
            >
                Suggest a Missing Conference
            </x-button.primary>
        </div>
    @endif
</div>

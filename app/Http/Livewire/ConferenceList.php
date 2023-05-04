<?php

namespace App\Http\Livewire;

use App\Models\Conference;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ConferenceList extends Component
{
    public $date;

    public $year;

    public $month;

    public $filter;

    public $sort = 'date';

    public $search;

    protected $queryString = [
        'year',
        'month',
        'filter',
        'sort',
        'search',
    ];

    public function mount()
    {
        $this->date = CarbonImmutable::now()
            ->year($this->year ?? now()->year)
            ->month($this->month ?? now()->month);
    }

    public function render()
    {
        return view('livewire.conference-list', [
            'conferences' => $this->conferences,
        ])->extends('app');
    }

    public function getConferencesProperty()
    {
        Builder::mixin($this->queryScopes());

        return Conference::search($this->search)->query(function ($query) {
            $query->approved()
                ->applyFavoritesFilter($this->filter)
                ->applyDismissedFilter($this->filter)
                ->applyOpenCfpFilter($this->filter)
                ->applyFutureCfpFilter($this->filter)
                ->sortByTitle($this->sort)
                ->sortByDate($this->sort)
                ->sortByCfpClosing($this->sort)
                ->sortByCfpOpening($this->sort)
                ->whereEventDuring(
                    $this->date->year,
                    $this->date->month,
                );
        })->get();
    }

    public function getFilterOptionsProperty()
    {
        $filterOptions = [
            ['label' => 'All', 'value' => 'all'],
            ['label' => 'Open CFP', 'value' => 'open_cfp'],
            ['label' => 'Future CFP', 'value' => 'future_cfp'],
        ];

        if (auth()->check()) {
            $filterOptions[] = ['label' => 'Favorites', 'value' => 'favorites'];
            $filterOptions[] = ['label' => 'Dismissed', 'value' => 'dismissed'];
        }

        return $filterOptions;
    }

    public function getSortOptionsProperty()
    {
        return [
            ['label' => 'Date', 'value' => 'date'],
            ['label' => 'Title', 'value' => 'title'],
            ['label' => 'CFP Closing Next', 'value' => 'cfp_closing_next'],
            ['label' => 'CFP Opening Next', 'value' => 'cfp_opening_next'],
        ];
    }

    public function previous()
    {
        $this->date = $this->date->subMonth();
        $this->updateQueryString();
    }

    public function next()
    {
        $this->date = $this->date->addMonth();
        $this->updateQueryString();
    }

    public function toggleFavorite(Conference $conference)
    {
        if (! auth()->user() || $conference->isDismissedBy(auth()->user())) {
            return;
        }

        auth()->user()->favoritedConferences()->toggle($conference->id);
    }

    public function toggleDismissed(Conference $conference)
    {
        if (! auth()->user() || $conference->isFavoritedBy(auth()->user())) {
            return;
        }

        auth()->user()->dismissedConferences()->toggle($conference->id);
    }

    private function updateQueryString()
    {
        $this->year = $this->date->year;
        $this->month = $this->date->month;
    }

    private function queryScopes()
    {
        return new class
        {
            public function applyFavoritesFilter()
            {
                return function ($filter) {
                    return $this->when(
                        $filter === 'favorites' && auth()->user(),
                        fn ($q) => $q->whereFavoritedBy(auth()->user()),
                    );
                };
            }

            public function applyDismissedFilter()
            {
                return function ($filter) {
                    if (! auth()->user()) {
                        return $this;
                    }

                    return $this->when(
                        $filter === 'dismissed',
                        fn ($q) => $q->whereDismissedBy(auth()->user()),
                        fn ($q) => $q->whereNotDismissedBy(auth()->user()),
                    );
                };
            }

            public function applyOpenCfpFilter()
            {
                return function ($filter) {
                    return $this->when(
                        $filter === 'open_cfp',
                        fn ($q) => $q->whereCfpIsOpen(),
                    );
                };
            }

            public function applyFutureCfpFilter()
            {
                return function ($filter) {
                    return $this->when(
                        $filter === 'future_cfp',
                        fn ($q) => $q->whereCfpIsFuture(),
                    );
                };
            }

            public function sortByTitle()
            {
                return function ($sort) {
                    return $this->when(
                        $sort === 'title',
                        fn ($q) => $q->orderBy('title'),
                    );
                };
            }

            public function sortByDate()
            {
                return function ($sort) {
                    return $this->when(
                        $sort === 'date',
                        fn ($q) => $q->orderBy('starts_at'),
                    );
                };
            }

            public function sortByCfpClosing()
            {
                return function ($sort) {
                    return $this->when(
                        $sort === 'cfp_closing_next',
                        fn ($q) => $q->orderByRaw(
                            'cfp_ends_at IS NULL, cfp_ends_at ASC',
                        ),
                    );
                };
            }

            public function sortByCfpOpening()
            {
                return function ($sort) {
                    return $this->when(
                        $sort === 'cfp_opening_next',
                        fn ($query) => $query->orderByRaw(
                            'cfp_starts_at IS NULL, cfp_starts_at ASC',
                        ),
                    );
                };
            }
        };
    }
}

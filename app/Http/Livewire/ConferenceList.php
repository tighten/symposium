<?php

namespace App\Http\Livewire;

use App\Models\Conference;
use Carbon\CarbonImmutable;
use Livewire\Component;

class ConferenceList extends Component
{
    public $date;

    public $year;

    public $month;

    public $filter;

    public $sort = 'title';

    protected $queryString = [
        'year',
        'month',
        'filter',
        'sort',
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
        return Conference::query()
            ->approved()
            ->where(fn ($query) => $this->applyFavoritesFilter($query))
            ->where(fn ($query) => $this->applyDismissedFilter($query))
            ->where(fn ($query) => $this->applyOpenCfpFilter($query))
            ->where(fn ($query) => $this->applyFutureCfpFilter($query))
            ->when(fn ($query) => $this->sortByTitle($query))
            ->when(fn ($query) => $this->sortByDate($query))
            ->when(fn ($query) => $this->sortByCfpClosing($query))
            ->when(fn ($query) => $this->sortByCfpOpening($query))
            ->whereEventDuring(
                $this->date->year,
                $this->date->month,
            )
            ->get();
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
            ['label' => 'Title', 'value' => 'title'],
            ['label' => 'Date', 'value' => 'date'],
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

    private function applyFavoritesFilter($query)
    {
        $query->when(
            $this->filter === 'favorites' && auth()->user(),
            fn ($q) => $q->whereFavoritedBy(auth()->user()),
        );
    }

    private function applyDismissedFilter($query)
    {
        if (! auth()->user()) {
            return;
        }

        $query->when(
            $this->filter === 'dismissed',
            fn ($q) => $query->whereDismissedBy(auth()->user()),
            fn ($q) => $query->whereNotDismissedBy(auth()->user()),
        );
    }

    private function applyOpenCfpFilter($query)
    {
        $query->when(
            $this->filter === 'open_cfp',
            fn ($q) => $q->whereCfpIsOpen(),
        );
    }

    private function applyFutureCfpFilter($query)
    {
        $query->when(
            $this->filter === 'future_cfp',
            fn ($q) => $q->whereCfpIsFuture(),
        );
    }

    private function sortByTitle($query)
    {
        $query->when(
            $this->sort === 'title',
            fn ($query) => $query->orderBy('title'),
        );
    }

    private function sortByDate($query)
    {
        $query->when(
            $this->sort === 'date',
            fn ($query) => $query->orderBy('starts_at'),
        );
    }

    private function sortByCfpClosing($query)
    {
        $query->when(
            $this->sort === 'cfp_closing_next',
            fn ($query) => $query->orderByRaw(
                'cfp_ends_at IS NULL, cfp_ends_at ASC',
            ),
        );
    }

    private function sortByCfpOpening($query)
    {
        $query->when(
            $this->sort === 'cfp_opening_next',
            fn ($query) => $query->orderByRaw(
                'cfp_starts_at IS NULL, cfp_starts_at ASC',
            ),
        );
    }
}

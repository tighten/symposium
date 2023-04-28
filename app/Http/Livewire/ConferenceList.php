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

    protected $queryString = [
        'year',
        'month',
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
        ]);
    }

    public function getConferencesProperty()
    {
        return Conference::undismissed()
            ->future()
            ->approved()
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
            ['label' => 'CFP is Open', 'value' => 'open_cfp'],
            ['label' => 'Unclosed CFP', 'value' => 'unclosed_cfp'],
        ];

        if (auth()->check()) {
            $filterOptions[] = ['label' => 'Favorites', 'value' => 'favorites'];
            $filterOptions[] = ['label' => 'Dismissed', 'value' => 'dismissed'];
        }

        return $filterOptions;
    }

    public function updatedFilter()
    {
        //
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

    private function updateQueryString()
    {
        $this->year = $this->date->year;
        $this->month = $this->date->month;
    }
}

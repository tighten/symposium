<?php

namespace App\Http\Livewire;

use App\Models\Conference;
use Livewire\Component;

class ConferenceList extends Component
{
    public $date;

    public $year;

    public $month;

    public $filter;

    public function mount($date, $year, $month)
    {
        $this->date = $date;
        $this->year = $year;
        $this->month = $month;
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
            ->whereEventDuring($this->year, $this->month)
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
}

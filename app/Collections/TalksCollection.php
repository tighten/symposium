<?php

namespace App\Collections;

use App\Models\Talk;
use Illuminate\Database\Eloquent\Collection;

class TalksCollection extends Collection
{
    public function sortByTitle()
    {
        return $this->sortBy(function (Talk $talk) {
            return strtolower($talk->currentRevision->title);
        })->values();
    }
}

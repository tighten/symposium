<?php

namespace App\Filament\Resources\ConferenceIssueResource\Pages;

use App\Filament\Resources\ConferenceIssueResource;
use Filament\Resources\Pages\ManageRecords;

class ManageConferenceIssues extends ManageRecords
{
    protected static string $resource = ConferenceIssueResource::class;

    protected function getActions(): array
    {
        return [
            //
        ];
    }
}

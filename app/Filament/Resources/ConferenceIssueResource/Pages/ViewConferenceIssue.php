<?php

namespace App\Filament\Resources\ConferenceIssueResource\Pages;

use App\Filament\Resources\ConferenceIssueResource;
use App\Filament\Resources\ConferenceResource;
use Filament\Forms\Components\Textarea;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewConferenceIssue extends ViewRecord
{
    protected static string $resource = ConferenceIssueResource::class;

    public function close(array $data)
    {
        $this->record->close(auth()->user(), $data['notes']);

        return $this->redirect($this->getResource()::getUrl('index'));
    }

    protected function getActions(): array
    {
        return [
            Action::make('View conference')
                ->color('secondary')
                ->icon('heroicon-o-arrow-circle-right')
                ->url(ConferenceResource::getUrl('edit', [$this->record->conference])),
            Action::make('Close issue')
                ->icon('heroicon-o-adjustments')
                ->action('close')
                ->form([
                    Textarea::make('notes')->required(),
                ]),
        ];
    }
}

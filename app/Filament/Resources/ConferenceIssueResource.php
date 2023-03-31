<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConferenceIssueResource\Pages\ManageConferenceIssues;
use App\Filament\Resources\ConferenceResource;
use App\Models\ConferenceIssue;
use Awcodes\DropInAction\Forms\Components\DropInAction;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\Modal\Actions\Action as ModalAction;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class ConferenceIssueResource extends Resource
{
    protected static ?string $model = ConferenceIssue::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

    protected static ?string $navigationLabel = 'Open Issues';

    protected static ?int $navigationSort = 3;

    protected static ?string $slug = 'issues';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Conference')->columns(2)->schema([
                    Grid::make()->schema([
                        TextInput::make('name')
                            ->formatStateUsing(fn($record) => $record->conference->title),
                        TextInput::make('Event dates')
                            ->formatStateUsing(function ($record) {
                                return $record->conference->startsAtDisplay() . ' - ' . $record->conference->endsAtDisplay();
                            }),
                        Grid::make(3)->columnSpan(1)->schema([
                            TextInput::make('url')
                                ->columnSpan(2)
                                ->formatStateUsing(fn($record) => $record->conference->url),
                            DropInAction::make('Conference URL')
                                ->columnSpan(1)
                                ->disableLabel()
                                ->execute(function ($record) {
                                    return Action::make('Open')
                                        ->icon('heroicon-o-external-link')
                                        ->url($record->conference->url)
                                        ->openUrlInNewTab();
                                }),
                        ]),
                        TextInput::make('cfp_dates')
                            ->label('CFP dates')
                            ->formatStateUsing(function ($record) {
                                return $record->conference->cfpStartsAtDisplay() . ' - ' . $record->conference->cfpEndsAtDisplay();
                            }),
                    ]),
                ]),
                Section::make('Issue')->columnSpan(2)->schema([
                    Grid::make()->schema([
                        TextInput::make('reason'),
                        TextInput::make('reported by')
                            ->columnSpan(1)
                            ->formatStateUsing(fn($record) => $record->user->name),
                    ]),
                    Placeholder::make('note')
                        ->content(fn($record) => $record->note),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('conference.title'),
                TextColumn::make('reason'),
                TextColumn::make('note')->limit(50),
                TextColumn::make('user.name')->label('Reported by'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()
                    ->extraModalActions(function ($record) {
                        return [
                            ModalAction::make('View conference')
                                ->icon('heroicon-o-arrow-circle-right')
                                ->url(ConferenceResource::getUrl('edit', [$record->conference])),
                        ];
                    }),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageConferenceIssues::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with([
                'conference',
                'user',
            ]);
    }
}

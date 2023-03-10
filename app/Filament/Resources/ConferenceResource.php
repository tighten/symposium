<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConferenceResource\Pages\ListConferences;
use App\Models\Conference;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;

class ConferenceResource extends Resource
{
    protected static ?string $model = Conference::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->columnSpan(1)->schema([
                    Placeholder::make('description')
                        ->content(fn($record) => $record->description),
                ]),
                Card::make()->columnSpan(1)->schema([
                    Placeholder::make('Conference Dates')
                        ->content(function ($record) {
                            return $record->startsAtDisplay() . ' to ' . $record->endsAtDisplay();
                        }),
                    Placeholder::make('CFP Dates')
                        ->label('CFP dates')
                        ->content(function ($record) {
                            return $record->cfpStartsAtDisplay() . ' to ' . $record->cfpEndsAtDisplay();
                        }),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable(),
                TextColumn::make('starts_at')->date()->sortable(),
                TextColumn::make('ends_at')->date()->sortable(),
                TextColumn::make('cfp_starts_at')->date()->sortable(),
                TextColumn::make('cfp_ends_at')->date()->sortable(),
            ])
            ->filters([
                Filter::make('future')
                    ->query(fn ($query) => $query->Future())
                    ->default(),
            ], Layout::AboveContent)
            ->actions([
                EditAction::make()
                    ->modalHeading(fn($record) => "Edit {$record->title}"),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConferences::route('/'),
        ];
    }
}

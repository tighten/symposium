<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConferenceResource\Pages\EditConference;
use App\Filament\Resources\ConferenceResource\Pages\ListConferences;
use App\Models\Conference;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;

class ConferenceResource extends Resource
{
    protected static ?string $model = Conference::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)->schema([
                    TextInput::make('title'),
                    Grid::make()->schema([
                        DatePicker::make('starts_at'),
                        DatePicker::make('ends_at'),
                    ]),
                    Grid::make()->schema([
                        DatePicker::make('cfp_starts_at'),
                        DatePicker::make('cfp_ends_at'),
                    ]),
                    Textarea::make('description'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('starts_at')->date()->sortable(),
                TextColumn::make('ends_at')->date()->sortable(),
                TextColumn::make('cfp_starts_at')->date()->sortable(),
                TextColumn::make('cfp_ends_at')->date()->sortable(),
                ToggleColumn::make('is_featured'),
            ])
            ->filters([
                Filter::make('future')
                    ->query(fn ($query) => $query->Future())
                    ->default(),
                Filter::make('featured')
                    ->query(fn ($query) => $query->whereFeatured()),
                TernaryFilter::make('rejected_at')
                    ->label('Rejected')
                    ->nullable()
                    ->default(0),
            ])
            ->actions([
                EditAction::make(),
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
            'edit' => EditConference::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                'notRejected',
            ]);
    }
}

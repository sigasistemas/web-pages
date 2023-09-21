<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\WebPages\Filament\Resources;

use Callcocam\WebPages\Filament\Resources\PageWidgetStatResource\Pages;
use Callcocam\WebPages\Filament\Resources\PageWidgetStatResource\RelationManagers;
use App\Models\PageWidgetStat;
use Callcocam\WebPages\Traits\HasDatesFormForTableColums;
use Callcocam\WebPages\Traits\HasStatusColumn; 
use Callcocam\WebPages\Filament\Resources\PageWidgetStatResource\RelationManagers\PageWidgetStatItemsRelationManager;
use Callcocam\WebPages\Traits\HasIconsColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebPageWidgetStatResource extends Resource
{
    use HasIconsColumn, HasStatusColumn, HasDatesFormForTableColums;

    protected static ?string $model = PageWidgetStat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function getModelLabel(): string
    {
        return static::$modelLabel ?? __('web-pages::web-pages.filament.widget-stats.form.modelLabel');
    }

    public static function getPluralModelLabel(): string
    {

        return  __('web-pages::web-pages.filament.widget-stats.form.pluralLabel');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('page_widget_id')
                    ->relationship('page_widget', 'name')
                    ->required()
                    ->columnSpan([
                        'md' => 2
                    ])
                    ->label(__('web-pages::web-pages.filament.widget-stats.form.name.label')),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label(__('web-pages::web-pages.filament.widget-stats.form.name.label'))
                    ->columnSpan([
                        'md' => 3
                    ])
                    ->maxLength(255),
                static::getIconsFormSelectField()
                    ->columnSpan([
                        'md' => 3
                    ]),
                Forms\Components\Select::make('color')
                    ->label(__('web-pages::web-pages.filament.widget-stats.form.color.label'))
                    ->columnSpan([
                        'md' => 2
                    ])
                    ->options([
                        'primary' => 'primary',
                        'secondary' => 'secondary',
                        'success' => 'success',
                        'danger' => 'danger',
                        'warning' => 'warning',
                        'info' => 'info',
                        'gray' => 'gray',
                    ]),
                Forms\Components\TextInput::make('ordering')
                    ->label(__('web-pages::web-pages.filament.widget-stats.form.ordering.label'))
                    ->columnSpan([
                        'md' => 2
                    ])
                    ->required()
                    ->numeric()
                    ->default(0),
                static::getStatusFormRadioField(),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('name')
                    ->label(__('web-pages::web-pages.filament.widget-stats.form.name.label'))
                    ->searchable(),
                static::getIconsTableIconColumn(),
                Tables\Columns\TextColumn::make('color')
                    ->label(__('web-pages::web-pages.filament.widget-stats.form.color.label'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('ordering')
                    ->label(__('web-pages::web-pages.filament.widget-stats.form.ordering.label'))
                    ->numeric()
                    ->sortable(),
                 static::getStatusTableIconColumn(),
                 ...static::getFieldDatesFormForTable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PageWidgetStatItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPageWidgetStats::route('/'),
            'create' => Pages\CreatePageWidgetStat::route('/create'),
            'edit' => Pages\EditPageWidgetStat::route('/{record}/edit'),
        ];
    }



    public static function getNavigationGroup(): ?string
    {
        return __('web-pages::web-pages.filament.navigation.group');
    }
}

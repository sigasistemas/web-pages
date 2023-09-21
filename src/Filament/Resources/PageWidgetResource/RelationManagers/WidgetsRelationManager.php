<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\WebPages\Filament\Resources\PageWidgetResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WidgetsRelationManager extends RelationManager
{
    protected static string $relationship = 'widgets';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('web-pages::web-pages.filament.widgets.form.name.label'))
                    ->placeholder(__('web-pages::web-pages.filament.widgets.form.name.placeholder'))
                    ->required()
                    ->columnSpan([
                        'md' => 5
                    ])
                    ->maxLength(255),
                Forms\Components\TextInput::make('column')
                    ->label(__('web-pages::web-pages.filament.widgets.form.column.label'))
                    ->placeholder(__('web-pages::web-pages.filament.widgets.form.column.placeholder'))
                    ->required()
                    ->numeric()
                    ->columnSpan([
                        'md' => 4
                    ]),
                Forms\Components\TextInput::make('ordering')
                    ->label(__('web-pages::web-pages.filament.widgets.form.ordering.label'))
                    ->placeholder(__('web-pages::web-pages.filament.widgets.form.ordering.placeholder'))
                    ->required()
                    ->numeric()
                    ->columnSpan([
                        'md' => 3
                    ]),
                Forms\Components\DatePicker::make('published_at')
                    ->label(__('web-pages::web-pages.filament.widgets.form.published_at.label'))
                    ->placeholder(__('web-pages::web-pages.filament.widgets.form.published_at.placeholder'))
                    ->columnSpan([
                        'md' => 6
                    ]),
                Forms\Components\DatePicker::make('published_down')
                    ->label(__('web-pages::web-pages.filament.widgets.form.published_down.label'))
                    ->placeholder(__('web-pages::web-pages.filament.widgets.form.published_down.placeholder'))
                    ->columnSpan([
                        'md' => 6
                    ]),
                Forms\Components\Textarea::make('description')
                    ->label(__('web-pages::web-pages.filament.widgets.form.description.label'))
                    ->placeholder(__('web-pages::web-pages.filament.widgets.form.description.placeholder'))
                    ->columnSpanFull(),

            ])->columns(12);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

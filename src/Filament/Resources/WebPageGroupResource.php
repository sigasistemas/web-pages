<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\WebPages\Filament\Resources;

use Callcocam\WebPages\Filament\Resources\PageGroupResource\Pages;
use Callcocam\WebPages\Models\PageGroup;
use Callcocam\WebPages\Traits\HasIconsColumn;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class WebPageGroupResource extends Resource
{
    use HasIconsColumn;

    protected static ?string $model = PageGroup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make(function () {
                    return [
                        TextInput::make('singular_name')
                            ->label(__('web-pages::web-pages.filament.form.singular_name.label'))
                            ->columnSpan([
                                'md' => 2,
                            ])
                            ->lazy()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('plural_name', Str::plural($state));
                                $set('slug', Str::slug(Str::plural($state)));
                            })
                            ->placeholder(__('web-pages::web-pages.filament.form.singular_name.placeholder'))
                            ->required(),
                        TextInput::make('plural_name')
                            ->label(__('web-pages::web-pages.filament.form.plural_name.label'))
                            ->columnSpan([
                                'md' => 3,
                            ])
                            ->placeholder(__('web-pages::web-pages.filament.form.plural_name.placeholder'))
                            ->required(),
                        TextInput::make('slug')
                            ->label(__('web-pages::web-pages.filament.form.slug.label'))
                            ->placeholder(__('web-pages::web-pages.filament.form.slug.placeholder'))
                            ->columnSpan([
                                'md' => 2,
                            ])
                            ->required(),
                        static::getIconsFormSelectField()->columnSpan([
                            'md' => 3,
                        ]),
                        TextInput::make('ordering')
                            ->label(__('web-pages::web-pages.filament.form.ordering.label'))
                            ->placeholder(__('web-pages::web-pages.filament.form.ordering.placeholder'))
                            ->numeric()
                            ->columnSpan([
                                'md' => 2
                            ]),
                        Textarea::make('description')
                            ->columnSpanFull()
                            ->label(__('web-pages::web-pages.filament.form.description.label'))
                            ->placeholder(__('web-pages::web-pages.filament.form.description.placeholder')),
                    ];
                })->columns(12)->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('ordering')
            ->columns([
                TextColumn::make('singular_name')
                    ->label(__('web-pages::web-pages.filament.table.singular_name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('plural_name')
                    ->label(__('web-pages::web-pages.filament.table.plural_name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('web-pages::web-pages.filament.table.status_label'))
                    ->badge()
                    ->colors([
                        'success' => __('web-pages::web-pages.filament.table.status.published'),
                        'warning' => __('web-pages::web-pages.filament.table.status.draft'),
                    ]),
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\WebManagePageGroups::route('/'),
        ];
    }


    public static function getNavigationGroup(): ?string
    {
        return __('web-pages::web-pages.filament.navigation.group');
    }
}

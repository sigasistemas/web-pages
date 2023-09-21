<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\WebPages\Filament\Resources;
 
use Callcocam\WebPages\Filament\Resources\PageWidgetResource\Pages;
use Callcocam\WebPages\Filament\Resources\PageWidgetResource\RelationManagers;
use Callcocam\WebPages\Models\PageWidget;
use Callcocam\WebPages\Traits\HasDatesFormForTableColums;
use Callcocam\WebPages\Traits\HasIconsColumn;
use Callcocam\WebPages\Traits\HasStatusColumn;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebPageWidgetResource extends Resource
{
    use HasIconsColumn, HasStatusColumn, HasDatesFormForTableColums;

    protected static ?string $model = PageWidget::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('page_id')
                //     ->relationship('page', 'singular_name')
                //     ->required(),  
                Forms\Components\TextInput::make('name')
                    ->label(__('web-pages::web-pages.filament.widgets.form.name.label'))
                    ->placeholder(__('web-pages::web-pages.filament.widgets.form.name.placeholder'))
                    ->required()
                    ->columnSpan([
                        'md' => 4
                    ])
                    ->maxLength(255),
                Forms\Components\TextInput::make('column')
                    ->label(__('web-pages::web-pages.filament.widgets.form.column.label'))
                    ->placeholder(__('web-pages::web-pages.filament.widgets.form.column.placeholder'))
                    ->required()
                    ->numeric()
                    ->columnSpan([
                        'md' => 2
                    ]),
                Forms\Components\TextInput::make('ordering')
                    ->label(__('web-pages::web-pages.filament.widgets.form.ordering.label'))
                    ->placeholder(__('web-pages::web-pages.filament.widgets.form.ordering.placeholder'))
                    ->required()
                    ->numeric()
                    ->columnSpan([
                        'md' => 2
                    ]),
                Forms\Components\DatePicker::make('published_at')
                    ->label(__('web-pages::web-pages.filament.widgets.form.published_at.label'))
                    ->placeholder(__('web-pages::web-pages.filament.widgets.form.published_at.placeholder'))
                    ->columnSpan([
                        'md' => 2
                    ]),
                Forms\Components\DatePicker::make('published_down')
                    ->label(__('web-pages::web-pages.filament.widgets.form.published_down.label'))
                    ->placeholder(__('web-pages::web-pages.filament.widgets.form.published_down.placeholder'))
                    ->columnSpan([
                        'md' => 2
                    ]),
                Section::make(__('web-pages::web-pages.filament.widgets.form.section.pages.label'))->schema([
                    Forms\Components\CheckboxList::make('pages')
                        ->relationship('pages', 'singular_name')
                        ->bulkToggleable()
                        ->searchable()->label(__('web-pages::web-pages.filament.widgets.form.pages.label'))
                        ->helperText(__('web-pages::web-pages.filament.widgets.form.pages.helperText'))
                        ->columnSpanFull()
                ])->description(__('web-pages::web-pages.filament.widgets.form.section.pages.helperText'))
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull(),
                Repeater::make('page_widget_stats')
                    ->relationship()
                    ->schema(static::getPageWidgetStatSchema())
                    ->reorderable()
                    ->collapsed()
                    ->defaultItems(0)
                    ->columnSpanFull()
                    ->columns(12)
                    ->helperText(__('web-pages::web-pages.filament.widgets.form.repeater.stats.helperText'))
                    ->label(__('web-pages::web-pages.filament.widgets.form.repeater.stats.label')),
                Forms\Components\Textarea::make('description')
                    ->label(__('web-pages::web-pages.filament.widgets.form.description.label'))
                    ->placeholder(__('web-pages::web-pages.filament.widgets.form.description.placeholder'))
                    ->columnSpanFull(),
            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('web-pages::web-pages.filament.widgets.form.name.label'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('column')
                    ->label(__('web-pages::web-pages.filament.widgets.form.column.label'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label(__('web-pages::web-pages.filament.widgets.form.published_at.label'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_down')
                    ->label(__('web-pages::web-pages.filament.widgets.form.published_down.label'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ordering')
                    ->label(__('web-pages::web-pages.filament.widgets.form.ordering.label'))
                    ->numeric()
                    ->sortable(),
                    static::getStatusTableIconColumn(),
                    ...static::getFieldDatesFormForTable()
                
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPageWidgets::route('/'),
            'create' => Pages\CreatePageWidget::route('/create'),
            'edit' => Pages\EditPageWidget::route('/{record}/edit'),
        ];
    }


    protected static function getPageWidgetStatSchema()
    {
        return [
            Section::make()
                ->schema([
                    TextInput::make('name')
                        ->label(__('web-pages::web-pages.filament.widgets.form.repeater.stats.name.label'))
                        ->placeholder(__('web-pages::web-pages.filament.widgets.form.repeater.stats.name.placeholder'))
                        ->required()
                        ->columnSpanFull()
                        ->maxLength(255),
                    static::getIconsFormSelectField()
                        ->label(__('web-pages::web-pages.filament.widgets.form.repeater.stats.icon.label'))
                        ->placeholder(__('web-pages::web-pages.filament.widgets.form.repeater.stats.icon.placeholder'))

                        ->columnSpanFull()
                        ->maxLength(255),
                    Select::make('color')
                        ->options([
                            'primary' => 'primary',
                            'secondary' => 'secondary',
                            'success' => 'success',
                            'danger' => 'danger',
                            'warning' => 'warning',
                            'info' => 'info',
                            'gray' => 'gray',
                        ])
                        ->label(__('web-pages::web-pages.filament.widgets.form.repeater.stats.color.label'))
                        ->placeholder(__('web-pages::web-pages.filament.widgets.form.repeater.stats.color.placeholder'))

                        ->columnSpanFull(),
                    Textarea::make('description')
                        ->label(__('web-pages::web-pages.filament.widgets.form.repeater.stats.description.label'))
                        ->placeholder(__('web-pages::web-pages.filament.widgets.form.repeater.stats.description.placeholder'))

                        ->columnSpanFull()
                ])->columnSpan([
                    'md' => 4
                ]),
            Repeater::make('page_widget_stat_items')
                ->relationship()
                ->defaultItems(0)
                ->label(__('web-pages::web-pages.filament.widgets.form.repeater.stats.page_widget_stat_items.label'))
                ->schema([
                    Select::make('name')
                        ->label(__('web-pages::web-pages.filament.widgets.form.repeater.stats.page_widget_stat_items.name.label'))
                        ->placeholder(__('web-pages::web-pages.filament.widgets.form.repeater.stats.page_widget_stat_items.name.placeholder'))
                        ->required()
                        ->options([
                            'icon' => 'Icon',
                            'text' => 'Text',
                            'number' => 'Number',
                            'description' => 'Description',
                        ])
                        ->columnSpan([
                            'md' => 4
                        ]),
                    TextInput::make('description')
                        ->label(__('web-pages::web-pages.filament.widgets.form.repeater.stats.page_widget_stat_items.description.label'))
                        ->placeholder(__('web-pages::web-pages.filament.widgets.form.repeater.stats.page_widget_stat_items.description.placeholder'))
                        ->required()
                        ->columnSpan([
                            'md' => 8
                        ])
                ])->columnSpan([
                    'md' => 8
                ])
                ->columns(12)
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('web-pages::web-pages.filament.navigation.group');
    }
}

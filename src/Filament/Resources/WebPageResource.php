<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\WebPages\Filament\Resources;

use Callcocam\WebPages\Contracts\WebPageTemplate; 
use Callcocam\WebPages\Filament\Resources\PageWidgetResource\RelationManagers\WidgetsRelationManager;
use Callcocam\WebPages\Filament\Resources\WebPageResource\Pages\CreateWebPage;
use Callcocam\WebPages\Filament\Resources\WebPageResource\Pages\EditWebPage;
use Callcocam\WebPages\Filament\Resources\WebPageResource\Pages\ListWebPages;
use Callcocam\WebPages\Models\Page;
use Callcocam\WebPages\Models\PageGroup;
use Callcocam\WebPages\Traits\HasIconsColumn;
use Carbon\Carbon;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class WebPageResource extends Resource
{
    use HasIconsColumn;

    public static function getRecordRouteKeyName(): ?string
    {
        return 'id';
    }

    public static function getModel(): string
    {
        return config('web-pages.filament.model', Page::class);
    }

    public static function getRecordTitleAttribute(): ?string
    {
        return __('web-pages::web-pages.filament.recordTitleAttribute');
    }

    public static function getModelLabel(): string
    {
        return __('web-pages::web-pages.filament.modelLabel');
    }

    public static function getPluralLabel(): string
    {
        return __('web-pages::web-pages.filament.pluralLabel');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('web-pages::web-pages.filament.navigation.group');
    }

    public static function getNavigationSort(): ?int
    {
        return (int) __('web-pages::web-pages.filament.navigation.sort');
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-document';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        static::getPrimaryColumnSchema(),
                        ...static::getTemplateSchemas(),
                    ])
                    ->columnSpan(['lg' => 7]),

                static::getSecondaryColumnSchema(),

            ])
            ->columns([
                'sm' => 9,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('singular_name')
                    ->label(__('web-pages::web-pages.filament.form.singular_name.label'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label(__('web-pages::web-pages.filament.form.slug.label'))
                    ->icon('heroicon-o-globe-alt')
                    ->iconPosition('after')
                    ->getStateUsing(fn (Page $record) => url($record->slug))
                    ->searchable()
                    ->url(
                        url: fn (Page $record) => url($record->slug),
                        shouldOpenInNewTab: true
                    )
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('status')
                    ->label(__('web-pages::web-pages.filament.table.status_label'))
                    ->badge()
                    ->getStateUsing(fn (Page $record): string => $record->published_at->isPast() && ($record->published_until?->isFuture() ?? true) ? __('web-pages::web-pages.filament.table.status.published') : __('web-pages::web-pages.filament.table.status.draft'))
                    ->colors([
                        'success' => __('web-pages::web-pages.filament.table.status.published'),
                        'warning' => __('web-pages::web-pages.filament.table.status.draft'),
                    ]),

                TextColumn::make('published_at')
                    ->label(__('web-pages::web-pages.filament.form.published_at.label'))
                    ->date(__('web-pages::web-pages.filament.form.published_at.displayFormat')),
            ])
            ->filters([
                Filter::make('published_at')
                    ->form([
                        DatePicker::make('published_from')
                            ->label(__('web-pages::web-pages.filament.form.published_at.label'))
                            ->placeholder(fn ($state): string => '18. November ' . now()->subYear()->format('Y')),
                        DatePicker::make('published_until')
                            ->label(__('web-pages::web-pages.filament.form.published_until.label'))
                            ->placeholder(fn ($state): string => now()->format('d. F Y')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['published_from'] ?? null) {
                            $indicators['published_from'] = 'Published from ' . Carbon::parse($data['published_at'])->toFormattedDateString();
                        }
                        if ($data['published_until'] ?? null) {
                            $indicators['published_until'] = 'Published until ' . Carbon::parse($data['published_until'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),

                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPrimaryColumnSchema(): Component
    {
        return Section::make()
            ->columns(2)
            ->schema([
                ...static::insertBeforePrimaryColumnSchema(),
                Select::make('page_group_id')
                    ->label(__('web-pages::web-pages.filament.form.page_group_id.label'))
                    ->placeholder(__('web-pages::web-pages.filament.form.page_group_id.placeholder'))
                    ->columnSpan([
                        'md' => 3,
                    ])
                    ->createOptionForm([static::insertPageGroupForm()])
                    ->relationship('pageGroup', 'singular_name'),
                TextInput::make('singular_name')
                    ->label(__('web-pages::web-pages.filament.form.singular_name.label'))
                    ->placeholder(__('web-pages::web-pages.filament.form.singular_name.placeholder'))
                    ->columnSpan([
                        'md' => 4,
                    ])
                    ->required()
                    ->lazy()
                    ->afterStateUpdated(function (string $context, $state, callable $set) {
                        if ($context === 'create') {
                            $set('plural_name', Str::plural($state));
                            $set('slug', Str::slug(Str::plural($state)));
                        }
                    }),
                TextInput::make('plural_name')
                    ->label(__('web-pages::web-pages.filament.form.plural_name.label'))
                    ->placeholder(__('web-pages::web-pages.filament.form.plural_name.placeholder'))
                    ->columnSpan([
                        'md' => 5,
                    ])
                    ->required(),


                TextInput::make('slug')
                    ->label(__('web-pages::web-pages.filament.form.slug.label'))
                    ->placeholder(__('web-pages::web-pages.filament.form.slug.placeholder'))
                    ->columnSpan([
                        'md' => 5,
                    ])
                    ->required()
                    ->unique(Page::class, 'slug', ignoreRecord: true),
                static::getIconsFormSelectField()
                    ->columnSpan([
                        'md' => 4,
                    ]),
                Toggle::make('autheticated')
                    ->extraAttributes([
                        'class' => 'mt-4'
                    ])
                    ->label(__('web-pages::web-pages.filament.form.autheticated.label'))
                    ->columnSpan([
                        'md' => 3,
                    ]),
                Fieldset::make(__('web-pages::web-pages.filament.form.fieldset.widgets.label'))
                    ->columnSpanFull()
                    ->schema([
                        CheckboxList::make('widgets')
                            ->relationship('widgets', 'name')
                            ->bulkToggleable()
                            ->searchable()->label(__('web-pages::web-pages.filament.form.widgets.label'))
                            ->helperText(__('web-pages::web-pages.filament.form.widgets.helperText'))
                            ->columnSpanFull()
                    ]),
                Textarea::make('description')
                    ->label(__('web-pages::web-pages.filament.form.description.label'))
                    ->placeholder(__('web-pages::web-pages.filament.form.description.placeholder'))
                    ->columnSpanFull(),
                ...static::insertAfterPrimaryColumnSchema(),
            ])->columns(12);
    }

    public static function getSecondaryColumnSchema(): Component
    {
        return Section::make()
            ->schema([
                ...static::insertBeforeSecondaryColumnSchema(),
                Select::make('data.template')
                    ->reactive()
                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $set('data.templateName', Str::snake(self::getTemplateName($state))))
                    ->afterStateHydrated(fn (string $context, $state, callable $set) => $set('data.templateName', Str::snake(self::getTemplateName($state))))
                    ->options(static::getTemplates()),

                Hidden::make('data.templateName')
                    ->reactive(),

                DatePicker::make('published_at')
                    ->label(__('web-pages::web-pages.filament.form.published_at.label'))
                    ->displayFormat(__('web-pages::web-pages.filament.form.published_at.displayFormat'))
                    ->default(now()),

                DatePicker::make('published_until')
                    ->label(__('web-pages::web-pages.filament.form.published_until.label'))
                    ->displayFormat(__('web-pages::web-pages.filament.form.published_until.displayFormat')),

                TextInput::make('ordering')
                    ->label(__('web-pages::web-pages.filament.form.ordering.label'))
                    ->numeric()
                    ->default(Page::query()->max('ordering') + 1),

                Placeholder::make('created_at')
                    ->label(__('web-pages::web-pages.filament.form.created_at.label'))
                    ->hidden(fn (?Page $record) => $record === null)
                    ->content(fn (Page $record): string => $record->created_at->diffForHumans()),

                Placeholder::make('updated_at')
                    ->label(__('web-pages::web-pages.filament.form.updated_at.label'))
                    ->hidden(fn (?Page $record) => $record === null)
                    ->content(fn (Page $record): string => $record->updated_at->diffForHumans()),
                ...static::insertAfterSecondaryColumnSchema(),
            ])
            ->columnSpan(['lg' => 2]);
    }

    protected static function insertPageGroupForm()
    {

        return Group::make(function () {
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
                        'md' => 3,
                    ])
                    ->required(),
                static::getIconsFormSelectField()->columnSpan([
                    'md' => 4,
                ]),
                Textarea::make('description')
                    ->columnSpanFull()
                    ->label(__('web-pages::web-pages.filament.form.description.label'))
                    ->placeholder(__('web-pages::web-pages.filament.form.description.placeholder')),
            ];
        })->columns(12);
    }

    public static function insertBeforePrimaryColumnSchema(): array
    {
        return [];
    }

    public static function insertAfterPrimaryColumnSchema(): array
    {
        return [];
    }

    public static function insertBeforeSecondaryColumnSchema(): array
    {
        return [];
    }

    public static function insertAfterSecondaryColumnSchema(): array
    {
        return [];
    }

    /**
     * @return Collection<WebPageTemplate>
     */
    public static function getTemplateClasses(): Collection
    {
        return collect(config('web-pages.templates', []));
    }

    /**
     * @return Collection<WebPageTemplate>
     */
    public static function getTemplates(): Collection
    {
        return static::getTemplateClasses()
            ->mapWithKeys(fn ($class) => [$class => $class::title()]);
    }

    public static function getTemplateName($class): string
    {
        return Str::of($class)->afterLast('\\')->snake()->toString();
    }

    public static function getTemplateSchemas(): array
    {
        return static::getTemplateClasses()
            ->map(
                fn ($class) => Group::make($class::schema())
                    ->afterStateHydrated(fn ($component, $state) => $component->getChildComponentContainer()->fill($state))
                    ->statePath('data.content')
                    ->visible(fn ($get) => $get('data.template') === $class)
            )
            ->toArray();
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['data.content'] = $data['temp_content'][static::getTemplateName($data['template'])];
        unset($data['temp_content']);
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['data.content'] = $data['temp_content'][static::getTemplateName($data['template'])];
        unset($data['temp_content']);
        return $data;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWebPages::route('/'),
            'create' => CreateWebPage::route('/create'),
            'edit' => EditWebPage::route('/{record:id}/edit'),
        ];
    }
}

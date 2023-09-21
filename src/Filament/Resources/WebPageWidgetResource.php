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
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WebPageWidgetResource extends Resource
{
    protected static ?string $model = PageWidget::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([ 
                Forms\Components\TextInput::make('page_id')
                    ->maxLength(26),
                Forms\Components\TextInput::make('tenant_id')
                    ->maxLength(26),
                Forms\Components\TextInput::make('name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->maxLength(255),
                Forms\Components\TextInput::make('column')
                    ->maxLength(10),
                Forms\Components\DateTimePicker::make('published_at'),
                Forms\Components\DateTimePicker::make('published_down'),
                Forms\Components\TextInput::make('ordering')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('page_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tenant_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('column')
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_down')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ordering')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable(),
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

    public static function getNavigationGroup(): ?string
    {
        return __('web-pages::web-pages.filament.navigation.group');
    }
}

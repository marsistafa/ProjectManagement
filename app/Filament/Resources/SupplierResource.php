<?php

namespace App\Filament\Resources;

use App\Models\Supplier;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\BelongsToManyCheckboxList;
use Filament\Forms\Components\HasManyRepeater;
use App\Filament\Resources\SupplierResource\Pages;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?int $navigationSort = 4;

    protected static function getNavigationLabel(): string
    {
        return __('Supplier');
    }

    public static function getPluralLabel(): ?string
    {
        return static::getNavigationLabel();
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('Management');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('nipt')->required(),
                Forms\Components\TextInput::make('address')->required(),
                Forms\Components\TextInput::make('website'),
                Forms\Components\TextInput::make('email')->email()->required(),
                Forms\Components\TextInput::make('phone')->required(),

                // HasManyRepeater::make('requestForQuotations')
                //     ->relationship('requestForQuotations')
                //     ->schema([
                //         // Define the schema for RFQs
                //     ]),

                // BelongsToManyCheckboxList::make('materials')
                //     ->relationship('materials', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('nipt')->searchable(),
                TextColumn::make('address')->searchable(),
                TextColumn::make('website')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('phone')->searchable(),
             
            ])
            ->filters([
                // Filter::make('nipt')
                //     ->query(fn ($query, $value) => $query->where('nipt', 'like', "%{$value}%")),
                // Filter::make('name')
                //     ->query(fn ($query, $value) => $query->where('name', 'like', "%{$value}%")),
                // Filter::make('email')
                //     ->query(fn ($query, $value) => $query->where('email', 'like', "%{$value}%")),
                // Filter::make('phone')
                //     ->query(fn ($query, $value) => $query->where('phone', 'like', "%{$value}%")),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),
            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }    
}

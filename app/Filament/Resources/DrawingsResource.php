<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DrawingsResource\Pages;
use App\Filament\Resources\DrawingsResource\RelationManagers;
use App\Models\Drawing;
use App\Models\Project;
use App\Models\Solution;
use Filament\Facades\Filament;
use Filament\Forms;
use App\Filament\Actions\DownloadBulkAction;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DrawingsResource extends Resource
{
    protected static ?string $model = Drawing::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    protected static ?int $navigationSort = 3;

    protected static function getNavigationLabel(): string
    {
        return __('Drawings');
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
                Forms\Components\Card::make()
                    ->schema([

                        Forms\Components\Grid::make()
                            ->columns(3)
                            ->schema([
                                Forms\Components\Select::make('project_id')
                                ->label(__('Search Project'))
                                ->searchable()
                                ->disabled(fn(?Drawing $record) => $record !== null)
                                ->options(fn() => Project::all()->pluck('name', 'id')->toArray())
                                ->required(),

                                Forms\Components\TextInput::make('title')
                                    ->label(__('File name'))
                                    ->required()
                                    ->columnSpan(1)
                                    ->maxLength(255),

                                Forms\Components\Toggle::make('is_approved'),
                                Forms\Components\Hidden::make('created_by')
                                    ->default(fn() => Auth::user()->id),
                                
                            ]),
                    ])
                  
        ]);
    
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cover')
                ->label(__('Cover'))
                ->default(function($record) {
                    $newPath = str_replace('public', config('app.url') . '/storage', $record->file_path);
                    return view('livewire.small-image-viewer', ['image' => $newPath]);
                    }),
                
                Tables\Columns\TextColumn::make('name')
                ->label(__('Project'))
                ->sortable()
                ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_approved')
                ->label(__('Approval status'))
                ->boolean()
                ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable()
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project_id')
                ->label(__('Project'))
                ->options(fn() => Project::all()->pluck('name', 'id')->toArray()),
            ])
            ->actions([

                Tables\Actions\ViewAction::make()
                    ->modalWidth('full')
                    ->modalContent(function($record) {
                            $newPath = str_replace('public', config('app.url') . '/storage', $record->file_path);
                            return view('livewire.image-viewer', ['image' => $newPath]);
                    }),
                Tables\Actions\EditAction::make()
                    ->modalWidth('full')
                    ->modalContent(function($record) {
                            $newPath = str_replace('public', config('app.url') . '/storage', $record->file_path);
                            return view('livewire.image-viewer', ['image' => $newPath]);
                    }),
               
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                DownloadBulkAction::make('downloadImages'),
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
            'index' => Pages\ListDrawings::route('index'),
            'create' => Pages\CreateDrawings::route('/create'),
            'edit' => Pages\EditDrawings::route('/{record}/edit'),
        ];
    }    
}

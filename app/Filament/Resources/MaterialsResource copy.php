<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialsResource\Pages;
use App\Filament\Resources\MaterialsResource\Pages\CreateMaterials;
use App\Filament\Resources\MaterialsResource\RelationManagers;
use App\Models\Material;
use App\Models\Project;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialDocumentController;
use Illuminate\Support\Facades\Auth;

class MaterialsResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 3;

    public $temporaryUploadedFiles = [];

    protected static function getNavigationLabel(): string
    {
        return __('Materials');
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
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Name'),

                Forms\Components\Toggle::make('is_approved'),
    
                Forms\Components\TextInput::make('specification')
                    ->required()
                    ->label('Specification'),

                Forms\Components\BelongsToSelect::make('project_id')
                    ->relationship('project', 'name'), // Assuming there's a 'project' relation in Material model
    

                Forms\Components\Hidden::make('created_by')
                    ->default(fn() => Auth::user()->id),

                Forms\Components\FileUpload::make('datasheet')
                    ->multiple()
                    ->default(fn($record) => $record 
                    ? MaterialDocument::where('material_id', $record->material_id)->pluck('name') 
                    : [])
                    ->saveUploadedFileUsing(function ($file, $record, $livewire, $get, $set) {

                        $temporaryUploadedFiles['datasheet'][] = $file; 
                        //MaterialsResource::saveMaterialDocument($file, $record, $get, $livewire, 'datasheet');  
                    }),
                Forms\Components\FileUpload::make('manual')
                    ->multiple()
                    ->default(fn($record) => $record 
                    ? MaterialDocument::where('material_id', $record->material_id)->pluck('name') 
                    : [])
                    ->saveUploadedFileUsing(function ($file, $record, $livewire, $get, $set) {

                        $temporaryUploadedFiles['manual'][] = $file; 
                        //MaterialsResource::saveMaterialDocument($file, $record, $get, $livewire, 'manual');    
                    }),
                Forms\Components\FileUpload::make('DOC')
                    ->label('DOC')
                    ->multiple()
                    ->default(fn($record) => $record 
                    ? MaterialDocument::where('material_id', $record->material_id)->pluck('name') 
                    : [])
                    ->saveUploadedFileUsing(function ($file, $record, $livewire, $get, $set) {

                        $temporaryUploadedFiles['DOC'][] = $file; 
                        //MaterialsResource::saveMaterialDocument($file, $record, $get, $livewire, 'DOC');
                    }),
                Forms\Components\FileUpload::make('other_documentation')
                    ->label('Other')
                    ->multiple()
                    ->default(fn($record) => $record 
                    ? MaterialDocument::where('material_id', $record->material_id)->pluck('name') 
                    : [])
                    ->saveUploadedFileUsing(function ($file, $record, $livewire, $get, $set) {

                        $temporaryUploadedFiles['other_documentation'][] = $file; 
                        //MaterialsResource::saveMaterialDocument($file, $record, $get, $livewire, 'other_documentation');
                    }),
                ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
    
                Tables\Columns\TextColumn::make('specification')
                    ->label('Specification')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BooleanColumn::make('is_approved')
                    ->label('Status'),
    
                Tables\Columns\TextColumn::make('project_id')
                    ->label('Project')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => Project::find($state)?->name)
                    ->default(fn (string $query) => 
                        Project::where('name', 'like', "%{$query}%")
                               ->pluck('name', 'id')
                    ),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMaterials::route('index'),
            'create' => Pages\CreateMaterials::route('/create'),
            'edit' => Pages\EditMaterials::route('/{record}/edit'),
        ];
    }    
}

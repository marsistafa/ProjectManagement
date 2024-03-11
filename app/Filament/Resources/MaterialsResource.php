<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialsResource\Pages;
use App\Filament\Resources\MaterialsResource\Pages\CreateMaterials;
use App\Filament\Resources\MaterialsResource\RelationManagers;
use Filament\Resources\RelationManagers\RelationManager;
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
use Livewire\TemporaryUploadedFile; 
use Filament\Tables\Actions\Action;
use App\Models\MaterialDocument;

class MaterialsResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 6;

    public $uploadedFiles = [];

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

                Forms\Components\Select::make('project_id')
                    ->label(__('Search Project'))
                    ->searchable()
                    ->options(fn() => Project::all()->pluck('name', 'id')->toArray())
                    ->required(),

                Forms\Components\Hidden::make('created_by')
                    ->default(fn() => Auth::user()->id),

                Forms\Components\SpatieMediaLibraryFileUpload::make('datasheet')
                    ->multiple()
                    ->preserveFilenames()
                    ->reactive()
                    ->saveRelationshipsUsing(function ($livewire, $component, $record, $state) {
                         
                        $file = $livewire->data['datasheet']; 
                         
                        foreach($file as $f){

                            $originalName = $f->getClientOriginalName(); 
                
                            $materialDocumentData = [
                                'datasheet' => 'public/material_documents/datasheet/'.$originalName,
                                'project_id' => $record->project_id,
                                'material_id' => $record->id
                            ];
                
                            $record->materialDocument()->create($materialDocumentData);
                            $f->storeAs('public/material_documents/datasheet',$originalName);
                         
                        }
                    }),

                Forms\Components\SpatieMediaLibraryFileUpload::make('manual')
                    ->multiple()
                    ->preserveFilenames()
                    ->reactive()
                    ->saveRelationshipsUsing(function ($livewire, $component, $record, $state) {
                         
                        $file = $livewire->data['manual']; 
                         
                        foreach($file as $f){

                            $originalName = $f->getClientOriginalName(); 
                
                            $materialDocumentData = [
                                'manual' => 'public/material_documents/manual/'.$originalName,
                                'project_id' => $record->project_id,
                                'material_id' => $record->id
                            ];
                
                            $record->materialDocument()->create($materialDocumentData);
                            $f->storeAs('public/material_documents/manual', $originalName);
                        }
                    }),


                Forms\Components\SpatieMediaLibraryFileUpload::make('DOC')
                    ->label('DOC')
                    ->preserveFilenames()
                    ->reactive()
                    ->multiple()
                    ->saveRelationshipsUsing(function ($livewire, $component, $record, $state) {
                         
                        $file = $livewire->data['DOC']; 
                         
                        foreach($file as $f){

                            $originalName = $f->getClientOriginalName(); 
                
                            $materialDocumentData = [
                                'DOC' => 'public/material_documents/DOC/'.$originalName,
                                'project_id' => $record->project_id,
                                'material_id' => $record->id
                            ];
                
                            $record->materialDocument()->create($materialDocumentData);
                            $f->storeAs('public/material_documents/DOC', $originalName);
                        }
                    }),


                Forms\Components\SpatieMediaLibraryFileUpload::make('other_documentation')
                    ->label('Other')
                    ->multiple()
                    ->preserveFilenames()
                    ->reactive()
                    ->saveRelationshipsUsing(function ($livewire, $component, $record, $state) {
                         
                        $file = $livewire->data['other_documentation']; 
                         
                        foreach($file as $f){

                            $originalName = $f->getClientOriginalName(); 
                
                            $materialDocumentData = [
                                'other' => 'public/material_documents/other/'.$originalName,
                                'project_id' => $record->project_id,
                                'material_id' => $record->id
                            ];
                
                
                            $record->materialDocument()->create($materialDocumentData);
                            $f->storeAs('public/material_documents/other', $originalName);
                        }
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
            ->headerActions([
     
                //
            ])
            ->actions([
                Action::make('viewDocuments')
                ->label('View Documents')
                ->action(function ($record) {
                    //
                 })
                ->icon('heroicon-o-document-text')
                ->modalContent(function($record) {
                    $files = MaterialDocument::where('material_id', $record->id)->get();
                    return view('livewire.url-list', ['files' => $files]);
                }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
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

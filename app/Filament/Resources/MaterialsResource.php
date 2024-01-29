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

    protected static ?int $navigationSort = 3;

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

                Forms\Components\FileUpload::make('datasheet')
                    ->multiple()
                    ->preserveFilenames()
                    ->disk('local')
                    ->saveRelationshipsUsing(function ( $data) {
                            dd($data);
                        if ($data['datasheet']) {
                            $originalName = $data['datasheet']->getClientOriginalName();
                            $validatedData['datasheet'] = $data['datasheet']->storeAs('public/material_documents/datasheet', $originalName);
                        }
                        if ($data['manual']) {
                            $originalName = $data['manual']->getClientOriginalName();
                            $validatedData['manual'] = $data['manual']->storeAs('public/material_documents/manual', $originalName);
                        }
                        if ($data['DOC']) {
                            $originalName = $data['DOC']->getClientOriginalName();
                            $validatedData['DOC'] = $data['DOC']->storeAs('public/material_documents/DOC', $originalName);
                        }
                        if ($data['other_documentation']) {
                            $originalName = $data['other_documentation']->getClientOriginalName();
                            $validatedData['other'] = $data['other_documentation']->storeAs('public/material_documents/other', $originalName);
                        }
                        
                        $file = $data['datasheet'];
        
                        // Create or update the MaterialDocument relationship
                        $materialDocumentData = [
                            'datasheet' => $file,
                            'project_id' => $data['project_id'],
                            'material_id' => $record->id
                        ];
    
                        $record->materialDocument()->create($materialDocumentData);
                
                    }),
                    // ->saveUploadedFileUsing(function ($file,$record,$get) {
                                       
                    //     $data = [
                    //         'datasheet' => $file,
                    //         'project_id' => $get('project_id'),
                    //         'material_id' => $record->id??2
                    //     ];
                        
                    //     $request = new \Illuminate\Http\Request();
                    //     $request->replace($data);
                        
                    //     $controller = new MaterialDocumentController();
                    //     $materialDocument = $controller->store($request);       
                    // }),


                Forms\Components\FileUpload::make('manual')
                    ->multiple()
                    ->preserveFilenames()
                    ->disk('local')
                    ->saveUploadedFileUsing(function ($file, $record,$get) {
                                       
                        $data = [
                            'name' => $get('name'),
                            'specification' => $get('specification'),
                            'is_approved' => $get('is_approved'),
                            'manual' => $file,
                            'project_id' => $get('project_id')
                        ];
                        
                        $request = new \Illuminate\Http\Request();
                        $request->replace($data);
                        
                        $controller = new MaterialController();
                        $material = $controller->store($request);       
                    }),
                

                Forms\Components\FileUpload::make('DOC')
                    ->label('DOC')
                    ->multiple()
                    ->disk('local')
                    ->saveUploadedFileUsing(function ($file, $record,$get) {
                                       
                        $data = [
                            'name' => $get('name'),
                            'specification' => $get('specification'),
                            'is_approved' => $get('is_approved'),
                            'DOC' => $file,
                            'project_id' => $get('project_id')
                        ];
                        
                        $request = new \Illuminate\Http\Request();
                        $request->replace($data);
                        
                        $controller = new MaterialController();
                        $material = $controller->store($request);       
                    }),

                Forms\Components\FileUpload::make('other_documentation')
                    ->label('Other')
                    ->multiple()
                    ->saveUploadedFileUsing(function ($file, $record,$get) {
                                       
                        $data = [
                            'name' => $get('name'),
                            'specification' => $get('specification'),
                            'is_approved' => $get('is_approved'),
                            'other_documentation' => $file,
                            'project_id' => $get('project_id')
                        ];
                        
                        $request = new \Illuminate\Http\Request();
                        $request->replace($data);
                        
                        $controller = new MaterialController();
                        $material = $controller->store($request);       
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

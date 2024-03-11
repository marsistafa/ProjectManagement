<?php

namespace App\Filament\Resources\RequestForQuotationsResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\Action;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use App\Models\RequestForQuotation;
use App\Models\RFQDetail;
use App\Models\Material;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Project;
use App\Models\MaterialDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Filament\Tables\Columns\ImageColumn;
use App\Http\Livewire\ImageViewer;
use App\Http\Controllers\DrawingController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialDocumentController;
use Livewire\Component;
use App\Http\Livewire\UrlList;
use Filament\Forms\Components\View;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\RequestForQuotationsResource;

class RfqDetailsRelations extends RelationManager
{ 
    protected static string $relationship = 'rfqdetails';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $inverseRelationship = 'projectsAffected';

    public $MaterialId;

    public $createdBy;

 

    public static function form(Form $form): Form
    {
        return $form
        ->schema([

        Forms\Components\Select::make('material_id')
            ->label('Material')
            ->searchable()
            ->disabled(fn(?RFQDetail $record) => $record !== null)
            ->options(fn() => Material::all()->pluck('name', 'id')->toArray())
            ->columnSpan(2)
            ->required()
            ->reactive()
            ->afterStateUpdated(function ($state, $get, $set, $livewire) {
                $id = $get('material_id');
                $getName = Material::where('id',$id)->value('name');
                $set('description', $getName);
                $specification = Material::where('id',$id)->value('specification');
                $set('technical_details', $specification);
            })
            ->createOptionForm([
                Forms\Components\TextInput::make('name')
                ->required()
                ->label('Name'),
                

                Forms\Components\Toggle::make('is_approved'),

                Forms\Components\TextInput::make('specification')
                ->required()
                ->label('Specification')
                ->reactive()
                ->afterStateUpdated(function ($state, $get, $set, $livewire) {
                  
                    $set('technical_details', $get('specification'));
               
                }
                ),

                Forms\Components\Select::make('project_id')
                ->label(__('Search Project'))
                ->searchable()
                ->options(fn() => Project::all()->pluck('name', 'id')->toArray())
                ->required(),

            Forms\Components\Hidden::make('created_by')
                ->default(fn() => Auth::user()->id),
                ])
            ->createOptionUsing(function ($data) {
                    // Your logic to create a new Material
                    $newMaterial = new Material;
                    $newMaterial->name = $data['name'];
                    $newMaterial->is_approved = $data['is_approved'] ?? false;
                    $newMaterial->specification = $data['specification'];
                    $newMaterial->project_id = $data['project_id'];
                    $newMaterial->created_by = $data['created_by'];
                    $newMaterial->save();
            
                    return $newMaterial->id;
                }),

        Forms\Components\Hidden::make('description')
        ->reactive(),

        Forms\Components\Select::make('unit')
                ->label('Unit')
                ->required()
                ->searchable()
                ->columnSpan(1)
                ->default(fn($record) => $record 
                ? Unit::where('id', $record->unit)->pluck('unit_name') 
                : [])
                ->options(fn() => Unit::all()->pluck('unit_name','unit_name')->toArray()),

        Forms\Components\TextInput::make('quantity')
                ->numeric()
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, $get, $set, $livewire) {
                    $unitPrice = $get('unit_price_excl_tax');
                    $total = round($state * $unitPrice, 2);
                    $set('total_price_excl_tax', $total);
                  
                    $livewire->emitTo('request-for-quotations-resource', 'totalUpdated', $total);

                    
                }),
            
        Forms\Components\TextInput::make('unit_price_excl_tax')
                ->label('Unit Price')
                ->numeric()
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, $get, $set, $livewire) {
                    $quantity = $get('quantity');
                    $total = round($state * $quantity, 2);
                    $set('total_price_excl_tax', $total);

                    $livewire->emitTo('request-for-quotations-resource', 'totalUpdated', $total);


                }),
        Forms\Components\TextInput::make('total_price_excl_tax')
                ->label('Total Price')
                ->numeric()
                ->reactive()
                ->required()
                ->disabled(),
        Forms\Components\Textarea::make('technical_details')
            ->required()
            ->columnSpan(6)
            ->reactive()
            ->disabled(),

        Forms\Components\Select::make('created_by')
            ->label('User')
            ->default(fn() => Auth::user()->id)
            ->disabled()
            ->hidden(),

        Forms\Components\FileUpload::make('datasheet')
                ->multiple()
                ->default(fn($record) => $record 
                ? MaterialDocument::where('material_id', $record->material_id)->pluck('name') 
                : [])
                ->saveUploadedFileUsing(function ($file, $record, $livewire, $get, $set) {
           
                    $materialId = $get('material_id');
                  
                    $originalFileName = $file->getClientOriginalName();
                  
                    $data = [
                        'datasheet' => $file->storeAs('public/material_documents/datasheet', $originalFileName),
                        'material_id' => $materialId,
                    ];
        
                    $request = new \Illuminate\Http\Request();
                    $request->replace($data);
                    
                    $controller = new MaterialDocumentController();
                    $document = $controller->store($request);       
                }),
        Forms\Components\FileUpload::make('manual')
                ->multiple()
                ->default(fn($record) => $record 
                ? MaterialDocument::where('material_id', $record->material_id)->pluck('name') 
                : [])
                ->saveUploadedFileUsing(function ($file, $record, $livewire, $get, $set) {
           
                    $materialId = $get('material_id');
                   
                    $originalFileName = $file->getClientOriginalName();
                  
                    $data = [
                        'manual' => $file->storeAs('public/material_documents/manual', $originalFileName),
                        'material_id' => $materialId,
                    ];
                    
                    $request = new \Illuminate\Http\Request();
                    $request->replace($data);
                    
                    $controller = new MaterialDocumentController();
                    $document = $controller->store($request);      
                }),

        Forms\Components\FileUpload::make('DOC')
                ->label('DOC')
                ->multiple()
                ->default(fn($record) => $record 
                ? MaterialDocument::where('material_id', $record->material_id)->pluck('name') 
                : [])
                ->saveUploadedFileUsing(function ($file, $record, $livewire, $get, $set) {
           
                    $materialId = $get('material_id'); 
                   
                    $originalFileName = $file->getClientOriginalName();
                  
                    $data = [
                        'DOC' => $file->storeAs('public/material_documents/DOC', $originalFileName),
                        'material_id' => $materialId,
                    ];
                    
                    $request = new \Illuminate\Http\Request();
                    $request->replace($data);
                    
                    $controller = new MaterialDocumentController();
                    $document = $controller->store($request);       
                }),

        Forms\Components\FileUpload::make('other_documentation')
                ->label('Other')
                ->multiple()
                ->default(fn($record) => $record 
                ? MaterialDocument::where('material_id', $record->material_id)->pluck('name') 
                : [])
                ->saveUploadedFileUsing(function ($file, $record, $livewire, $get, $set) {
           
                    $materialId = $get('material_id');

                    $originalFileName = $file->getClientOriginalName();
                  
                    $data = [
                        'other' => $file->storeAs('public/material_documents/other', $originalFileName),
                        'material_id' => $materialId,
                    ];
                    
                    $request = new \Illuminate\Http\Request();
                    $request->replace($data);
                    
                    $controller = new MaterialDocumentController();
                    $document = $controller->store($request);       
                }),

        Forms\Components\Hidden::make('is_approved')
            ->default(1),

        Forms\Components\Hidden::make('created_by')
            ->default(fn() => Auth::user()->id),
        ])
        ->columns(6);
        

            
    }

    public function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('description')
                ->label('Material')
                ->searchable(),
            Tables\Columns\TextColumn::make('unit'),
            Tables\Columns\TextColumn::make('quantity'),
            Tables\Columns\TextColumn::make('unit_price_excl_tax'),
            Tables\Columns\TextColumn::make('total_price_excl_tax'),
            Tables\Columns\TextColumn::make('technical_details')
                ->searchable(),
        ])
            ->filters([
             
                Tables\Filters\SelectFilter::make('material_id')
                ->label(__('Material'))
                ->multiple()
                ->options(fn() => Material::all()->pluck('name', 'id')->toArray()),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                // ->visible(function () {
                   
                //     // $parentRecord = RequestForQuotation::find($record->request_for_quotation_id);
                //     return auth()->user()->id === $parentRecord->created_by;
                // })
                ->after(function (RelationManager $livewire){
                    $livewire->emit('refresh');
                }),
            ])
            ->actions([
                Action::make('viewDocuments')
                ->label('View Documents')
                ->action(function ($record) {
                    //
                 })
                ->icon('heroicon-o-document-text')
                ->modalContent(function($record) {
                    $files = MaterialDocument::where('material_id', $record->material_id)->get();
                    return view('livewire.url-list', ['files' => $files]);
                }),
            
                Tables\Actions\ViewAction::make(),

                Tables\Actions\EditAction::make()
                ->visible(fn ($record) => auth()->user()->id === $record->created_by)
                ->after(function (RelationManager $livewire){
                    $livewire->emit('refresh');
                }),
                Tables\Actions\DeleteAction::make()
                ->visible(fn ($record) => auth()->user()->id === $record->created_by)
                ->after(function (RelationManager $livewire){
                    $livewire->emit('refresh');
                }),
            ])
            
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\DetachBulkAction::make(),
           
     ]);
    }



    protected function canCreate(): bool
    {
        return true;
    }
 
    protected function canDelete(Model $record): bool
    {
        return true;
    }

    protected function canDeleteAny(): bool
    {
        return true;
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SolutionResource\Pages;
use App\Filament\Resources\SolutionResource\RelationManagers;
use App\Models\Solution;
use App\Models\Project; 
use App\Models\User;
use App\Models\Material;
use App\Models\Drawing;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\DrawingController;
use App\Http\Controllers\MaterialController;


class SolutionResource extends Resource
{
    protected static ?string $model = Solution::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    
    protected static ?int $navigationSort = 2;

    protected static function getNavigationLabel(): string
    {
        return __('Solutions');
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
                                ->disabled(fn(?Solution $record) => $record !== null)
                                ->options(fn() => Project::all()->pluck('name', 'id')->toArray())
                                ->required(),

                                Forms\Components\SpatieMediaLibraryFileUpload::make('cover')
                                    ->label(__('Main Drawing'))
                                    ->image()
                                    ->columnSpan(1),

                                Forms\Components\Toggle::make('is_approved'),
                                Forms\Components\FileUpload::make('drawings')
                                    ->label(__('Technical Drawings'))
                                    ->multiple()
                                    ->columnSpan(2)
                                    ->default(fn($record) => $record 
                                    ? Drawing::where('solution_id', $record->id)->pluck('file_path') 
                                    : [])
                                    ->saveUploadedFileUsing(function ($file, $record) {
                                       
                                        $data = [
                                            'solution_id' => $record->id,
                                            'is_approved' => 0,
                                            'file_path' => $file,
                                            'project_id' => $record->project_id,
                                            'title' => $file->getClientOriginalName(),
                                        ];
                                        
                                        $request = new \Illuminate\Http\Request();
                                        $request->replace($data);
                                        
                                        $controller = new DrawingController();
                                        $drawing = $controller->store($request);       
                                    }),

                                Forms\Components\FileUpload::make('materials')
                                    ->label(__('Materials'))
                                    ->multiple()
                                    ->columnSpan(1)
                                    ->default(fn($record) => $record 
                                        ? Material::where('solution_id', $record->id)->pluck('file_name') 
                                        : [])
                                    ->saveUploadedFileUsing(function ($file, $record) {
                                        // Create the data array with validated and required information
                                        $data = [
                                            'name' => $file->getClientOriginalName(), // Get the original name of the file
                                            'solution_id' => $record->id, // Assuming solution_id is available in $record
                                            'project_id' => $record->project_id, // Assuming project_id is available in $record
                                            'specification' => 'dcvdrsc', // Set a default value or extract from somewhere if needed
                                            'datasheet' => '', // Assuming 'datasheet' is the field you want to store the file in
                                            'manual' => '', // Add a default value or handle accordingly
                                            'DOC' => '', // Add a default value or handle accordingly
                                            'other_documentation' => $file, // Add a default value or handle accordingly
                                            'created_by' => 1, // Set to a default value or determine dynamically
                                            'is_approved' => 0, // Set to a default value or determine dynamically
                                        
                                        ];
                                    
                                        // Create a new request instance with the data
                                        $request = new \Illuminate\Http\Request();
                                        $request->replace($data);
                                    
                                        // Add the file to the request as if it was uploaded
                                        $request->files->set('other_documentation', $file);
                                    
                                        // Create an instance of the MaterialController
                                        $controller = new MaterialController();
                                        
                                        // Temporarily disable middleware for the request
                                        // This is important if your controller methods are protected by middleware (e.g., auth)
                                        $controller->middleware('web', ['except' => ['store']]);
                                    
                                        // Call the store method and pass the custom request
                                        $material = $controller->store($request);
                                    
                                    }),
                                
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
                    ->label(__('Main Drawing'))
                    ->formatStateUsing(fn($state) => new HtmlString('
                            <div style=\'background-image: url("' . $state . '")\'
                                 class="w-8 h-8 bg-cover bg-center bg-no-repeat"></div>
                        ')),
                
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Project name'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_approved')
                    ->label(__('Approval status'))
                    ->boolean()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('rfq_count')
                    ->label(__('RFQ nr'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_excl_tax')
                    ->label(__('Total exc tax'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_incl_tax')
                    ->label(__('Total tax'))
                    ->sortable(),
                    

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->tooltip('View this Solution Record'),
                Tables\Actions\EditAction::make()->tooltip('Edit this Solution Record'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\DrawingsRelations::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSolutions::route('index'),
            // 'create' => Pages\CreateSolution::route('/create'),
            'edit' => Pages\EditSolution::route('/{record}/edit'),
        ];
    }    
}

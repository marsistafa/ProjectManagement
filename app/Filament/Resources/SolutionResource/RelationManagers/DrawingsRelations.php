<?php

namespace App\Filament\Resources\SolutionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\Action;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Filament\Tables\Columns\ImageColumn;
use App\Http\Livewire\ImageViewer;
use App\Http\Controllers\DrawingController;
use App\Http\Controllers\MaterialController;

class DrawingsRelations extends RelationManager
{
    protected static string $relationship = 'drawings';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $inverseRelationship = 'projectsAffected';

    public static function attach(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cover')
                ->label(__('Main Drawing'))
                ->default(function($record) {
                    $newPath = str_replace('public', config('app.url') . '/storage', $record->file_path);
                    return view('livewire.small-image-viewer', ['image' => $newPath]);
                    }),
                    
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable()
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Action::make('upload')
                    ->label(__('Upload Drawing'))
                    ->action(function ($record) {
                        // Assuming $record is the current Solution model instance
                        // Trigger Livewire component with the necessary properties
                        $this->emit('OpenUploadModal', [
                            'solution_id' => $record->id,
                            'project_id' => $record->project_id,
                        ]);
                    })
                    ->form([
                        FileUpload::make('drawings')
                            ->label(__('Technical Drawings'))
                            ->multiple()
                            ->columnSpan(2)
                            // ->saveUploadedFileUsing(function ($file, $record) {
                      
                            //     $data = [
                            //         'solution_id' => $solution_id,
                            //         'is_approved' => 0,
                            //         'file_path' => $file,
                            //         'project_id' => $project_id,
                            //         'title' => $file->getClientOriginalName(),
                            //     ];
                                
                            //     $request = new \Illuminate\Http\Request();
                            //     $request->replace($data);
                                
                            //     $controller = new DrawingController();
                            //     $drawing = $controller->store($request);
                            // }),
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalWidth('full')
                    ->modalContent(function($record) {
                        $newPath = str_replace('public', config('app.url') . '/storage', $record->file_path);
                        return view('livewire.image-viewer', ['image' => $newPath]);
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }

    protected function canCreate(): bool
    {
        return false;
    }

    protected function canDelete(Model $record): bool
    {
        return false;
    }

    protected function canDeleteAny(): bool
    {
        return false;
    }
}

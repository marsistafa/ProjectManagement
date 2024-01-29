<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use App\Filament\Resources\SupplierResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Forms\Components\RichEditor;
use App\Models\SupplierComment;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class EditSupplier extends EditRecord
{
    protected static string $resource = SupplierResource::class;

    public $selectedCommentId;

    protected function getActions(): array
    {
        return [

            Actions\Action::make('comments')
            ->form([
                Forms\Components\View::make('livewire.comments',['record'=> $this->record]),
                Forms\Components\RichEditor::make('comments')
                ->label('Comments')
                ->disableLabel()
                ->placeholder(__('Type a new comment'))
                ->required(),
            ])
            ->action(
                    function($record, array $data, array $arguments,$action)
                    {
                        if ($this->selectedCommentId) {
                            SupplierComment::where('id', $this->selectedCommentId)
                                ->update([
                                    'content' => $data['comments']
                                ]);
                        } else {
                            SupplierComment::create([
                                'user_id' => auth()->user()->id,
                                'supplier_id' => $this->record->id,
                                'content' => $data['comments']
                            ]);
                        }
                      
                        $this->record->refresh();
                        $this->notify('success', __('Comment saved'));

                        $action->halt();
                        
                    }),

            Actions\DeleteAction::make(),
        ];
    }
}

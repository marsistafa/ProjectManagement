<?php

namespace App\Filament\Resources\DrawingsResource\Pages;

use App\Filament\Resources\DrawingsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Form;
use Filament\Forms\Components\RichEditor;
use Filament\Facades\Filament;
use Filament\Forms;
use App\Models\TicketComment;
use App\Models\DrawingComment;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
class EditDrawings extends EditRecord
{
    protected static string $resource = DrawingsResource::class;
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
                            DrawingComment::where('id', $this->selectedCommentId)
                                ->update([
                                    'content' => $data['comments']
                                ]);
                        } else {
                            DrawingComment::create([
                                'user_id' => auth()->user()->id,
                                'drawing_id' => $this->record->id,
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

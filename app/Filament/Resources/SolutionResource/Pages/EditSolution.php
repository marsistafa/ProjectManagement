<?php

namespace App\Filament\Resources\SolutionResource\Pages;

use App\Filament\Resources\SolutionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Solution;
use App\Models\SolutionComment;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Forms\Components\RichEditor;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class EditSolution extends EditRecord
{
    protected static string $resource = SolutionResource::class;

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
                            SolutionComment::where('id', $this->selectedCommentId)
                                ->update([
                                    'content' => $data['comments']
                                ]);
                        } else {
                            SolutionComment::create([
                                'user_id' => auth()->user()->id,
                                'solution_id' => $this->record->id,
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

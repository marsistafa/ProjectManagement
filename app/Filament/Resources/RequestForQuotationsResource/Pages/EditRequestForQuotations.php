<?php

namespace App\Filament\Resources\RequestForQuotationsResource\Pages;

use App\Filament\Resources\RequestForQuotationsResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\RequestForQuotation;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Forms\Components\RichEditor;
use App\Models\TicketComment;
use App\Models\RFQComment;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class EditRequestForQuotations extends EditRecord
{
    protected static string $resource = RequestForQuotationsResource::class;

    public $rfqDetailsSum=0;

    protected $listeners = ['refresh'=>'refreshForm', 'doDeleteComment'];

    public string $tab = 'comments';


    public $selectedCommentId;

    public function refreshForm()
    {
        $this->fillForm();
    }

    public function mount($record): void
    {
        parent::mount($record);

        // Now, $this->record refers to the RequestForQuotation being edited
        if ($this->record) {
            // Calculate the sum of total_price_excl_tax for the related RFQDetails
            $this->rfqDetailsSum = $this->record->rfqDetails->sum('total_price_excl_tax');
        } else {
            $this->rfqDetailsSum = 0;
        }
       
    }

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
                                RFQComment::where('id', $this->selectedCommentId)
                                    ->update([
                                        'content' => $data['comments']
                                    ]);
                            } else {
                                RFQComment::create([
                                    'user_id' => auth()->user()->id,
                                    'request_for_quotation_id' => $this->record->id,
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

    // public function resetComment()
    // {
    //     $this->selectedCommentId = null;
    //     // Reset other related properties if needed
    // }

    // public function submitComment(): void
    // {

    //     $data = $this->form->getState();
    //     if ($this->selectedCommentId) {
    //         RFQComment::where('id', $this->selectedCommentId)
    //             ->update([
    //                 'content' => $data['comment']
    //             ]);
    //     } else {
    //         RFQComment::create([
    //             'user_id' => auth()->user()->id,
    //             'ticket_id' => $this->record->id,
    //             'content' => $data['comment']
    //         ]);
    //     }
    //     $this->record->refresh();
    //     $this->cancelEditComment();
    //     $this->notify('success', __('Comment saved'));
    // }

    // public function isAdministrator(): bool
    // {
    //     return $this->record
    //             ->project
    //             ->users()
    //             ->where('users.id', auth()->user()->id)
    //             ->where('role', 'administrator')
    //             ->count() != 0;
    // }

    // public function editComment(int $commentId): void
    // {
    //     $this->selectedCommentId = $commentId;
    //     $this->form->fill([
    //         'comment' => $this->record->comments->where('id', $commentId)->first()?->content
    //     ]);
    //     $this->selectedCommentId = $commentId;
    // }

    // public function deleteComment(int $commentId): void
    // {
    //     Notification::make()
    //         ->warning()
    //         ->title(__('Delete confirmation'))
    //         ->body(__('Are you sure you want to delete this comment?'))
    //         ->actions([
    //             Action::make('confirm')
    //                 ->label(__('Confirm'))
    //                 ->color('danger')
    //                 ->button()
    //                 ->close()
    //                 ->emit('doDeleteComment', compact('commentId')),
    //             Action::make('cancel')
    //                 ->label(__('Cancel'))
    //                 ->close()
    //         ])
    //         ->persistent()
    //         ->send();
    // }

    // public function doDeleteComment(int $commentId): void
    // {
    //     RFQComment::where('id', $commentId)->delete();
    //     $this->record->refresh();
    //     $this->notify('success', __('Comment deleted'));
    // }

    // public function cancelEditComment(): void
    // {
    //     $this->form->fill();
    //     $this->selectedCommentId = null;
    // }

   
}

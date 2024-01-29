<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RFQTicket extends Model
{
    // If you are not using Laravel's default timestamps, you should disable them
    // public $timestamps = false;
    protected $table = 'rfq_tickets'; // Explicitly setting the table name

    protected $fillable = [
        'request_for_quotation_id',
        'ticket_id',
        // Add other fields that you want to be mass-assignable
    ];

    public function rfq()
    {
        return $this->belongsTo(RequestForQuotation::class, 'request_for_quotation_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    // If you have users who created or are assigned to the RFQ tickets, you can add those relationships too
    // public function createdBy()
    // {
    //     return $this->belongsTo(User::class, 'created_by');
    // }
    
    // If the RFQTicket model needs to approve or reject actions, you can add an approver relationship
    // public function approvedBy()
    // {
    //     return $this->belongsTo(User::class, 'approved_by');
    // }
}

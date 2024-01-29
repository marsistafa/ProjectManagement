<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolutionTicket extends Model
{
    use HasFactory;

    // Assuming your solution_tickets table has 'solution_id' and 'ticket_id'
    protected $fillable = [
        'solution_id',
        'ticket_id'
    ];

    public function solution()
    {
        return $this->belongsTo(Solution::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}

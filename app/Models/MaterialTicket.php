<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialTicket extends Model
{
    use HasFactory;

    // Assuming your material_tickets table uses the default Laravel timestamp columns
    protected $fillable = [
        'material_id',
        'ticket_id'
    ];

    /**
     * Get the material associated with the material ticket.
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Get the ticket associated with the material ticket.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}

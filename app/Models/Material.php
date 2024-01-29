<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
        'specification',
        'created_by',
        'solution_id',
        'project_id',
        'is_approved'
    ];

    protected $attributes = [
        'is_approved' => 0, // Default value for is_approved

    ];
    // Relationships
    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function requestForQuotations()
    {
        return $this->belongsToMany(RequestForQuotation::class, 'rfq_materials');
    }

    public function tickets()
    {
        return $this->hasMany(MaterialTicket::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function comments()
    {
        // return $this->hasMany(RequestForQuotation::class);
        return $this->hasMany(
            MaterialComment::class,

        );
    }

    public function materialDocument()
    {
        return $this->hasMAny(
            MaterialDocument::class,
        );
    }
}

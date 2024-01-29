<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Drawing extends Model implements HasMedia
{   
     use HasFactory,InteractsWithMedia;

    // Assuming your drawings table has these fields:
    protected $fillable = [
        'solution_id',
        'file_path',
        'project_id',
        'is_approved',
        'title'
    ];

    /**
     * Get the solution that the drawing belongs to.
     */
    public function solution()
    {
        return $this->belongsTo(Solution::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function comments()
    {
        // return $this->hasMany(RequestForQuotation::class);
        return $this->hasMany(
            DrawingComment::class,

        );
    }
    // Add any other relationships here as needed.
}

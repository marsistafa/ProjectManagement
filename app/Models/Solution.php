<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Solution extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $fillable = [
        'project_id',
        'created_by',
        'is_approved'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function drawings()
    {
        return $this->hasMany(Drawing::class);
    }

    public function materials()
    {
        return $this->hasManyThrough(
            Material::class,
            RequestForQuotation::class,
            'solution_id', // Foreign key on the RFQ table...
            'id', // Foreign key on the material table...
            'id', // Local key on the solution table...
            'material_id' // Local key on the RFQ table...
        );
    }

    public function tickets()
    {
        return $this->hasMany(SolutionTicket::class);
    }

    public function cover(): Attribute
    {
        return new Attribute(
            get: fn() => $this->media('cover')?->first()?->getFullUrl()
                ??
                'https://ui-avatars.com/api/?background=3f84f3&color=ffffff&name=' . $this->name
        );
    }

    public function comments()
    {
        // return $this->hasMany(RequestForQuotation::class);
        return $this->hasMany(
            SolutionComment::class,

        );
    }
}

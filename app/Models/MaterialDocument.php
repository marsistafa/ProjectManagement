<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialDocument extends Model
{
    use HasFactory;

    protected $fillable = ['datasheet', 'manual', 'DOC', 'other', 'material_id'];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function materialDocument()
    {
        return $this->belongsTo(Material::class);
    }
}

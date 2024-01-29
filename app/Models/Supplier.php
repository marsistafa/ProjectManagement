<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // Define the table associated with the model if it's not the plural of the model name
    protected $table = 'suppliers';

    // Specify which attributes can be mass-assignable
    protected $fillable = [
        'name',
        'nipt',
        'address',
        'website',
        'email',
        'phone'
    ];

    // Define relationships, for example, a supplier might have many RFQs
    public function requestForQuotations()
    {
        return $this->hasMany(RequestForQuotation::class);
    }

    // If you have a pivot table for suppliers and materials, define that relationship too
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'rfq_materials');
    }

    public function comments()
    {
        // return $this->hasMany(RequestForQuotation::class);
        return $this->hasMany(
            SupplierComment::class,

        );
    }

    // Define any other relationships the supplier might have, such as with RFQ details or documents
    // ...
}

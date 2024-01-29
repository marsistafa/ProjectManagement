<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;

class RequestForQuotation extends Model
{
    use HasFactory;

    // Assuming you have a fillable property to allow mass assignment.
    protected $fillable = [
        'rfq_number',
        'deadline',
        'project_id',
        'solution_id',
        'supplier_id',
        'created_by',
        'is_approved',
        'transport_cost',
        'other_cost',
        'discount',
        'total_excl_tax',
        'tax',
        'total_incl_tax',
        'payment_conditions',
        'product_warranty',
        'delivery_terms',
        'delivery_place'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }


    public function solution()
    {
        return $this->belongsTo(Solution::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function materials()
    {
        // Assuming you have a pivot table named 'rfq_materials'
        return $this->belongsToMany(Material::class);
    }

    public function rfqDetails()
    {
        return $this->hasMany(RFQDetail::class);
    }

    public function rfqDocuments()
    {
        // return $this->hasMany(RFQDocument::class);
        return $this->hasManyThrough(
            RequestForQuotation::class,

        );
    }

    public function comments()
    {
        // return $this->hasMany(RequestForQuotation::class);
        return $this->hasMany(
            RFQComment::class,

        );
    }

    public function tickets()
    {
        // Assuming you have a pivot table for tickets named 'rfq_tickets'
        return $this->hasMany(RFQTicket::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public static function generateNextRfqNumber()
    {
        $lastRfq = self::latest('id')->first();
        if (!$lastRfq) {
            // Return the first number if no records are present
            return 'KPO_000001';
        }

        $prefix = 'KPO_';
        $number = intval(substr($lastRfq->rfq_number, 4)); // Extracts the number part

        $number++;
        if ($number > 999999) {
            $number = 1; // Reset to 1 if it exceeds 6 digits
        }

        return $prefix . sprintf('%06d', $number); // Formats to a 6-digit number
    }

    public function getRfqDetailsSumAttribute()
    {
        return $this->rfqDetails()->sum('total_price_excl_tax');
    }

}

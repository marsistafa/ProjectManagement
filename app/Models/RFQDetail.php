<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class RFQDetail extends Model
{
    use HasFactory;

    protected $table = 'rfq_details';

    protected $fillable = [
        'request_for_quotation_id',
        'material_id',
        'description',
        'unit',
        'quantity',
        'unit_price_excl_tax',
        'total_price_excl_tax',
        'technical_details',
        'created_by'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($rfqDetail) {
            $rfqDetail->reCalcRequestForQuotationTotals();
        });

        static::deleted(function ($rfqDetail) {
            $rfqDetail->reCalcRequestForQuotationTotals();
        });
    }

    public function rfq()
    {
        return $this->belongsTo(RequestForQuotation::class, 'rfq_id');
    }

    public function requestForQuotation()
    {
        return $this->belongsTo(RequestForQuotation::class, 'request_for_quotation_id', 'id');
    }

    // If you have a materials relationship:
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reCalcRequestForQuotationTotals()
    {
        $totalExclTax = self::where('request_for_quotation_id', $this->request_for_quotation_id)
                            ->sum('total_price_excl_tax');

        $requestForQuotation = RequestForQuotation::find($this->request_for_quotation_id);

        if ($requestForQuotation) {
            // Add transport and other costs
            $totalExclTax += $requestForQuotation->transport_cost + $requestForQuotation->other_cost;

            // Subtract discount (as a percentage)
            $discountAmount = $totalExclTax * ($requestForQuotation->discount / 100);
            $totalExclTax -= $discountAmount;

            // Calculate tax and total including tax
            $tax = $totalExclTax * 0.20; // 20% tax
            $totalInclTax = $totalExclTax + $tax;

            // Update the RequestForQuotation model
            $requestForQuotation->update([
                'total_excl_tax' => $totalExclTax,
                'tax' => $tax,
                'total_incl_tax' => $totalInclTax
            ]);
        }
    }

}

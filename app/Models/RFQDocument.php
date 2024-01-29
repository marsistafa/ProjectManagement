<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RFQDocument extends Model
{
    use HasFactory;
    protected $table = 'rfq_documents'; 

    // Assuming you want to allow mass assignment for these fields
    protected $fillable = [
        'request_for_quotation_id',
        'document_path'
        ];

    /**
     * Get the RFQ that the document belongs to.
     */
    public function rfq()
    {
        return $this->belongsTo(RequestForQuotation::class, 'rfq_id');
    }

    public function rfqDocuments()
    {
        return $this->belongsToMany(RequestForQuotation::class, 'rfq_documents');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\RFQDocument;
use Illuminate\Http\Request;

class RFQDocumentController extends Controller
{
    
    public function store(Request $request)
    {
     
        $validatedData = $request->validate([
                'request_for_quotation_id' => 'required|exists:request_for_quotations,id',
                'document_path'=> 'required',
               
        ]);
    
        
        $validatedData['document_path'] = $request->document_path->store('public/rfq_documents');

        $document = RFQDocument::create($validatedData);

        return $document;

  
    }

   
}

<?php

namespace App\Http\Controllers;

use App\Models\RequestForQuotation;
use App\Models\RFQDetail;
use App\Models\RFQDocument;
use App\Models\Supplier;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Throwable;

class RequestForQuotationController extends Controller
{
    public function index($projectId = null, $solutionId = null)
    {

        $projectId = request('project_id');
        $solutionId = request('solution_id');
        
        $query = RequestForQuotation::with(['rfqDetails', 'rfqDocuments']);
    
        if ($projectId) {
            $query->where('project_id', $projectId);
        }
    
        if ($solutionId) {
            $query->where('solution_id', $solutionId);
        }
    
        $rfqs = $query->get();
    
        // return view('requestForQuotations.index', compact('rfqs'));
        return $rfqs;
    }
    

    public function create()
    {
        $projects = Project::all(); // Assuming you have a Project model
        $solutions = Solution::all(); // Assuming you have a Solution model
        return view('requestForQuotations.create', compact('projects', 'solutions'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'deadline' => 'required|date',
                'project_id' => 'required|exists:projects,id',
                'solution_id' => 'required|exists:solutions,id',
                'created_by' => 'required|exists:users,id',
                'is_approved' => 'required|boolean',
                'transport_cost' => 'nullable|numeric',
                'other_cost' => 'nullable|numeric',
                'discount' => 'nullable|numeric',
                'supplier_name' => 'required|string',
                'payment_conditions' => 'nullable|string',
                'product_warranty' => 'nullable|string',
                'delivery_terms' => 'nullable|string',
                'delivery_place' => 'nullable|string',
            ]);

            // Auto-generate RFQ number
            $validatedData['rfq_number'] = RequestForQuotation::generateNextRfqNumber();

            // Handle Supplier
            $supplier = Supplier::firstOrCreate([
                'name' => $request->supplier_name,
                // Assume additional supplier fields like 'nipt', 'address', etc. are included in the form request
                'nipt' => $request->nipt,
                'address' => $request->address,
                'website' => $request->website,
                'email' => $request->email,
                'phone' => $request->phone
            ]);
            $validatedData['supplier_id'] = $supplier->id;

            // Create RFQ
            $rfq = RequestForQuotation::create($validatedData);

            // Handle RFQDetails
            foreach ($request->rfqDetails as $detail) {
                $material = Material::firstOrCreate([
                    'name' => $detail['description'],
                    'specification' => $detail['technical_details'],
                    'project_id' => $detail['project_id'], // assuming this is part of the request
                    'solution_id' => $detail['solution_id'], // assuming this is part of the request
                    'created_by' => $detail['created_by'] // assuming this is part of the request
                ]);

                $detailData = array_merge($detail, ['material_id' => $material->id]);
                $rfq->rfqDetails()->create($detailData);
            }

            // Handle RFQDocuments
            if ($request->hasFile('rfqDocuments')) {
                foreach ($request->file('rfqDocuments') as $document) {
                    $filePath = $document->store('rfq_documents', 'public');
                    $rfq->rfqDocuments()->create([
                        'document_path' => $filePath,
                        'description' => $document->getClientOriginalName(),
                    ]);
                }
            }

            // Update totals
            $totalExclTax = $rfq->rfqDetails->sum('total_price_excl_tax');
            $rfq->update([
                'total_excl_tax' => $totalExclTax,
                'tax' => $totalExclTax * 0.20,
                'total_incl_tax' => $totalExclTax * 1.20
            ]);

            DB::commit();
            // return redirect()->route('requestForQuotations.show', $rfq);
            return $rfq;
        } catch (Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->withErrors('An unexpected error occurred.')->withInput();
        }
    }

    public function show(RequestForQuotation $rfq)
    {
        $rfq->load(['rfqDetails', 'rfqDocuments']);
        // return view('requestForQuotations.show', compact('rfq'));
        return $rfq;
    }

    public function edit(RequestForQuotation $rfq)
    {
        $projects = Project::all();
        $solutions = Solution::all();
        $rfq->load(['rfqDetails', 'rfqDocuments']);
        return view('requestForQuotations.edit', compact('rfq', 'projects', 'solutions'));
    }

    public function update(Request $request, RequestForQuotation $rfq)
    {
        $validatedData = $request->validate([
            // Include validation rules for each updatable field
            'deadline' => 'required|date',
            'project_id' => 'required|exists:projects,id',
            'solution_id' => 'required|exists:solutions,id',
            'supplier_name' => 'required|string',
            'created_by' => 'required|exists:users,id',
            'is_approved' => 'required|boolean',
            'transport_cost' => 'nullable|numeric',
            'other_cost' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'total_excl_tax' => 'required|numeric',
            'tax' => 'required|numeric',
            'total_incl_tax' => 'required|numeric',
            'payment_conditions' => 'nullable|string',
            'product_warranty' => 'nullable|string',
            'delivery_terms' => 'nullable|string',
            'delivery_place' => 'nullable|string',
            // Add additional fields as necessary
        ]);
    
        // Update the RFQ with new data
        $rfq->update($validatedData);
    
        // Update RFQDetails
        if ($request->has('rfqDetails')) {
            // First, optionally remove existing details not in the update request
            // RFQDetail::where('rfq_id', $rfq->id)->delete(); // Uncomment if necessary
    
            foreach ($request->rfqDetails as $detail) {
                $material = Material::firstOrCreate([
                    'name' => $detail['description'],
                    'specification' => $detail['technical_details']
                ]);
    
                $detailData = array_merge($detail, ['material_id' => $material->id]);
                $rfqDetail = RFQDetail::updateOrCreate(
                    ['rfq_id' => $rfq->id, 'material_id' => $material->id],
                    $detailData
                );
            }
        }
    
        // Update RFQDocuments
        if ($request->hasFile('rfqDocuments')) {
            foreach ($request->file('rfqDocuments') as $document) {
                $filePath = $document->store('rfq_documents', 'public');
                $rfq->rfqDocuments()->updateOrCreate(
                    ['document_path' => $filePath],
                    ['description' => $document->getClientOriginalName()]
                );
            }
        }
    
        // Recalculate totals after update
        $totalExclTax = $rfq->rfqDetails->sum('total_price_excl_tax');
        $rfq->update([
            'total_excl_tax' => $totalExclTax,
            'tax' => $totalExclTax * 0.20,
            'total_incl_tax' => $totalExclTax * 1.20
        ]);
    
        return redirect()->route('requestForQuotations.show', $rfq);
    }
    

    public function destroy(RequestForQuotation $rfq)
    {
        $rfq->delete();
        return redirect()->route('requestForQuotations.index');
    }
}

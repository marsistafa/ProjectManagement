<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
      
        // Validate project_id if it's present in the request
        // $request->validate(['project_id' => 'exists:projects,id']);

        // Filter supplier based on project_id if it's provided
        $suppliers = Supplier::when($request->has('project_id'), function ($query) use ($request) {
            return $query->where('project_id', $request->input('project_id'));
        })
        ->when($request->has('solution_id'), function ($query) use ($request) {
            return $query->where('solution_id', $request->input('solution_id'));
        })
        ->when($request->has('material_id'), function ($query) use ($request) {
            return $query->where('material_id', $request->input('material_id'));
        })
        ->get();

        return $suppliers;

        // Return a view or a response with the filtered supplier
        // return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        // Return a view for creating a new supplier
        // return view('suppliers.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:20',
            'nipt' => [
                'required',
                'regex:/^[A-Z]{1}[0-9]{8}[A-Z]{1}$/'
            ],
            'address' => 'required|string',
            'website' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|numeric',
            // Include other fields as necessary
        ]);

        // Store the new supplier in the database
        $supplier = Supplier::create($validated);

        // Redirect or return a response
        return $supplier;
    }

    public function show(Supplier $supplier)
    {
        // Return a view or a response with the specified supplier
        // return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        // Return a view for editing the specified supplier
        // return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        // // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:20',
            'nipt' => [
                'required',
                'regex:/^[A-Z]{1}[0-9]{8}[A-Z]{1}$/'
            ],
            'address' => 'required|string',
            'website' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|numeric',
            // Include other fields as necessary
        ]);

        $supplier->update($validated);
        
        // Redirect or return a response
        return $supplier;
    }

    public function destroy(Solution $supplier)
    {
        // Delete the specified supplier from the database
        $supplier->delete();

        // Redirect or return a response
        // return redirect()->route('suppliers.index');
    }
}

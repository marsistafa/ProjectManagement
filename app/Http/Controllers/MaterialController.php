<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $materials = Material::where('project_id', $request->input('project_id'))
                   ->orWhere('solution_id', $request->input('solution_id'))
                   ->get();

        return $materials;

    }

    public function create()
    {
        return view('materials.create');
    }

    public function store(Request $request)
    {
    
        if(!$request->material_id){

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'project_id' => 'required|exists:projects,id',
                'specification' => 'nullable|string',
                'is_approved' => 'nullable|boolean'
            ]);
    
            // Handle file uploads
            if ($request['datasheet']) {
                $originalName = $request['datasheet']->getClientOriginalName();
                $validatedData['datasheet'] = $request['datasheet']->storeAs('public/material_documents/datasheet', $originalName);
            }
            if ($request['manual']) {
                $originalName = $request['manual']->getClientOriginalName();
                $validatedData['manual'] = $request['manual']->storeAs('public/material_documents/manual', $originalName);
            }
            if ($request['DOC']) {
                $originalName = $request['DOC']->getClientOriginalName();
                $validatedData['DOC'] = $request['DOC']->storeAs('public/material_documents/DOC', $originalName);
            }
            if ($request['other_documentation']) {
                $originalName = $request['other_documentation']->getClientOriginalName();
                $validatedData['other'] = $request['other_documentation']->storeAs('public/material_documents/other', $originalName);
            }
         
         
            $validatedData['created_by'] = Auth::user()->id;
       
            
            $material = Material::create($validatedData);
    

        }
 
        $validatedData['material_id'] = $material->id;
        $material = MaterialDocument::create($validatedData);

        return $material;
    }
    

    public function show(Material $material)
    {
        return view('materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'specification' => 'nullable|string',
        ]);
    
        // Handle file uploads
        if ($request->hasFile('datasheet')) {
            $validatedData['datasheet'] = $request->file('datasheet')->store('public/datasheet');
        }
        if ($request->hasFile('manual')) {
            $validatedData['manual'] = $request->file('manual')->store('public/manual');
        }
        if ($request->hasFile('DOC')) {
            $validatedData['DOC'] = $request->file('DOC')->store('public/DOC');
        }
        if ($request->hasFile('other_documentation')) {
            $validatedData['other_documentation'] = $request->file('other_documentation')->store('public/other_documentation');
        }
    
        // Set created_by to the ID of the authenticated user
        $validatedData['created_by'] = auth()->user()->id??1;
    
        // Set is_approved default value if not present in request
        $validatedData['is_approved'] = $request->has('is_approved') ? $request->input('is_approved') : 0;
    
        $material->update($validatedData);
        return $material;
    }

    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()->route('materials.index');
    }
}

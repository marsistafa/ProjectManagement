<?php

namespace App\Http\Controllers;

use App\Models\MaterialDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialDocumentController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $documents = MaterialDocument::all();
        return view('material_documents.index', compact('documents'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('material_documents.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
     
        $validatedData = $request->validate([
            'material_id' => 'required'
        ]);

        // Handle file uploads
        // if ($request['datasheet']) {
        //     $originalName = $request['datasheet']->getClientOriginalName();
        //     $validatedData['datasheet'] = $request['datasheet']->storeAs('public/material_documents/datasheet', $originalName);
        // }
        // if ($request['manual']) {
        //     $originalName = $request['manual']->getClientOriginalName();
        //     $validatedData['manual'] = $request['manual']->storeAs('public/material_documents/manual', $originalName);
        // }
        // if ($request['DOC']) {
        //     $originalName = $request['DOC']->getClientOriginalName();
        //     $validatedData['DOC'] = $request['DOC']->storeAs('public/material_documents/DOC', $originalName);
        // }
        // if ($request['other_documentation']) {
        //     $originalName = $request['other_documentation']->getClientOriginalName();
        //     $validatedData['other'] = $request['other_documentation']->storeAs('public/material_documents/other', $originalName);
        // }
     
     
        // $validatedData['created_by'] = Auth::user()->id;
   
        
        $material = MaterialDocument::create($request->all());
        return $material;
    }

    // Display the specified resource.
    public function show(MaterialDocument $materialDocument)
    {
        return view('material_documents.show', compact('materialDocument'));
    }

    // Show the form for editing the specified resource.
    public function edit(MaterialDocument $materialDocument)
    {
        return view('material_documents.edit', compact('materialDocument'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, MaterialDocument $materialDocument)
    {
        $materialDocument->update($request->all());
        return redirect()->route('material_documents.index');
    }

    // Remove the specified resource from storage.
    public function destroy(MaterialDocument $materialDocument)
    {
        $materialDocument->delete();
        return redirect()->route('material_documents.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Drawing;
use Illuminate\Http\Request;

class DrawingController extends Controller
{
    public function index(Request $request)
    {
        $drawings = Drawing::where('project_id', $request->input('project_id'))
                   ->orWhere('solution_id', $request->input('solution_id'))
                   ->get();

        return $drawings;

    }

    public function create()
    {
        // return view('drawings.create');
    }

    public function store(Request $request)
    {
     
        $validatedData = $request->validate([
                'project_id' => 'required|exists:projects,id',
                'is_approved' => 'required|boolean',
                'solution_id'=> 'required|exists:solutions,id',
                'file_path'=> 'required',
                'title'=> 'required',
    
        ]);
     
        $validatedData['file_path'] = $request->file_path->store('public/drawings');
        $drawing = Drawing::create($validatedData);

        return $drawing;
    }

    public function show(Drawing $drawing)
    {
        return view('drawings.show', compact('drawing'));
    }

    public function edit(Drawing $drawing)
    {
        return view('drawings.edit', compact('drawing'));
    }

    public function update(Request $request, Drawing $drawing)
    {
        $validatedData = $request->validate([
            'is_approved' => 'required|boolean'
        ]);

        $drawing->update($validatedData);

        return $drawing;
    }

    public function destroy(Drawing $drawing)
    {
        $drawing->delete();

        return redirect()->route('drawings.index');
    }
}

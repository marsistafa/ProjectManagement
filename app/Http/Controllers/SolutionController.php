<?php

namespace App\Http\Controllers;

use App\Models\Solution;
use Illuminate\Http\Request;

class SolutionController extends Controller
{
    public function index(Request $request)
    {
      
        // Validate project_id if it's present in the request
        // $request->validate(['project_id' => 'exists:projects,id']);

        // Filter solutions based on project_id if it's provided
        $solutions = Solution::where('project_id', $request->input('project_id'))->get();
      
        return $solutions;

        // Return a view or a response with the filtered solutions
        // return view('solutions.index', compact('solutions'));
    }

    public function create()
    {
        // Return a view for creating a new solution
        // return view('solutions.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'created_by' => 'required|exists:users,id',
            'is_approved' => 'required|boolean'
            // Include other fields as necessary
        ]);

        // Store the new solution in the database
        $solution = Solution::create($validated);

        // Redirect or return a response
        return $solution;
    }

    public function show(Solution $solution)
    {
        // Return a view or a response with the specified solution
        // return view('solutions.show', compact('solution'));
    }

    public function edit(Solution $solution)
    {
        // Return a view for editing the specified solution
        // return view('solutions.edit', compact('solution'));
    }

    public function update(Request $request, Solution $solution)
    {
        // // Validate the request data
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'created_by' => 'required|exists:users,id',
            'is_approved' => 'required|boolean'
            // Include other fields as necessary
        ]);
        //     dd($validated);
        // Update the specified solution in the database
        // $validated = $request->all();
        $solution->update($validated);
        
        // Redirect or return a response
        return $solution;
    }

    public function destroy(Solution $solution)
    {
        // Delete the specified solution from the database
        $solution->delete();

        // Redirect or return a response
        // return redirect()->route('solutions.index');
    }
}

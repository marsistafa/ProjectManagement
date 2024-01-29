<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\MaterialTicket;
use Illuminate\Http\Request;

class MaterialTicketController extends Controller
{
    public function index(Request $request)
    {
        $materialTickets = MaterialTicket::where('material_id', $request->input('material_id'))->get();
        return $materialTickets;
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'owner_id' => 'required|exists:users,id',
            'responsible_id' => 'nullable|exists:users,id',
            'status_id' => 'required|exists:ticket_statuses,id',
            'project_id' => 'required|exists:projects,id',
            'type_id' => 'required|exists:ticket_types,id',
            'priority_id' => 'required|exists:ticket_priorities,id',
            'estimation' => 'nullable|numeric',
            'epic_id' => 'nullable|exists:epics,id',
            'sprint_id' => 'nullable|exists:sprints,id',
            // Add other fields as required
        ]);

        // Begin a transaction
        \DB::beginTransaction();
        try { 
            // Create the ticket
            $ticket = Ticket::create($validatedData);
   
            // Now create the MaterialTicket relationship
            $materialTicket = new MaterialTicket([
                'ticket_id' => $ticket->id,
                'material_id' => $validatedData['material_id'],
            ]);

            $materialTicket->save();

            // Commit the transaction
            \DB::commit();
            
            return  $materialTicket;

        } catch (\Exception $e) {
            // Rollback the transaction
            \DB::rollback();

            return back()->withErrors('An error occurred: ' . $e->getMessage());
        }
    }

    public function show(MaterialTicket $materialTicket)
    {
        $materialTicket->load('ticket', 'material');
        return view('materialTickets.show', compact('materialTicket'));
    }

    public function create()
    {
        // Return a view for creating a new solution
        // return view('solutions.create');
    }

    public function edit(MaterialTicket $materialTicket)
    {
        // $materials = Material::all();
        // return view('materialTickets.edit', compact('materialTicket', 'materials'));
    }
    public function update(Request $request, MaterialTicket $materialTicket)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            // Assuming the material_id remains constant. If it can change, include it in validation.
            'material_id' => 'required|exists:materials,id',
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'owner_id' => 'required|exists:users,id',
            'responsible_id' => 'nullable|exists:users,id',
            'status_id' => 'required|exists:ticket_statuses,id',
            'project_id' => 'required|exists:projects,id',
            'type_id' => 'required|exists:ticket_types,id',
            'priority_id' => 'required|exists:ticket_priorities,id',
            'estimation' => 'nullable|numeric',
            'epic_id' => 'nullable|exists:epics,id',
            'sprint_id' => 'nullable|exists:sprints,id',
            // Add other fields as required
        ]);
    
        // Begin a transaction
        \DB::beginTransaction();
        try {
            // Update the associated Ticket
            $ticket = $materialTicket->ticket;
            $ticketData = $validatedData;
            // Optionally remove fields not belonging to the Ticket model
            $ticket->update($ticketData);
    
            // Since material_id might be constant, it's not included in the update. 
            // If it can change, include the following line:
            // $materialTicket->material_id = $validatedData['material_id'];
    
            // Commit the transaction
            \DB::commit();
            return $materialTicket;
            // return redirect()->route('materialTickets.show', $materialTicket->id)
            //                  ->with('success', 'Material ticket updated successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction
            \DB::rollback();
    
            return back()->withErrors('An error occurred: ' . $e->getMessage());
        }
    }
    
    public function destroy(MaterialTicket $materialTicket)
    {
        $materialTicket->delete();

        return redirect()->route('materialTickets.index')
                         ->with('success', 'Material ticket deleted successfully.');
    }

}

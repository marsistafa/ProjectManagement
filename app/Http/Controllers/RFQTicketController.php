<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\RFQTicket;
use Illuminate\Http\Request;

class RFQTicketController extends Controller
{
    public function index(Request $request)
    {
        $RfqTickets = RFQTicket::where('request_for_quotation_id', $request->input('request_for_quotation_id'))->get();
        return $RfqTickets;
    }

    public function store(Request $request)
    {     
        // Validate the incoming request data
        $validatedData = $request->validate([
            'request_for_quotation_id' => 'required|exists:request_for_quotations,id',
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

            // Now create the RFQTicket relationship
            $RfqTicket = new RFQTicket([
                'ticket_id' => $ticket->id,
                'request_for_quotation_id' => $validatedData['request_for_quotation_id'],
            ]);

            $RfqTicket->save();

            // Commit the transaction
            \DB::commit();
            
            return  $RfqTicket;

        } catch (\Exception $e) {
            // Rollback the transaction
            \DB::rollback();

            return back()->withErrors('An error occurred: ' . $e->getMessage());
        }
    }

    public function show(RFQTicket $RfqTicket)
    {
        $RfqTicket->load('ticket', 'request_for_quotation');
        return view('RFQTickets.show', compact('RFQTicket'));
    }

    public function create()
    {
        // Return a view for creating a new solution
        // return view('solutions.create');
    }

    public function edit(RFQTicket $RfqTicket)
    {
        // $materials = Material::all();
        // return view('materialTickets.edit', compact('materialTicket', 'materials'));
    }
    public function update(Request $request, RFQTicket $RfqTicket)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            // Assuming the request_for_quotation_id remains constant. If it can change, include it in validation.
            'request_for_quotation_id' => 'required|exists:request_for_quotation,id',
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
            $ticket = $RfqTicket->ticket;
            $ticketData = $validatedData;
            // Optionally remove fields not belonging to the Ticket model
            $ticket->update($ticketData);
    
            // Since material_id might be constant, it's not included in the update. 
            // If it can change, include the following line:
            // $materialTicket->material_id = $validatedData['material_id'];
    
            // Commit the transaction
            \DB::commit();
            return $RfqTicket;
            // return redirect()->route('materialTickets.show', $materialTicket->id)
            //                  ->with('success', 'Material ticket updated successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction
            \DB::rollback();
    
            return back()->withErrors('An error occurred: ' . $e->getMessage());
        }
    }
    
    public function destroy(RFQTicket $RfqTicket)
    {
        $RfqTicket->delete();

        return redirect()->route('RFQTickets.index')
                         ->with('success', 'Rfq ticket deleted successfully.');
    }
}

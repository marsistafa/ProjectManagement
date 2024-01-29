<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Solution;
use App\Models\SolutionTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolutionTicketController extends Controller
{
    public function index(Request $request)
    {
        $solutionTickets = SolutionTicket::where('solution_id', $request->input('solution_id'))->get();
        return $solutionTickets;
    }

    public function create()
    {
        $solutions = Solution::all();
        return view('solutionTickets.create', compact('solutions'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'solution_id' => 'required|exists:solutions,id',
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
        ]);

        DB::beginTransaction();
        try {
            $ticketData = $validatedData;
            unset($ticketData['solution_id']); // Remove solution_id as it's not part of the Ticket model

            $ticket = Ticket::create($ticketData);

            $solutionTicket = new SolutionTicket([
                'ticket_id' => $ticket->id,
                'solution_id' => $validatedData['solution_id'],
            ]);
            $solutionTicket->save();

            DB::commit();
            return $solutionTicket;
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors('An error occurred: ' . $e->getMessage());
        }
    }

    public function show(SolutionTicket $solutionTicket)
    {
        $solutionTicket->load('solution', 'ticket');
        return view('solutionTickets.show', compact('solutionTicket'));
    }

    public function edit(SolutionTicket $solutionTicket)
    {
        $solutions = Solution::all();
        return view('solutionTickets.edit', compact('solutionTicket', 'solutions'));
    }

    public function update(Request $request, SolutionTicket $solutionTicket)
    {
        $validatedData = $request->validate([
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
        ]);

        DB::beginTransaction();
        try {
            $ticket = $solutionTicket->ticket;
            $ticket->update($validatedData);

            DB::commit();
            return $solutionTicket;
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors('An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy(SolutionTicket $solutionTicket)
    {
        $solutionTicket->delete();
        return redirect()->route('solutionTickets.index')
                         ->with('success', 'Solution ticket deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AssetTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all tickets ordered by latest
        $tickets = AssetTicket::orderBy('created_at', 'desc')->get();

        return view('asset_tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get the latest ticket to generate next number
        $latestTicket = AssetTicket::orderBy('id', 'desc')->first();
        $users = User::all();

        $ticketNumber = 'TKT-00001'; // default first number

        if ($latestTicket) {
            $nextId = $latestTicket->id + 1;
            $ticketNumber = 'TKT-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
        }

        // Pass it to the view
        return view('asset_tickets.create', compact('ticketNumber','users'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'ticket_no'     => 'required|string|max:255',
            'created_on'    => 'required|date',
            'category_id'   => 'required|numeric',
            'unit'          => 'required|string|max:255',
            'division'      => 'required|string|max:255',
            'priority'      => 'required|string|max:50',
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
        ]);

        AssetTicket::create([
            'ticket_no'     => $validated['ticket_no'],
            'created_by'    => Auth::id(),                 // 👈 fix here
            'created_on'    => $validated['created_on'],
            'category_id'   => $validated['category_id'],
            'unit'          => $validated['unit'],
            'division'      => $validated['division'],
            'priority'      => $validated['priority'],
            'title'         => $validated['title'],
            'description'   => $validated['description'],
            'status'        => 'Yet to Assigned',
        ]);

        return redirect()->route('asset-tickets.index')
            ->with('success', 'Ticket created successfully!');
    }




    /**
     * Display the specified resource.
     */
    public function show(AssetTicket $assetTicket)
    {
        return view('asset_tickets.show', compact('assetTicket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssetTicket $assetTicket)
    {

        $users=User::all();
        return view('asset_tickets.edit', compact('assetTicket',"users"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssetTicket $assetTicket)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'category_id' => 'required|numeric',
            'priority' => 'required|in:Very Urgent,Urgent,Very High,High,Medium,Low',
            'unit' => 'required|string',
            'division' => 'required|string',
        ]);

        $assetTicket->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'priority' => $request->priority,
            'unit' => $request->unit,
            'division' => $request->division,
        ]);

        return redirect()->route('asset-tickets.index')
            ->with('success', 'Ticket updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetTicket $assetTicket)
    {
        $assetTicket->delete();

        return redirect()->route('asset-tickets.index')
            ->with('success', 'Ticket deleted successfully!');
    }
}

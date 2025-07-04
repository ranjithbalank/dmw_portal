<?php

namespace App\Http\Controllers;

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
        // Show the create ticket form
        return view('asset_tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate form input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'category_id' => 'required|numeric',
            'priority' => 'required|in:Very Urgent,Urgent,Very High,High,Medium,Low',
            'unit' => 'required|string',
            'division' => 'required|string',
        ]);

        // Create the ticket
        AssetTicket::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'priority' => $request->priority,
            'unit' => $request->unit,
            'division' => $request->division,
            'created_by' => Auth::id() ?? 1, // use 1 if not using auth yet
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
        return view('asset_tickets.edit', compact('assetTicket'));
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

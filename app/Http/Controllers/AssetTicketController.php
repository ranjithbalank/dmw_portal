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
        return view('asset_tickets.create', compact('ticketNumber', 'users'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|numeric',
            'priority'    => 'required|in:Very Urgent,Urgent,Very High,High,Medium,Low',
            'unit'        => 'required|string|max:255',
            'division'    => 'required|string|max:255',
        ]);

        AssetTicket::create([
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'priority'    => $validated['priority'],
            'unit'        => $validated['unit'],
            'division'    => $validated['division'],
            'created_by'  => Auth::id(),
            'status'      => 'Yet to Assigned',
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

        $users = User::all();
        return view('asset_tickets.edit', compact('assetTicket', "users"));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, AssetTicket $assetTicket)
    // {
    //     $validated = $request->validate([
    //         'title'        => 'required|string|max:255',
    //         'description'  => 'required',
    //         'category_id'  => 'required|numeric',
    //         'priority'     => 'required|in:Very Urgent,Urgent,Very High,High,Medium,Low',
    //         'unit'         => 'required|string',
    //         'division'     => 'required|string',
    //         'assigned_to'  => 'nullable|exists:users,id',
    //     ]);

    //     $data = $validated;

    //     // If assigned_to is filled, update assignment fields
    //     if ($request->filled('assigned_to')) {
    //         $data['assigned_to'] = $request->assigned_to; // store current user id
    //         $data['assigned_on'] = now();
    //         $data['status'] = 'Assigned';
    //     }

    //     // Always update changed_by and changed_on
    //     $data['changed_by'] = Auth::id();
    //     $data['changed_on'] = now();

    //     $assetTicket->update($data);

    //     return redirect()->route('asset-tickets.index')
    //         ->with('success', 'Ticket updated successfully!');
    // }
    public function update(Request $request, AssetTicket $assetTicket)
    {
        // dd($request->all());
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required',
            'category_id'  => 'required|numeric',
            'priority'     => 'required|in:Very Urgent,Urgent,Very High,High,Medium,Low',
            'unit'         => 'required|string',
            'division'     => 'required|string',
            'assigned_to'  => 'nullable|exists:users,id',
            'status'       => 'nullable|string'
        ]);

        $data = $validated;

        // If first time assigning
        if ($request->filled('assigned_to') && empty($assetTicket->assigned_to)) {
            $data['assigned_by'] = Auth::user()->name;
            $data['assigned_on'] = now();
            $data['status'] = 'Assigned';
        }

        // Always accept status if filled
        if ($request->filled('status')) {
            $data['status'] = $request->status;

            // If new status is Closed → set closed_by & closed_on
            if ($request->status === 'Closed') {
                $data['closed_by'] = Auth::id();
                $data['closed_on'] = now();
                $data['closed_reason'] = $request->closed_reason;
            }
            // If status is Reopen → set reopen fields
            if ($request->status === 'Reopen') {
                $data['reopened_by'] = Auth::id();
                $data['reopened_on'] = now();
                $data['reopened_reason'] = $request->reopened_reason;
            }
        }

        // Track who changed
        $data['changed_by'] = Auth::id();
        $data['changed_on'] = now();

        $assetTicket->update($data);

        return redirect()->route('asset-tickets.index')->with('success', 'Ticket updated successfully!');
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

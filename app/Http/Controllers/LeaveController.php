<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $leaves = Leave::where('user_id', $user->id)->latest()->get();

        return view('leaves.index', compact('leaves', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $availableLeaves = $user->details->available_leaves ?? 0;

        return view('leaves.create', compact('availableLeaves'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|in:casual,sick,earned',
            'leave_duration' => 'required|in:Full Day,Half Day',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'leave_days' => 'required|numeric|min:0.5',
            'reason' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $details = $user->details;

        if ($details->available_leaves < $request->leave_days) {
            return back()->withInput()->with('error', 'Not enough leave balance.');
        }

        Leave::create([
            'user_id' => $user->id,
            'leave_type' => $request->leave_type,
            'leave_duration' => $request->leave_duration,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'leave_days' => $request->leave_days,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave request submitted.');
    }

    public function show(Leave $leave)
    {
        return view('leaves.view', compact('leave'));
    }

    public function edit(Leave $leave)
    {
        return view('leaves.edit', compact('leave'));
    }



    public function update(Request $request, Leave $leave)
    {
        $request->validate([
            'leave_type' => 'required|in:casual,sick,earned',
            'leave_duration' => 'required|in:Full Day,Half Day',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'leave_days' => 'required|numeric|min:0.5',
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $leave->update($request->all());

        return redirect()->route('leaves.index')->with('success', 'Leave updated.');
    }

    public function destroy(Leave $leave)
    {
        $leave->delete();
        return redirect()->route('leaves.index')->with('success', 'Leave deleted.');
    }

    public function approve($id)
    {
        $leave = Leave::findOrFail($id);

        if ($leave->status !== 'pending') {
            return back()->with('error', 'Leave already processed.');
        }

        $details = $leave->user->details;

        if ($details->available_leaves < $leave->leave_days) {
            return back()->with('error', 'Insufficient leave balance.');
        }

        $details->available_leaves -= $leave->leave_days;
        $details->save();

        $leave->status = 'approved';
        $leave->save();

        return back()->with('success', 'Leave approved and balance updated.');
    }

    public function reject($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->status = 'rejected';
        $leave->save();

        return back()->with('success', 'Leave rejected.');
    }
}

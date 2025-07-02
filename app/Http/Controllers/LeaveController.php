<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $view = $request->get('view', 'mine');

        // Pending count based on role
        $pendingCount = 0;
        if ($user->hasRole('Admin')) {
            $pendingCount = Leave::where('status', 'pending')->count();
        } elseif ($user->hasRole('Manager')) {
            $pendingCount = Leave::whereHas('user', fn($q) => $q->where('manager_id', $user->employee_id))
                ->where('status', 'pending')
                ->count();
        }

        if ($view === 'team' && $user->hasRole('HR')) {
            $allLeaves = Leave::with('user')->latest()->get();

            return view('leaves.index', [
                'leaves' => $allLeaves,
                'user' => $user,
                'view' => 'team',
                'pendingCount' => $pendingCount,
            ]);
        }

        // Admin: All Leaves
        if ($view === 'team' && $user->hasRole('Admin')) {
            $allLeaves = Leave::with('user')->latest()->get();

            return view('leaves.index', [
                'leaves' => $allLeaves,
                'user' => $user,
                'view' => 'team',
                'pendingCount' => $pendingCount,
            ]);
        }

        // Manager: Only team leaves
        if ($view === 'team' && $user->hasRole('Manager')) {
            $teamLeaves = Leave::with('user')
                ->whereHas('user', fn($q) => $q->where('manager_id', $user->employee_id))
                ->latest()
                ->get();

            return view('leaves.index', [
                'leaves' => $teamLeaves,
                'user' => $user,
                'view' => 'team',
                'pendingCount' => $pendingCount,
            ]);
        }

        // My leaves
        $myLeaves = Leave::where('user_id', $user->id)->latest()->get();
        return view('leaves.index', [
            'leaves' => $myLeaves,
            'user' => $user,
            'view' => 'mine',
            'pendingCount' => $pendingCount,
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        // LeaveController@create or wherever you load the form
        $minDate = now()->addDays(7)->toDateString();
        $availableLeaves = $user->leave_balance ?? 0;

        return view('leaves.create', compact('availableLeaves', 'minDate'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();

        $rules = [
            // 'leave_type' => 'required|in:casual,sick,earned,comp-off,od,permission',
            // 'leave_duration' => 'required|in:Full Day,Half Day',
            'leave_days' => 'required|numeric|min:0.5',
            'reason' => 'required|string|max:1000',
        ];

        if ($request->leave_type === 'comp-off') {
            $rules['comp_off_worked_date'] = 'required|date';
            $rules['comp_off_leave_date'] = 'required|date|after_or_equal:comp_off_worked_date';
        } else {
            $rules['from_date'] = 'required|date';
            $rules['to_date'] = 'required|date|after_or_equal:from_date';
        }

        $validated = $request->validate($rules);

        // ✅ Check leave balance (not for comp-off)
        if ($request->leave_type !== 'comp-off' && $user->leave_balance < $request->leave_days) {
            return back()->withInput()->with('error', 'Not enough leave balance.');
        }

        // ✅ Check if leave date(s) clash with holidays (only for non comp-off)
        if ($request->leave_type !== 'comp-off') {
            $holidayExists = \App\Models\Holiday::whereBetween('date', [$request->from_date, $request->to_date])->exists();
            if ($holidayExists) {
                return back()->withInput()->withErrors(['from_date' => 'Selected date(s) include holiday. Please choose another date.']);
            }
        } else {
            // For comp-off, check comp_off_leave_date itself is not a holiday
            $isHoliday = \App\Models\Holiday::where('date', $request->comp_off_leave_date)->exists();
            if ($isHoliday) {
                return back()->withInput()->withErrors(['comp_off_leave_date' => 'Comp-off leave date is a holiday. Please choose another date.']);
            }
        }

        // ✅ Save leave
        $leave = new Leave();
        $leave->user_id = $user->id;
        $leave->leave_type = $request->leave_type ?? 'N/A';
        $leave->leave_duration = $request->leave_duration ?? 'N/A';
        $leave->from_date = $request->from_date;
        $leave->to_date = $request->to_date;
        $leave->comp_off_worked_date = $request->comp_off_worked_date;
        $leave->comp_off_leave_date = $request->comp_off_leave_date;
        $leave->leave_days = $request->leave_days;
        $leave->reason = $request->reason;
        $leave->status = 'pending';
        $leave->save();

        // ✅ Deduct leave balance (not for comp-off)
        if ($request->leave_type !== 'comp-off') {
            $user->leave_balance -= $request->leave_days;
            $user->save();
        }

        return redirect()->route('leaves.index')->with('success', 'Leave request submitted.');
    }


    public function show(Leave $leave)
    {
        $user = Auth::user();
        return view('leaves.view', compact('leave', 'user'));
    }

    public function edit(Leave $leave)
    {
        $user = Auth::user();
        $availableLeaves = $user->leave_balance ?? 0;
        return view('leaves.edit', compact('leave', 'availableLeaves'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $leave = Leave::findOrFail($id);

        // Prevent editing if already approved/rejected
        if (in_array($leave->status, ['approved', 'rejected'])) {
            return redirect()->back()->with('error', 'Cannot update an already processed leave request.');
        }

        // Validate form input
        $request->validate([
            'leave_type' => 'required|in:casual,sick,earned,comp-off',
            'leave_duration' => 'required|in:Full Day,Half Day',
            'leave_days' => 'required|numeric|min:0.5',
            'reason' => 'required|string|max:1000',
            'from_date' => 'nullable|date|required_unless:leave_type,comp-off',
            'to_date' => 'nullable|date|after_or_equal:from_date|required_unless:leave_type,comp-off',
            'comp_off_worked_date' => 'nullable|date|required_if:leave_type,comp-off',
            'comp_off_leave_date' => 'nullable|date|required_if:leave_type,comp-off',
        ]);

        $newLeaveDays = $request->leave_days;
        $oldLeaveDays = $leave->leave_days;

        // Update leave balance in users table (for non-comp-off only)
        if ($leave->leave_type !== 'comp-off') {
            $difference = $newLeaveDays - $oldLeaveDays;

            if ($difference > 0) {
                // Need more leave days
                if ($user->leave_balance < $difference) {
                    return back()->withInput()->with('error', 'Not enough leave balance to increase leave days.');
                }
                $user->leave_balance -= $difference;
            } elseif ($difference < 0) {
                // Restore unused leave days
                $user->leave_balance += abs($difference);
            }

            $user->save(); // 👈 Save updated leave_balance in users table
        }

        // Update leave record
        $leave->leave_type = $request->leave_type;
        $leave->leave_duration = $request->leave_duration;
        $leave->leave_days = $newLeaveDays;
        $leave->reason = $request->reason;

        if ($request->leave_type === 'comp-off') {
            $leave->comp_off_worked_date = $request->comp_off_worked_date;
            $leave->comp_off_leave_date = $request->comp_off_leave_date;
            $leave->from_date = null;
            $leave->to_date = null;
        } else {
            $leave->from_date = $request->from_date;
            $leave->to_date = $request->to_date;
            $leave->comp_off_worked_date = null;
            $leave->comp_off_leave_date = null;
        }

        $leave->status = $request->status; // Reset status to pending or keep existing
        $leave->save();

        return redirect()->route('leaves.index')->with('success', 'Leave request updated and balance adjusted.');
    }


    public function destroy(Leave $leave)
    {
        $leave->delete();
        return redirect()->route('leaves.index')->with('success', 'Leave deleted.');
    }

    public function approve($id)
    {
        $user = Auth::user(); // get the currently logged-in user
        $leave = Leave::findOrFail($id);
        if ($user->employee_id === optional($leave->user)->manager_id) {
            $leave->status = 'approved';
            $leave->save();
            return back()->with('success', 'Leave approved successfully.');
        }
        return back()->with('error', 'Unauthorized approval attempt.');
    }

    public function reject($id)
    {
        $leave = Leave::findOrFail($id);

        // Only allow the manager of the employee to reject
        $managerEmployeeId = Auth::user()->employee_id;
        if ($leave->user->manager_id != $managerEmployeeId) {
            return back()->with('error', 'You are not authorized to reject this leave.');
        }

        // Check if already rejected or approved
        if (in_array($leave->status, ['approved', 'rejected'])) {
            return back()->with('info', 'This leave has already been processed.');
        }

        // Revert leave balance only for non-comp-off types
        if ($leave->leave_type !== 'comp-off') {
            $leave->user->leave_balance += $leave->leave_days;
            $leave->user->save();
        }

        $leave->status = 'rejected';
        $leave->save();

        return back()->with('success', 'Leave request rejected and balance reverted.');
    }

    // public function managerApprove(Request $request, Leave $leave)
    // {
    //     $request->validate(['comment' => 'required|string|max:1000']);

    //     if (AUTH::user()->employee_id !== optional($leave->user)->manager_id) {
    //         return back()->with('error', 'Unauthorized.');
    //     }

    //     if ($leave->status !== 'pending') {
    //         return back()->with('info', 'This leave has already been processed.');
    //     }

    //     $leave->status = 'supervisor/ manager approved';
    //     $leave->approver_1 = Auth::user()->id;
    //     $leave->approver_1_comments = $request->comment;
    //     $leave->approver_1_approved_at = now();
    //     $leave->save();

    //     return back()->with('success', 'Leave approved successfully.');
    // }

    // public function managerReject(Request $request, Leave $leave)
    // {
    //     $request->validate(['comment' => 'required|string|max:1000']);

    //     if (Auth::user()->employee_id !== optional($leave->user)->manager_id) {
    //         return back()->with('error', 'Unauthorized.');
    //     }

    //     if ($leave->status !== 'pending') {
    //         return back()->with('info', 'This leave has already been processed.');
    //     }

    //     // Revert leave balance if not comp-off
    //     if ($leave->leave_type !== 'comp-off') {
    //         $leave->user->leave_balance += $leave->leave_days;
    //         $leave->user->save();
    //     }

    //     $leave->status = 'supervisor/ manager rejected';
    //     $leave->approver_1_comments = $request->comment;
    //     $leave->approver_1_approved_at = now();
    //     $leave->save();

    //     return back()->with('success', 'Leave rejected and balance reverted.');
    // }

    // public function hrApprove(Request $request, Leave $leave)
    // {
    //     $request->validate(['comment' => 'required|string|max:1000']);

    //     if (!Auth::user()->hasRole('HR')) {
    //         return back()->with('error', 'Unauthorized.');
    //     }

    //     if ($leave->status !== 'supervisor/ manager approved') {
    //         return back()->with('info', 'Leave must be manager approved first.');
    //     }

    //     $leave->status = 'hr approved';
    //     $leave->approver_2_comments = $request->comment;
    //     $leave->approver_2_approved_at = now();
    //     $leave->save();

    //     return back()->with('success', 'Leave approved by HR.');
    // }

    // public function hrReject(Request $request, Leave $leave)
    // {
    //     $request->validate(['comment' => 'required|string|max:1000']);

    //     if (!Auth::user()->hasRole('HR')) {
    //         return back()->with('error', 'Unauthorized.');
    //     }

    //     if ($leave->status !== 'supervisor/ manager approved') {
    //         return back()->with('info', 'Leave must be manager approved first.');
    //     }

    //     // Revert leave balance if not comp-off
    //     if ($leave->leave_type !== 'comp-off') {
    //         $leave->user->leave_balance += $leave->leave_days;
    //         $leave->user->save();
    //     }

    //     $leave->status = 'hr rejected';
    //     $leave->approver_2_comments = $request->comment;
    //     $leave->approver_2_approved_at = now();
    //     $leave->save();

    //     return back()->with('success', 'Leave rejected by HR and balance reverted.');
    // }

    // MANAGER decision (approve or reject)
    public function managerDecision(Request $request, Leave $leave)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'action'  => 'required|in:approve,reject',
        ]);

        if (Auth::user()->employee_id !== optional($leave->user)->manager_id) {
            return back()->with('error', 'Unauthorized.');
        }

        if ($leave->status !== 'pending') {
            return back()->with('info', 'This leave has already been processed.');
        }

        if ($request->action === 'approve') {
            $leave->status = 'supervisor/ manager approved';
        } else {
            $leave->status = 'supervisor/ manager rejected';
            // Revert leave balance if not comp-off
            if ($leave->leave_type !== 'comp-off') {
                $leave->user->leave_balance += $leave->leave_days;
                $leave->user->save();
            }
        }

        $leave->approver_1 = Auth::user()->employee_id;
        $leave->approver_1_comments = $request->comment;
        $leave->approver_1_approved_at = now();
        $leave->save();

        return back()->with('success', 'Leave ' . $request->action . 'd successfully by Manager.');
    }

    // HR decision (approve or reject)
    public function hrDecision(Request $request, Leave $leave)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'action'  => 'required|in:approve,reject',
        ]);

        if (!Auth::user()->hasRole('HR')) {
            return back()->with('error', 'Unauthorized.');
        }

        if ($leave->status !== 'supervisor/ manager approved') {
            return back()->with('info', 'Leave must be manager approved first.');
        }

        if ($request->action === 'approve') {
            $leave->status = 'hr approved';
        } else {
            $leave->status = 'hr rejected';
            // Revert leave balance if not comp-off
            if ($leave->leave_type !== 'comp-off') {
                $leave->user->leave_balance += $leave->leave_days;
                $leave->user->save();
            }
        }

        $leave->approver_2 = Auth::user()->employee_id;
        $leave->approver_2_comments = $request->comment;
        $leave->approver_2_approved_at = now();
        $leave->leave_type = $request->leave_type;
        $leave->save();

        return back()->with('success', 'Leave ' . $request->action . 'd successfully by HR.');
    }
}

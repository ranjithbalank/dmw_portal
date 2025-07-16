<?php

namespace App\Exports;

use App\Models\Leave;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeavesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
   public function collection()
    {
        return Leave::with(['user','approver1','approver2'])  // eager load user
            ->select('id', 'user_id', 'leave_type', 'from_date', 'to_date', 'leave_days', 'status', 'created_at', 'approver_1', 'approver_2')
            ->get()
            ->map(function($leave) {
                return [
                    'ID' => $leave->id,
                    'Employee' => optional($leave->user)->name,
                    'Leave Type' => ucfirst($leave->leave_type),
                    'From Date' => \Carbon\Carbon::parse($leave->from_date)->format('d-m-Y'),
                    'To Date' => \Carbon\Carbon::parse($leave->to_date)->format('d-m-Y'),
                    'Days' => $leave->leave_days,
                    'Status' => strtoupper($leave->status),
                    'Applied On' => $leave->created_at->format('d-m-Y H:i'),
                    "Approver_1" => optional($leave->approver1)->name,
                    "Approver_2" => optional($leave->approver2)->name,
                ];
            });
    }

    public function headings(): array
    {
        return ['ID', 'Employee', 'Leave Type', 'From Date', 'To Date', 'Days', 'Status', 'Applied On','Approver_1','Approver_2'];
    }
}

<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Leave;
use App\Exports\LeavesExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LeaveExportController extends Controller
{
    public function exportExcel()
    {
        if (!Auth::user()->hasAnyRole(['Admin', 'HR'])) {
            abort(403, 'Unauthorized');
        }
        return Excel::download(new LeavesExport, 'leaves.xlsx');
    }

    public function exportPDF()
    {
        if (!Auth::user()->hasAnyRole(['Admin', 'HR'])) {
            abort(403, 'Unauthorized');
        }

        $leaves = Leave::with('user')->orderByDesc('created_at')->get();

        $pdf = PDF::loadView('leaves.export', compact('leaves'))->setPaper('a4', 'landscape');

        return $pdf->download('leaves.pdf');
    }
}

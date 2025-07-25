<?php

namespace App\Exports;

use App\Models\InternalJobApplications;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JobApplicantsExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return InternalJobApplications::with('job', 'user')->get()->map(function ($application) {
            return [
                'IJP ID'     => 'IJP - ' . ($application->job->id ?? ''),
                "Release Date" => $application->job->passing_date ?? '',
                "End Date" => $application->job->end_date ?? '',
                "Unit" => $application->job->unit ?? '',
                'Job Title'  => $application->job->job_title ?? '',
                'Applicant_id' => $application->user->id ?? '',
                'Applicant'  => $application->user->name ?? '',
                'Email'      => $application->user->email ?? '',
                'Status'     => $application->status ?? 'Pending',
                'Qualifications' => $application->emp_qualifications ?? '',
                'Experience' => $application->emp_experience ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'IJP ID','Release Date','End Date','Unit','Job Title','Applicant_id','Applicant', 'Email', 'Status',
            'Qualifications', 'Experience','New/ Replacement','Interview panel','Date of interview',
            'Interview result', 'Communication regarding result','Communication regarding movement',
            'Salary increase (if any)','Date of joining in new role','Required position'
        ];
    }

    // 🔥 This makes the heading row bold
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // First row (headings)
        ];
    }
}

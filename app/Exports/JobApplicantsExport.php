<?php

namespace App\Exports;

use App\Models\InternalJobApplications;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JobApplicantsExport implements FromCollection, WithHeadings, WithStyles
{
    protected $jobId;

    public function __construct($jobId = null)
    {
        $this->jobId = $jobId;
        // dd($this->jobId);
    }

    public function collection()
    {
        return InternalJobApplications::with('job', 'user')
            ->when($this->jobId, fn($query) => $query->where('job_id', $this->jobId))
            ->get()
            ->filter(fn($application) => !in_array(strtolower($application->status), ['selected', 'rejected']))
            ->map(function ($application) {
                return [
                    'IJP ID' => 'IJP - ' . ($application->job->id ?? ''),
                    'Release Date' => $application->job->passing_date ?? '',
                    'End Date' => $application->job->end_date ?? '',
                    'Unit' => $application->job->unit ?? '',
                    'Job Title' => $application->job->job_title ?? '',
                    'Applicant ID' => $application->user->id ?? '',
                    'Applicant' => $application->user->name ?? '',
                    'Email' => $application->user->email ?? '',
                    'Status' => $application->status ?? 'Pending',
                    'Qualifications' => $application->emp_qualifications ?? '',
                    'Experience' => $application->emp_experience ?? '',
                    'New/ Replacement' => '',
                    'Interview panel' => '',
                    'Date of interview' => '',
                    'Interview result' => '',
                    'Communication regarding result' => '',
                    'Communication regarding movement' => '',
                    'Salary increase (if any)' => '',
                    'Date of joining in new role' => '',
                    'Required position' => '',
                ];
            });
    }


    public function headings(): array
    {
        return [
            'IJP ID', 'Release Date', 'End Date', 'Unit', 'Job Title',
            'Applicant ID', 'Applicant', 'Email', 'Status',
            'Qualifications', 'Experience', 'New/ Replacement',
            'Interview panel', 'Date of interview', 'Interview result',
            'Communication regarding result', 'Communication regarding movement',
            'Salary increase (if any)', 'Date of joining in new role', 'Required position'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

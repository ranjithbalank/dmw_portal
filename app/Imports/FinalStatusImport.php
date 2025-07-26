<?php
namespace App\Imports;
use App\Models\FinalJobStatus;
use Illuminate\Support\Facades\Log;
use App\Models\InternalJobApplications;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FinalStatusImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // ✅ Extract and sanitize job ID
        preg_match('/\d+/', $row['ijp_id'], $matches);
        $ijpId = isset($matches[0]) ? (int)$matches[0] : null;

        if (!$ijpId) {
            Log::warning('❌ Invalid IJP ID in Excel row', $row);
            return null;
        }

        // ✅ Sanitize applicant ID
        $employeeId = (int) trim($row['applicant_id']);
        // dd([$ijpId,$employeeId]);
        // ✅ Update internal_job_applications
        $application = \App\Models\InternalJobApplications::where('job_id', $ijpId)
            ->where('employee_id', $employeeId)
            ->first();

        if ($application) {
            $application->status = $row['status'] ?? 'Pending';
            $application->save();

            Log::info("✅ Updated application for job_id=$ijpId, employee_id=$employeeId, status={$application->status}");
        } else {
                Log::warning("🚫 No match in internal_job_applications for job_id=$ijpId and employee_id=$employeeId");
        }

        // ✅ Prevent duplicate entry in final_job_statuses
        $exists = \App\Models\FinalJobStatus::where('ijp_id', $ijpId)
            ->where('applicant_id', $employeeId)
            ->exists();

        if ($exists) {
            Log::info("⚠️ Skipping duplicate FinalJobStatus for job_id=$ijpId, employee_id=$employeeId");
            return null;
        }

        // ✅ Create FinalJobStatus record
        return new \App\Models\FinalJobStatus([
            'ijp_id' => $ijpId,
            'release_date' => $this->transformDate($row['release_date']),
            'end_date' => $this->transformDate($row['end_date']),
            'unit' => $row['unit'],
            'job_title' => $row['job_title'],
            'applicant_id'=> $employeeId,
            'applicant' => $row['applicant'],
            'email' => $row['email'],
            'status' => $row['status'],
            'qualifications' => $row['qualifications'],
            'experience' => $row['experience'],
            'new_or_replacement' => $row['new_replacement'],
            'interview_panel' => $row['interview_panel'],
            'interview_date' => $this->excelDate($row['date_of_interview']),
            'interview_result' => $row['interview_result'],
            'communication_result' => $row['communication_regarding_result'],
            'communication_movement' => $row['communication_regarding_movement'],
            'salary_increase' => $row['salary_increase_if_any'],
            'joining_date' => $this->excelDate($row['date_of_joining_in_new_role']),
            'required_position' => $row['required_position'],
        ]);
    }
    // Convert Excel numeric date to Carbon
    private function excelDate($excelDate)
    {
        return is_numeric($excelDate)
            ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate)
            : $excelDate;
    }

    // Transform normal Y-m-d date if needed
    private function transformDate($date)
    {
        return \Carbon\Carbon::parse($date);
    }
}

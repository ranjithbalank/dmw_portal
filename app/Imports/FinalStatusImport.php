<?php
namespace App\Imports;
use App\Models\FinalJobStatus;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class FinalStatusImport implements ToModel, WithHeadingRow
{
    // public function model(array $row)
    // {
    //     dd($row);
    //     return new FinalJobStatus([
    //         'ijp_id' => $row['ijp id'] ?? null,
    //         'release_date' => isset($row['release date']) ? Date::excelToDateTimeObject($row['release date']) : null,
    //         'end_date' => isset($row['end date']) ? Date::excelToDateTimeObject($row['end date']) : null,
    //         'unit' => $row['unit'] ?? null,
    //         'job_title' => $row['job title'] ?? null,
    //         'applicant' => $row['applicant'] ?? null,
    //         'email' => $row['email'] ?? null,
    //         'status' => $row['status'] ?? null,
    //         'qualifications' => $row['qualifications'] ?? null,
    //         'experience' => $row['experience'] ?? null,
    //         'new_or_replacement' => $row['new/ replacement'] ?? null,
    //         'interview_panel' => $row['interview panel'] ?? null,
    //         'interview_date' => isset($row['date of interview']) ? Date::excelToDateTimeObject($row['date of interview']) : null,
    //         'interview_result' => $row['interview result'] ?? null,
    //         'communication_result' => $row['communication regarding result'] ?? null,
    //         'communication_movement' => $row['communication regarding movement'] ?? null,
    //         'salary_increase' => $row['salary increase (if any)'] ?? null,
    //         'joining_date' => isset($row['date of joining in new role']) ? Date::excelToDateTimeObject($row['date of joining in new role']) : null,
    //         'required_position' => $row['required position'] ?? null,
    //     ]);
    // }
    public function model(array $row)
{
    // Extract integer from "IJP - 1"
    preg_match('/\d+/', $row['ijp_id'], $matches);
    $ijpId = $matches[0] ?? null;

    // If no valid ID found, skip
    if (!$ijpId) {
        return null;
    }

    return new FinalJobStatus([
        'ijp_id' => $ijpId, // Must be integer
        'release_date' => $this->transformDate($row['release_date']),
        'end_date' => $this->transformDate($row['end_date']),
        'unit' => $row['unit'],
        'job_title' => $row['job_title'],
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

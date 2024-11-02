<?php

namespace App\Exports;

use App\Models\DefenseEnrollment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DefenseResultsExport implements FromCollection, WithHeadings, WithMapping
{
    // Define the headings of the Excel file
    public function headings(): array
    {
        return [
            'Defense Enrollment ID','Generation', 'Student Name', 'Advisor Name', 'Internship Title', 
            'School', 'Internship Type', 'Company Name', 'Internship Project', 'Jury 1 (Score)', 'Jury 2 (Score)', 
            'Jury 3 (Score)', 'Jury 4 (Score)', 'Total Score','Defene Status'
        ];
    }

    // Map the data according to the format of your view
    public function map($defenseEnrollment): array
    {
        // Calculate total score
        $totalScore = $defenseEnrollment->evaluations->sum('score');

        // Format the data for each row in Excel
        return [
            $defenseEnrollment->id,
            $defenseEnrollment->defenseRequest->thesisDocument->student_request->internship->generation,
            $defenseEnrollment->defenseRequest->thesisDocument->student_request->student->name,
            $defenseEnrollment->defenseRequest->thesisDocument->student_request->advisor->name,
            $defenseEnrollment->defenseRequest->thesisDocument->student_request->internship->internship_title,
            $defenseEnrollment->defenseRequest->thesisDocument->student_request->internship->school,
            $defenseEnrollment->defenseRequest->thesisDocument->student_request->internship->type,
            $defenseEnrollment->defenseRequest->thesisDocument->student_request->submissionForm->company->company_name ?? 'N/A',
            $defenseEnrollment->defenseRequest->thesisDocument->student_request->internshipProject->project_name ?? 'N/A',
            $defenseEnrollment->juryGroup->jury1->name . ' (' . $defenseEnrollment->evaluations->where('user_jury_id', $defenseEnrollment->juryGroup->user_jury1_id)->sum('score') . ')',
            $defenseEnrollment->juryGroup->jury2->name . ' (' . $defenseEnrollment->evaluations->where('user_jury_id', $defenseEnrollment->juryGroup->user_jury2_id)->sum('score') . ')',
            $defenseEnrollment->juryGroup->jury3->name . ' (' . $defenseEnrollment->evaluations->where('user_jury_id', $defenseEnrollment->juryGroup->user_jury3_id)->sum('score') . ')',
            $defenseEnrollment->juryGroup->jury4->name . ' (' . $defenseEnrollment->evaluations->where('user_jury_id', $defenseEnrollment->juryGroup->user_jury4_id)->sum('score') . ')',
            $totalScore,
            $defenseEnrollment->status
        ];
    }

    // Define the collection method to fetch data from the database
    public function collection()
    {
        return DefenseEnrollment::with([
            'defenseRequest.thesisDocument.student_request.student',
            'defenseRequest.thesisDocument.student_request.advisor',
            'defenseRequest.thesisDocument.student_request.internship',
            'defenseRequest.thesisDocument.student_request.submissionForm.company', 
            'defenseRequest.thesisDocument.student_request.internshipProject',
            'juryGroup.jury1', 'juryGroup.jury2', 'juryGroup.jury3', 'juryGroup.jury4',
            'evaluations'
        ])->get();
    }
}
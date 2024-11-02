<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DefenseEnrollment;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentRequest;
use App\Exports\DefenseResultsExport;
use Maatwebsite\Excel\Facades\Excel;

class DefenseResultsController extends Controller
{
    public function index()
    {
        $defenseEnrollments = DefenseEnrollment::with([
            'defenseRequest.thesisDocument.student_request.student',
            'defenseRequest.thesisDocument.student_request.internship',
            'defenseRequest.thesisDocument.student_request.submissionForm.company', 
            'defenseRequest.thesisDocument.student_request.internshipProject', 
            'juryGroup.jury1', 'juryGroup.jury2', 'juryGroup.jury3', 'juryGroup.jury4',
            'evaluations'
        ])->get();

        return view('back_end.preference.defense_result.index', compact('defenseEnrollments'));
    }

    public function juryResults()
    {
        $currentJury = Auth::user();
        $currentJuryName = Auth::user()->name;

        $juryGroups = DefenseEnrollment::with([
            'defenseRequest.thesisDocument.student_request.student',
            'defenseRequest.thesisDocument.student_request.internship',
            'defenseRequest.thesisDocument.student_request.submissionForm.company', 
            'defenseRequest.thesisDocument.student_request.internshipProject',
            'juryGroup.jury1', 'juryGroup.jury2', 'juryGroup.jury3', 'juryGroup.jury4',
            'evaluations'
        ])->whereHas('juryGroup', function ($query) use ($currentJury) {
            $query->where('user_jury1_id', $currentJury->id)
                ->orWhere('user_jury2_id', $currentJury->id)
                ->orWhere('user_jury3_id', $currentJury->id)
                ->orWhere('user_jury4_id', $currentJury->id);
        })->get();

        return view('back_end.preference.defense_result.jury', compact('juryGroups', 'currentJuryName'));
    }

    public function studentResults()
    {
        $currentUser = Auth::user();

        $defenseEnrollments = DefenseEnrollment::with([
            'defenseRequest.thesisDocument.student_request.student',
            'defenseRequest.thesisDocument.student_request.internship',
            'defenseRequest.thesisDocument.student_request.submissionForm.company', 
            'defenseRequest.thesisDocument.student_request.internshipProject',
            'juryGroup.jury1', 'juryGroup.jury2', 'juryGroup.jury3', 'juryGroup.jury4',
            'evaluations'
        ])->whereHas('defenseRequest.thesisDocument.student_request', function ($query) use ($currentUser) {
            $query->where('student_id', $currentUser->id);
        })->get();

        return view('back_end.preference.defense_result.student', compact('defenseEnrollments'));
    }

    public function advisorResults()
    {
        $currentUser = Auth::user();

        $defenseEnrollments = DefenseEnrollment::with([
            'defenseRequest.thesisDocument.student_request.student',
            'defenseRequest.thesisDocument.student_request.internship',
            'defenseRequest.thesisDocument.student_request.submissionForm.company', 
            'defenseRequest.thesisDocument.student_request.internshipProject',
            'juryGroup.jury1', 'juryGroup.jury2', 'juryGroup.jury3', 'juryGroup.jury4',
            'evaluations'
        ])->whereHas('defenseRequest.thesisDocument.student_request', function ($query) use ($currentUser) {
            $query->where('advisor_id', $currentUser->id);
        })->get();

        return view('back_end.preference.defense_result.advisor', compact('defenseEnrollments'));
    }

    public function export()
    {
        return Excel::download(new DefenseResultsExport, 'defense_results.xlsx');
    }

}
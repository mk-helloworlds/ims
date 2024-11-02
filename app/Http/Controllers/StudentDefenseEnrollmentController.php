<?php

namespace App\Http\Controllers;

use App\Models\DefenseEnrollment;
use App\Http\Requests\StoreDefenseEnrollmentRequest;
use App\Http\Requests\UpdateDefenseEnrollmentRequest;
use App\Models\User;
use App\Models\Internship;
use App\Models\Company;
use App\Models\InternshipAdvisorStudent;
use App\Models\Category;
use App\Models\JuryGroup;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentRequest;
use App\Models\ThesisDocument;
use App\Models\DefenseRequest;
use Illuminate\Http\Request;

class StudentDefenseEnrollmentController extends Controller
{
    public function index()
    {
        // Get the authenticated student
    $currentStudent = Auth::user();

    // Filter the defense enrollments by the current student's ID
    // Assuming the DefenseEnrollment model is related to the StudentRequest model, which links to the User (student)
    $results = DefenseEnrollment::whereHas('defenseRequest.thesisDocument.student_request', function($query) use ($currentStudent) {
        // Filter by the current student's ID
        $query->where('student_id', $currentStudent->id);
    })->paginate(10); // You can adjust the pagination as needed

    // Pass the filtered results to the view
    return view('back_end.preference.student.defense_enrollment.index', compact('results', 'currentStudent'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}

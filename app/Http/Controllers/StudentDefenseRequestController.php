<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DefenseRequest;
use App\Http\Requests\StoreDefenseRequestRequest;
use App\Http\Requests\UpdateDefenseRequestRequest;
use App\Models\User;
use App\Models\Internship;
use App\Models\Company;
use App\Models\InternshipAdvisorStudent;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentRequest;
use App\Models\ThesisDocument;

class StudentDefenseRequestController extends Controller
{

    public function index()
    {
        $results = DefenseRequest::paginate(10);

        $currentStudent = Auth::user();

        $results = DefenseRequest::whereHas('thesisDocument.student_request' ,function($q) use ($currentStudent){
            $q->where('student_id',$currentStudent->id);
        })->paginate(10);

        return view('back_end.preference.student.defense_request.index', compact('results'));
    }

    public function create()
    {
        $currentStudent = Auth::user();

        $advisors = User::whereHas('studentRequests', function($query) use ($currentStudent) {
            $query->where('student_id', $currentStudent->id)->where('status', 'accepted');
        })->get();

        $internships = Internship::whereHas('studentRequests', function($query) use ($currentStudent) {
            $query->where('student_id', $currentStudent->id)->where('status', 'accepted');
        })->get();

        $students = User::whereHas('role', function($query) {
            $query->where('role_name', 'student');
        })->get();

        // $advisors = User::whereHas('role', function($query) {
        //     $query->where('role_name', 'advisor');
        // })->get();

        $companies = Company::get();
        $categories = Category::get(); 

        $student_requests = StudentRequest::where('status', 'accepted')->get();

        $data = array(
            'students' => $students,
            'advisors' =>$advisors,
            'companies' => $companies,
            'internships' => $internships,
            'categories' => $categories,
            'currentStudent' => $currentStudent,
            'student_requests' => $student_requests,
        );

        return view('back_end.preference.student.defense_request.create')->with($data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_student_id' => 'required|exists:users,id',
            'user_advisor_id' => 'required|exists:users,id',
            'internship_id' => 'required|exists:internships,id',
            'status' => 'required|in:pending,approved,rejected',
            'feedback' => 'nullable|string', 
        ]);

        $studentRequest = StudentRequest::where('student_id', $validatedData['user_student_id'])
            ->where('advisor_id', $validatedData['user_advisor_id'])
            ->where('internship_id', $validatedData['internship_id'])
            ->where('status', 'accepted')  // Ensure it's accepted
            ->first();

        if (!$studentRequest) {
            return back()->withErrors('The selected student, advisor, and internship combination status is not "accepted". Please check the Advisor Selection Part.');
        }

        $studentName = User::find($validatedData['user_student_id'])->name;

        $thesisDocument = ThesisDocument::where('student_request_id', $studentRequest->id)->first();

        if (!$thesisDocument) {
            return back()->withErrors('No thesis document found for the selected student request.');
        }
        
        DefenseRequest::create([
            'thesis_document_id' => $thesisDocument->id,
            'status' => $validatedData['status'],
        ]);

        return redirect()->route('student_defense_request.index')->with('success', 'Defense Request created successfully.');
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

<?php

namespace App\Http\Controllers;

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

class DefenseRequestController extends Controller
{
    public function index()
    {
        $results = DefenseRequest::paginate(10);

        return view('back_end.preference.defense_request.index')->with(['results' => $results]);
    }

    public function create()
    {
        $students = User::whereHas('role', function($query) {
            $query->where('role_name', 'student');
        })->get();

        $advisors = User::whereHas('role', function($query) {
            $query->where('role_name', 'advisor');
        })->get();

        $internships = Internship::get();
        $companies = Company::get();
        $categories = Category::get(); 
        $currentStudent = Auth::user(); 

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

        return view('back_end.preference.defense_request.create')->with($data);
    }

    public function store(StoreDefenseRequestRequest $request)
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
            'feedback' => $validatedData['feedback'],
        ]);

        return redirect()->route('admin_defense_request.index')->with('success', 'Defense Request created successfully.');
    }


    public function show(DefenseRequest $defenseRequest)
    {
        //
    }


    public function edit(DefenseRequest $admin_defense_request)
    {

        $students = User::whereHas('role', function($query) {
            $query->where('role_name', 'student');
        })->get();

        $advisors = User::whereHas('role', function($query) {
            $query->where('role_name', 'advisor');
        })->get();

        $internships = Internship::get();
        $companies = Company::get();
        $categories = Category::get(); 
        $currentStudent = Auth::user(); 

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

        return view('back_end.preference.defense_request.edit',compact('admin_defense_request'))->with($data);
    }

  
    public function update(UpdateDefenseRequestRequest $request, DefenseRequest $admin_defense_request)
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
        
        $admin_defense_request->update([
            'thesis_document_id' => $thesisDocument->id,
            'status' => $validatedData['status'],
            'feedback' => $validatedData['feedback'],
        ]);

        return redirect()->route('admin_defense_request.index')->with('success', 'Defense Request updated successfully.');
    }

 
    public function destroy(DefenseRequest $admin_defense_request)
    {
        $admin_defense_request->delete();

        return redirect()->route('admin_defense_request.index')->with('success','Admin Defense Deleted successfully');
    }
}

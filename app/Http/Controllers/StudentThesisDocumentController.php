<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentRequest;
use App\Models\ThesisDocument;
use Illuminate\Support\Facades\Auth;
use App\Models\Internship;
use App\Models\InternshipAdvisorStudent;
use App\Models\Company;
use App\Models\Category;
use App\Models\User;

class StudentThesisDocumentController extends Controller
{

    public function index()
    {
        // $results = StudentRequest::with('thesisDocuments')->where('student_id', Auth::id())->where('status', 'Accepted')->paginate(10);
 
        // $results = ThesisDocument::paginate(10);

        $results = ThesisDocument::whereHas('student_request', function ($query) {
            $query->where('student_id', Auth::id());
        })->paginate(10);

        // dd($results);
        return view('back_end.preference.student.thesis_document.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentStudent = Auth::user();

        // Fetch all advisors that have a student request for the current student
        $advisors = User::whereHas('studentRequests', function($query) use ($currentStudent) {
            $query->where('student_id', $currentStudent->id)->where('status', 'accepted');
        })->get();

        // dd($advisors);

        // Fetch all internships associated with the current student through student_request
        $internships = Internship::whereHas('studentRequests', function($query) use ($currentStudent) {
            $query->where('student_id', $currentStudent->id)->where('status', 'accepted');
        })->get();

        // dd($internships);

        $students = User::whereHas('role', function($query) {
            $query->where('role_name', 'student');
        })->get();
        
        
        // $advisors = User::whereHas('role', function($query) {
        //     $query->where('role_name', 'advisor');
        // })->get();

        // $internships = Internship::get();
        $companies = Company::get();
        $categories = Category::get(); 
        // $currentStudent = Auth::user(); 

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

        return view('back_end.preference.student.thesis_document.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_student_id' => 'required|exists:users,id',
            'user_advisor_id' => 'required|exists:users,id',
            'internship_id' => 'required|exists:internships,id',
            'student_thesis' => 'required|file|mimes:pdf,docx|max:10240', // Max size: 10MB
            'status' => 'required|in:submitted,accepted,rejected',
        ]);

        // SHOULD NOT CHECK THE CONDITION SINCE THE CREATED VIEW IS ALREADY HAVE THE CORRESPONDING STUDENT, ADVISOR, INTERNSHIP but need to return the right STUDENT REQUEST where status = "ACCEPTED",
        $studentRequest = StudentRequest::where('student_id', $validatedData['user_student_id'])
            ->where('advisor_id', $validatedData['user_advisor_id'])
            ->where('internship_id', $validatedData['internship_id'])
            ->where('status', 'accepted')
            ->first();

        if(!$studentRequest) {
            return back()->withErrors('The selected student, advisor, and internship combination is not accepted');
        }

        $studentName = User::find($validatedData['user_student_id'])->name;

        $sanitizedStudentName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $studentName);

        $studentThesisPath = null;

        if($request->hasFile('student_thesis')){
            $studentThesisPath = $request->file('student_thesis')->storeAs(
                'uploads/thesis_documents',
                $sanitizedStudentName.'_thesis_'.time().'.'.$request->file('student_thesis')->getClientOriginalExtension(),'public'
            );
        }

        ThesisDocument::create([
            'student_request_id' => $studentRequest->id,
            'student_thesis' => $studentThesisPath,
            'status' => $validatedData['status'],
        ]);

        return redirect()->route('student_thesis_document.index')->with('success','student thesis doucment created successfully');
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $currentStudent = Auth::user();

        // dd($id);

        // Fetch all advisors that have a student request for the current student
        $advisors = User::whereHas('studentRequests', function($query) use ($currentStudent) {
            $query->where('student_id', $currentStudent->id)
                  ->where('status', 'accepted');
        })->get();

        // dd($advisors);

        // Fetch all internships associated with the current student through student_request
        $internships = Internship::whereHas('studentRequests', function($query) use ($currentStudent) {
            $query->where('student_id', $currentStudent->id)->where('status', 'accepted');
        })->get();

        // dd($internships);

        $students = User::whereHas('role', function($query) {
            $query->where('role_name', 'student');
        })->get();
        

        // $internships = Internship::get();
        $companies = Company::get();
        $categories = Category::get(); 
        // $currentStudent = Auth::user(); 

        $thesis_document = ThesisDocument::find($id);

        // dd($thesis_document);

        $student_requests = StudentRequest::where('status', 'accepted')->get();

        $data = array(
            'students' => $students,
            'advisors' =>$advisors,
            'companies' => $companies,
            'internships' => $internships,
            'categories' => $categories,
            'currentStudent' => $currentStudent,
            'student_requests' => $student_requests,
            'thesis_document' => $thesis_document,
        );

        return view('back_end.preference.student.thesis_document.edit',compact('id'))->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_student_id' => 'required|exists:users,id',
            'user_advisor_id' => 'required|exists:users,id',
            'internship_id' => 'required|exists:internships,id',
            'student_thesis' => 'nullable|file|mimes:pdf,docx|max:10240', // File is optional here
            'status' => 'required|in:submitted,accepted,rejected',
        ]);

        $thesis_document = ThesisDocument::find($id);

        // SHOULD NOT CHECK THE CONDITION SINCE THE CREATED VIEW IS ALREADY HAVE THE CORRESPONDING STUDENT, ADVISOR, INTERNSHIP but need to return the right STUDENT REQUEST where status = "ACCEPTED",
        $studentRequest = StudentRequest::where('student_id', $validatedData['user_student_id'])
            ->where('advisor_id', $validatedData['user_advisor_id'])
            ->where('internship_id', $validatedData['internship_id'])
            ->where('status', 'accepted')
            ->first();

        if(!$studentRequest) {
            return back()->withErrors('The selected student, advisor, and internship combination is not accepted');
        }

        $studentThesisPath = $thesis_document->student_thesis; 

        if($request->hasFile('student_thesis')){
            $studentName = User::find($validatedData['user_student_id'])->name;

            $sanitizedStudentName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $studentName);

            $studentThesisPath = $request->file('student_thesis')->storeAs(
                'uploads/thesis_documents',
                $sanitizedStudentName . '_thesis_' . time() . '.' . $request->file('student_thesis')->getClientOriginalExtension(),
                'public'
            );
        }

        $thesis_document->update([
            'student_request_id' => $studentRequest->id,
            'student_thesis' => $studentThesisPath,
            'status' => $validatedData['status'],
        ]);

        return redirect()->route('student_thesis_document.index')->with('success', 'Student Thesis document updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $thesis_document = ThesisDocument::find($id);

        $thesis_document->delete();

        return redirect()->route('student_thesis_document.index')->with('success','student thesis_document Deleted successfully');
    }
}

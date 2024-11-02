<?php

namespace App\Http\Controllers;

use App\Models\ThesisDocument;
use App\Http\Requests\StoreThesisDocumentRequest;
use App\Http\Requests\UpdateThesisDocumentRequest;
use App\Models\StudentRequest;
use App\Models\User;
use App\Models\Company;
use App\Models\Internship;
use App\Models\Category;
use App\Models\InternshipAdvisorStudent;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Echo_;

class ThesisDocumentController extends Controller
{
    public function index()
    {
        $results = ThesisDocument::paginate(10);
        
        return view('back_end.preference.thesis_document.index')->with(['results' => $results]);
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
        $internships_advisor_students = InternshipAdvisorStudent::get();
        $categories = Category::get(); 
        $currentStudent = Auth::user(); 

        $student_requests = StudentRequest::where('status', 'accepted')->get();

        $data = array(
            'students' => $students,
            'advisors' =>$advisors,
            'companies' => $companies,
            'internships' => $internships,
            'categories' => $categories,
            'internships_advisor_students' => $internships_advisor_students,
            'currentStudent' => $currentStudent,
            'student_requests' => $student_requests,
        );

        return view('back_end.preference.thesis_document.create')->with($data);
    }

    public function store(StoreThesisDocumentRequest $request)
    {
        $validatedData = $request->validate([
            'user_student_id' => 'required|exists:users,id',
            'user_advisor_id' => 'required|exists:users,id',
            'internship_id' => 'required|exists:internships,id',
            'student_thesis' => 'required|file|mimes:pdf,docx|max:10240', // Max size: 10MB
            'status' => 'required|in:submitted,accepted,rejected',
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

        // Sanitize the student name to avoid illegal file name characters
        $sanitizedStudentName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $studentName);

        // Step 4: Handle file upload with a custom file name
        $studentThesisPath = null;  // Default to null if no file uploaded
        if ($request->hasFile('student_thesis')) {
            $studentThesisPath = $request->file('student_thesis')->storeAs(
                'uploads/thesis_documents',
                $sanitizedStudentName . '_thesis_' . time() . '.' . $request->file('student_thesis')->getClientOriginalExtension(),
                'public'
            );
        }

        // Step 5: Store the thesis document data in the database
        ThesisDocument::create([
            'student_request_id' => $studentRequest->id,  // Associate with the correct student request
            'student_thesis' => $studentThesisPath,  // Store the file path
            'status' => $validatedData['status'],
        ]);

        // Step 6: Redirect to the index page with a success message
        return redirect()->route('thesis_document.index')->with('success', 'Thesis document created successfully.');
    }

    public function show(ThesisDocument $thesisDocument)
    {
        //
    }

    public function edit(ThesisDocument $thesis_document)
    {

        // dd($thesis_document);
        // $thesisDocument = ThesisDocument::findOrFail($thesis_document);
        // EXAMPLE
        // $thesisDocument = ThesisDocument::findOrFail(1);
        // id: 1,
        // student_request_id: 6,
        // student_thesis: "1.pdf",
        // status: "submitted",
        // created_at: "2024-10-12 18:21:27",
        // updated_at: "2024-10-12 18:21:27",

        $results = ThesisDocument::paginate(10);

        $students = User::whereHas('role', function($query) {
            $query->where('role_name', 'student');
        })->get();

        $advisors = User::whereHas('role', function($query) {
            $query->where('role_name', 'advisor');
        })->get();

        $internships = Internship::all();

        $data = array(
            // 'thesisDocument' => $thesisDocument,
            'students' => $students,
            'advisors' => $advisors,
            'internships' => $internships,
            'results' => $results,
        );

        return view('back_end.preference.thesis_document.edit', compact('thesis_document'))->with($data);
    }

    public function update(UpdateThesisDocumentRequest $request, ThesisDocument $thesisDocument)
    {
        $validatedData = $request->validate([
            'user_student_id' => 'required|exists:users,id',
            'user_advisor_id' => 'required|exists:users,id',
            'internship_id' => 'required|exists:internships,id',
            'student_thesis' => 'nullable|file|mimes:pdf,docx|max:10240', // File is optional here
            'status' => 'required|in:submitted,accepted,rejected',
        ]);

        $studentThesisPath = $thesisDocument->student_thesis; 

        if ($request->hasFile('student_thesis')) {
            
            $studentName = User::find($validatedData['user_student_id'])->name;

            $sanitizedStudentName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $studentName);

            $studentThesisPath = $request->file('student_thesis')->storeAs(
                'uploads/thesis_documents',
                $sanitizedStudentName . '_thesis_' . time() . '.' . $request->file('student_thesis')->getClientOriginalExtension(),
                'public'
            );
        }

        $studentRequest = StudentRequest::where('student_id', $validatedData['user_student_id'])
            ->where('advisor_id', $validatedData['user_advisor_id'])
            ->where('internship_id', $validatedData['internship_id'])
            ->where('status', 'accepted')  // Ensure it's accepted
            ->first();

        if (!$studentRequest) {
            return back()->withErrors('The selected student, advisor, and internship combination status is not "accepted". Please check the Advisor Selection Part.');
        }

        $thesisDocument->update([
            'student_request_id' =>  $studentRequest->id,
            'student_thesis' => $studentThesisPath,
            'status' => $validatedData['status'],
        ]);

        return redirect()->route('thesis_document.index')->with('success', 'Thesis document updated successfully.');
    }

    public function destroy(ThesisDocument $thesisDocument)
    {
        $thesisDocument->delete();

        return redirect()->route('thesis_document.index')->with('success','thesis_document Deleted successfully');
    }
}

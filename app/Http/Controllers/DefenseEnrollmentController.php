<?php

namespace App\Http\Controllers;

use App\Models\DefenseEnrollment;
use App\Http\Requests\StoreDefenseEnrollmentRequest;
use App\Http\Requests\UpdateDefenseEnrollmentRequest;
use App\Models\User;
use App\Models\Internship;
use App\Models\Company;
use App\Models\Category;
use App\Models\JuryGroup;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentRequest;
use App\Models\ThesisDocument;
use App\Models\DefenseRequest;

class DefenseEnrollmentController extends Controller
{
    public function index()
    {
        $results = DefenseEnrollment::paginate(10);

        return view('back_end.preference.defense_enrollment.index')->with(['results' => $results]);
    }

    public function create()
    {

        $acceptedStudentRequests = StudentRequest::with(['student', 'advisor', 'internship'])
            ->where('status', 'accepted')
            ->get();

        $students = User::whereHas('role', function($query) {
            $query->where('role_name', 'student');
        })->get();

        $advisors = User::whereHas('role', function($query) {
            $query->where('role_name', 'advisor');
        })->get();

        $juryGroup = JuryGroup::get();
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
            'juryGroup' => $juryGroup,
            'acceptedStudentRequests' => $acceptedStudentRequests,
        );

        return view('back_end.preference.defense_enrollment.create')->with($data);
    }

    public function store(StoreDefenseEnrollmentRequest $request)
    {
        $validatedData = $request->validate([
            'student_request_id' => 'required|exists:student_requests,id',  
            'jury_group_id' => 'required|exists:jury_groups,id',
            'defense_date' => 'required|date', 
            'status' => 'required|in:Scheduled,Completed',
        ]);

        $existingDefenseEnrollment = DefenseEnrollment::where('student_request_id', $validatedData['student_request_id'])->first();
    
        if ($existingDefenseEnrollment) {
            return redirect()->back()->with('error', 'An Enrollment for this student is already exists.');
        }

        // Use the "user_student_id" + "user_advisor_id" + "internship_id" + "Status = "accept" to retrive the student_request_id from student_request
            // If not return the message "Student, Advisor, Internship" are not match please check the AdvisorSelcection Features
        
        $studentRequest = StudentRequest::where('student_id', $validatedData['user_student_id'])
            ->where('advisor_id', $validatedData['user_advisor_id'])
            ->where('internship_id',$validatedData['internship_id'])
            ->where('status', 'Accepted')
            ->first();

        if (!$studentRequest) {
            return back()->withErrors('The selected STUDENT, ADVISOR, and INTERNSHIP combination status is not "accepted". Please check the ADVISOR SELECTION Part.');
        }

        $thesisDocument = ThesisDocument::where('student_request_id', $studentRequest->id)
            ->where('status', 'accepted') // Only fetch thesis documents with "accepted" status
            ->first();

        if (!$thesisDocument)
        {
            return back()->withErrors('No thesis document found for the selected student request.');
        } elseif ($thesisDocument->status !== 'accepted') {
            return back()->withErrors('The thesis document for this student request is not accepted yet.');
        }

        $defenseRequest = DefenseRequest::where('thesis_document_id', $thesisDocument->id)
            ->where('status', 'approved')
            ->first();

        if (!$defenseRequest)
        {
            return back()->withErrors('The Defense Request is not Yet "Approved" for the Selected Student');
        }

        // Check if a DefenseEnrollment already exists for the same defense request
        $existingEnrollment = DefenseEnrollment::where('defense_request_id', $defenseRequest->id)->first();

        if ($existingEnrollment) {
            return back()->withErrors('This Student has Already been Enrolled.');
        }

        $studentName = User::find($validatedData['user_student_id'])->name;

        // Retrieve the selected Jury Group and ensure it belongs to the same internship as the selected internship
        $juryGroup = JuryGroup::find($validatedData['jury_group_id']);

        if ($juryGroup->internship_id != $validatedData['internship_id'])
        {
            return back()->withErrors('The selected JURY GROUP does not belong to the selected INTERNSHIP.');
        }

        DefenseEnrollment::create([
            'defense_request_id' => $defenseRequest->id,
            'jury_group_id' => $validatedData['jury_group_id'],
            'defense_date' => $validatedData['defense_date'],
            'status' => $validatedData['status'],
        ]);

        return redirect()->route('defense_enrollment.index')->with('success', 'Defense Enrollment created successfully.');
    }

    public function getJuryGroup($id)
    {
        $juryGroup = JuryGroup::find($id);

        // EXAMPLE
            // App\Models\JuryGroup::Find(1)
                // id: 1,
                // internship_id: 1,
                // user_jury1_id: 20,
                // user_jury2_id: 15,
                // user_jury3_id: 16,
                // user_jury4_id: 17,
                // created_at: "2024-10-18 04:45:27",
                // updated_at: "2024-10-18 06:06:12",

        if ($juryGroup) {
            return response()->json([
                'jury1' => $juryGroup->jury1->name ?? 'N/A',
                'jury2' => $juryGroup->jury2->name ?? 'N/A',
                'jury3' => $juryGroup->jury3->name ?? 'N/A',
                'jury4' => $juryGroup->jury4->name ?? 'N/A',
            ]);
        }

        return response()->json([
            'error' => 'Jury Group not found'
        ], 404);
    }



    public function show(DefenseEnrollment $defenseEnrollment)
    {
        //
    }

    public function edit(DefenseEnrollment $defenseEnrollment)
    {
        // Fetch all necessary related data for the form
        $students = User::whereHas('role', function($query) {
            $query->where('role_name', 'student');
        })->get();

        $advisors = User::whereHas('role', function($query) {
            $query->where('role_name', 'advisor');
        })->get();

        $juryGroup = JuryGroup::get();
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
            'juryGroup' => $juryGroup,
            'defenseEnrollment' => $defenseEnrollment, // Pass the current enrollment
        );

        return view('back_end.preference.defense_enrollment.edit')->with($data);
    }

    public function update(UpdateDefenseEnrollmentRequest $request, DefenseEnrollment $defenseEnrollment)
    {
        $validatedData = $request->validate([
            'user_student_id' => 'required|exists:users,id',
            'user_advisor_id' => 'required|exists:users,id',
            'internship_id' => 'required|exists:internships,id',
            'jury_group_id' => 'required|exists:jury_groups,id',
            'defense_date' => 'required|date', 
            'status' => 'required|in:Scheduled,Completed',
        ]);
    
        // Check if the student, advisor, and internship combination exists and is accepted
        $studentRequest = StudentRequest::where('student_id', $validatedData['user_student_id'])
            ->where('advisor_id', $validatedData['user_advisor_id'])
            ->where('internship_id', $validatedData['internship_id'])
            ->where('status', 'Accepted')
            ->first();
    
        if (!$studentRequest) {
            return back()->withErrors('The selected STUDENT, ADVISOR, and INTERNSHIP combination status is not "accepted". Please check the ADVISOR SELECTION Part.');
        }
    
        // Check for an accepted thesis document
        $thesisDocument = ThesisDocument::where('student_request_id', $studentRequest->id)
            ->where('status', 'accepted')
            ->first();
    
        if (!$thesisDocument) {
            return back()->withErrors('No thesis document found for the selected student request.');
        }
    
        // Check for an approved defense request
        $defenseRequest = DefenseRequest::where('thesis_document_id', $thesisDocument->id)
            ->where('status', 'approved')
            ->first();
    
        if (!$defenseRequest) {
            return back()->withErrors('The Defense Request is not Yet "Approved" for the Selected Student.');
        }
    
        // Check if the selected jury group belongs to the selected internship
        $juryGroup = JuryGroup::find($validatedData['jury_group_id']);
    
        if ($juryGroup->internship_id != $validatedData['internship_id']) {
            return back()->withErrors('The selected JURY GROUP does not belong to the selected INTERNSHIP.');
        }
    
        // Update the defense enrollment record
        $defenseEnrollment->update([
            'defense_request_id' => $defenseRequest->id,
            'jury_group_id' => $validatedData['jury_group_id'],
            'defense_date' => $validatedData['defense_date'],
            'status' => $validatedData['status'],
        ]);
    
        return redirect()->route('defense_enrollment.index')->with('success', 'Defense Enrollment updated successfully.');
    }

    public function destroy(DefenseEnrollment $defenseEnrollment)
    {
        $defenseEnrollment->delete();

        return redirect()->route('defense_enrollment.index')->with('success','Defense Enrollment  Deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\SubmissionForm;
use App\Models\Internship;
use App\Http\Requests\StoreSubmissionFormRequest;
use App\Http\Requests\UpdateSubmissionFormRequest;
use App\Models\Company;
use App\Models\User;
use App\Models\Category;
use App\Models\InternshipAdvisorStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\StudentRequest;

class SubmissionFormController extends Controller
{
    public function index()
    {
        $results = SubmissionForm::with('student_request.student','student_request.advisor','student_request.internship','company')->paginate(10);

        return view('back_end.preference.submission_form.index',compact('results'));
    }

    public function getStudentsByInternship($internship_id)
    {
        $students = InternshipAdvisorStudent::where('internship_id', $internship_id)
        ->with('student')
        ->get()
        ->map(function($item) {
            return [
                'id' => $item->student->id,
                'name' => $item->student->name,
            ];
        });

        return response()->json($students);

        Log::info('Students fetched for internship ID ' . $internship_id, ['students' => $students]);
    }

    public function create()
    {
        $studentRequests = StudentRequest::where('status', 'accepted')->with('student', 'internship', 'advisor')->get();

        $companies = Company::all();

        $internships = Internship::get();

        $categories = Category::get();

        $currentStudent = Auth::user();

        return view('back_end.preference.submission_form.create', compact('studentRequests', 'companies', 'internships', 'categories', 'currentStudent'));
    }

    public function store(StoreSubmissionFormRequest $request)
    {
        // Validate the form inputs
        $validatedData = $request->validate([
            'student_request_id' => 'required|exists:student_requests,id',
            'company_id' => 'required|exists:companies,id',
            'supervisor_name' => 'required|string|max:255',
            'internship_agreement' => 'required|file|mimes:pdf|max:2048',
            'advisor_confirmation_letter' => 'required|file|mimes:pdf|max:2048',
            'internship_proposal' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Check if a submission form already exists for this student_request_id
        $existingSubmissionForm = SubmissionForm::where('student_request_id', $validatedData['student_request_id'])->first();

        if ($existingSubmissionForm) {
            return back()->withErrors('A submission form for this student request has already been created.');
        }

        // Retrieve the student name from the student request relation
        $studentRequest = StudentRequest::where('id', $validatedData['student_request_id'])
            ->where('status', 'accepted')
            ->first();

        if (!$studentRequest) {
            return back()->withErrors('The selected student request does not have an "accepted" status.');
        }

        // Get the student's name and sanitize it to be used in the file name
        $studentName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $studentRequest->student->name);

        // Handle the file uploads with custom names
        $internshipAgreementPath = $request->file('internship_agreement')->storeAs(
            'uploads/internship_agreements',
            "{$studentName}_Internship_Agreement_" . ".pdf",
            'public'
        );

        $advisorConfirmationLetterPath = $request->file('advisor_confirmation_letter')->storeAs(
            'uploads/advisor_confirmation_letters',
            "{$studentName}_Advisor_Confirmation_Letter_" . ".pdf",
            'public'
        );

        $internshipProposalPath = $request->file('internship_proposal')->storeAs(
            'uploads/internship_proposals',
            "{$studentName}_Internship_Proposal_" . ".pdf",
            'public'
        );

        // Create the submission form record
        SubmissionForm::create([
            'student_request_id' => $validatedData['student_request_id'],
            'company_id' => $validatedData['company_id'],
            'supervisor_name' => $validatedData['supervisor_name'],
            'internship_agreement' => $internshipAgreementPath,
            'advisor_confirmation_letter' => $advisorConfirmationLetterPath,
            'internship_proposal' => $internshipProposalPath,
        ]);

        return redirect()->route('submission_form.index')->with('success', 'Submission Form Created Successfully.');
    }

    public function show(SubmissionForm $submissionForm)
    {
        //
    }

    public function edit(SubmissionForm $submissionForm)
    {
        // Fetch the necessary data to populate the form
        $studentRequests = StudentRequest::where('status', 'accepted')
            ->with('student', 'internship', 'advisor')
            ->get();

        $companies = Company::all();
        $categories = Category::get(); // Assuming categories are needed
        $currentStudent = Auth::user(); // Fetch the currently logged-in student

        // Pass all the necessary data to the view
        return view('back_end.preference.submission_form.edit', compact(
            'submissionForm', 'studentRequests', 'companies', 'categories', 'currentStudent'
        ));
    }

    public function update(UpdateSubmissionFormRequest $request, SubmissionForm $submissionForm)
    {
        // Validate the form input
        $validatedData = $request->validate([
            'student_request_id' => 'required|exists:student_requests,id',
            'company_id' => 'required|exists:companies,id',
            'supervisor_name' => 'required|string|max:255',
            'internship_agreement' => 'nullable|file|mimes:pdf|max:2048',  // PDF only, max size 2MB
            'advisor_confirmation_letter' => 'nullable|file|mimes:pdf|max:2048',
            'internship_proposal' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Check if a submission form already exists for this student_request_id (excluding the current submission form)
        $existingSubmissionForm = SubmissionForm::where('student_request_id', $validatedData['student_request_id'])
            ->where('id', '!=', $submissionForm->id)
            ->first();

        if ($existingSubmissionForm) {
            return back()->withErrors('A submission form for this student request has already been created.');
        }

        // Retrieve the student name from the student request relation
        $studentRequest = StudentRequest::where('id', $validatedData['student_request_id'])->first();
        $studentName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $studentRequest->student->name); // Sanitize student name

        // Handle file uploads with custom names (overwrite previous files if new ones are uploaded)
        $internshipAgreementPath = $submissionForm->internship_agreement;
        if ($request->hasFile('internship_agreement')) {
            $internshipAgreementPath = $request->file('internship_agreement')->storeAs(
                'uploads/internship_agreements',
                "{$studentName}_Internship_Agreement_" . time() . ".pdf",
                'public'
            );
        }

        $advisorConfirmationLetterPath = $submissionForm->advisor_confirmation_letter;
        if ($request->hasFile('advisor_confirmation_letter')) {
            $advisorConfirmationLetterPath = $request->file('advisor_confirmation_letter')->storeAs(
                'uploads/advisor_confirmation_letters',
                "{$studentName}_Advisor_Confirmation_Letter_" . time() . ".pdf",
                'public'
            );
        }

        $internshipProposalPath = $submissionForm->internship_proposal;
        if ($request->hasFile('internship_proposal')) {
            $internshipProposalPath = $request->file('internship_proposal')->storeAs(
                'uploads/internship_proposals',
                "{$studentName}_Internship_Proposal_" . time() . ".pdf",
                'public'
            );
        }

        // Update the submission form record
        $submissionForm->update([
            'student_request_id' => $validatedData['student_request_id'],
            'company_id' => $validatedData['company_id'],
            'supervisor_name' => $validatedData['supervisor_name'],
            'internship_agreement' => $internshipAgreementPath,
            'advisor_confirmation_letter' => $advisorConfirmationLetterPath,
            'internship_proposal' => $internshipProposalPath,
        ]);

        return redirect()->route('submission_form.index')->with('success', 'Submission Form Updated Successfully.');
    }

    public function destroy(SubmissionForm $submissionForm)
    {
        $submissionForm->delete();
        return redirect()->route('submission_form.index')->with('success','Submission Form Deleted successfully');
    }
}

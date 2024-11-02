<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmissionForm;
use App\Models\Internship;
use App\Http\Requests\StoreSubmissionFormRequest;
use App\Http\Requests\UpdateSubmissionFormRequest;
use App\Models\Company;
use App\Models\User;
use App\Models\Category;
use App\Models\InternshipAdvisorStudent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\StudentRequest;

class StudentSubmissionFormController extends Controller
{
    use AuthorizesRequests;

    public function studentIndex()
    {
        $studentId = Auth::id();

        $results = SubmissionForm::whereHas('student_request', function ($query) use ($studentId) {
            $query->where('student_id', $studentId);  
        })->paginate(10);

        return view('back_end.preference.student.submission_form.index', compact('results'));
    }

    public function studentCreate()
    {
        $student = Auth::user();

        $studentRequests = StudentRequest::where('student_id', $student->id)
            ->where('status', 'accepted')
            ->with(['internship', 'advisor']) 
            ->get();

        $companies = Company::all(); 
        $categories = Category::all();

        return view('back_end.preference.student.submission_form.create', compact('student', 'studentRequests', 'companies', 'categories'));
    }

    public function studentStore(StoreSubmissionFormRequest $request)
    {
        $validatedData = $request->validate([
            'student_request_id' => 'required|exists:student_requests,id',
            'company_id' => 'required|exists:companies,id',
            'supervisor_name' => 'required|string|max:255',
            'internship_agreement' => 'required|file|mimes:pdf|max:2048',
            'advisor_confirmation_letter' => 'required|file|mimes:pdf|max:2048',
            'internship_proposal' => 'required|file|mimes:pdf|max:2048',
        ]);

        $existingForm = SubmissionForm::where('student_request_id', $validatedData['student_request_id'])->first();

        if ($existingForm) {
            return back()->withErrors('You have already submitted a form for this internship request.');
        }

        $sanitizedStudentName = preg_replace('/[^A-Za-z0-9_\-]/', '_', Auth::user()->name);

        $internshipAgreementPath = $request->file('internship_agreement')->storeAs(
            'uploads/internship_agreements',
            $sanitizedStudentName . '_internship_agreement_' . time() . '.pdf',
            'public'
        );

        $advisorConfirmationLetterPath = $request->file('advisor_confirmation_letter')->storeAs(
            'uploads/advisor_confirmation_letters',
            $sanitizedStudentName . '_advisor_confirmation_letter_' . time() . '.pdf',
            'public'
        );

        $internshipProposalPath = $request->file('internship_proposal')->storeAs(
            'uploads/internship_proposals',
            $sanitizedStudentName . '_internship_proposal_' . time() . '.pdf',
            'public'
        );

        SubmissionForm::create([
            'student_request_id' => $validatedData['student_request_id'],
            'company_id' => $validatedData['company_id'],
            'supervisor_name' => $validatedData['supervisor_name'],
            'internship_agreement' => $internshipAgreementPath,
            'advisor_confirmation_letter' => $advisorConfirmationLetterPath,
            'internship_proposal' => $internshipProposalPath,
        ]);

        return redirect()->route('student_submission_form.index')->with('success', 'Submission Form Created Successfully.');
    }

    public function studentEdit(SubmissionForm $submissionForm)
    {
        $this->authorize('update', $submissionForm);

        $student = Auth::user(); 
        $companies = Company::get();
        $categories = Category::get();

        $student_request = StudentRequest::where('student_id', $student->id)
            ->where('status', 'accepted')
            ->get();

        return view('back_end.preference.student.submission_form.edit', compact('submissionForm', 'student_request', 'companies', 'categories', 'student'));
    }

    public function studentUpdate(UpdateSubmissionFormRequest $request, SubmissionForm $submissionForm)
    {
        $this->authorize('update', $submissionForm);

        // Validate the form input
        $validatedData = $request->validate([
            'student_request_id' => 'required|exists:student_requests,id',
            'company_id' => 'required|exists:companies,id',
            'supervisor_name' => 'required|string|max:255',
            'internship_agreement' => 'nullable|file|mimes:pdf|max:2048',
            'advisor_confirmation_letter' => 'nullable|file|mimes:pdf|max:2048',
            'internship_proposal' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Handle file uploads if provided
        if ($request->hasFile('internship_agreement')) {
            $sanitizedStudentName = preg_replace('/[^A-Za-z0-9_\-]/', '_', Auth::user()->name);
            $internshipAgreementPath = $request->file('internship_agreement')->storeAs(
                'uploads/internship_agreements',
                $sanitizedStudentName . '_internship_agreement_' . time() . '.pdf',
                'public'
            );
            $validatedData['internship_agreement'] = $internshipAgreementPath;
        }

        if ($request->hasFile('advisor_confirmation_letter')) {
            $advisorConfirmationLetterPath = $request->file('advisor_confirmation_letter')->storeAs(
                'uploads/advisor_confirmation_letters',
                $sanitizedStudentName . '_advisor_confirmation_letter_' . time() . '.pdf',
                'public'
            );
            $validatedData['advisor_confirmation_letter'] = $advisorConfirmationLetterPath;
        }

        if ($request->hasFile('internship_proposal')) {
            $internshipProposalPath = $request->file('internship_proposal')->storeAs(
                'uploads/internship_proposals',
                $sanitizedStudentName . '_internship_proposal_' . time() . '.pdf',
                'public'
            );
            $validatedData['internship_proposal'] = $internshipProposalPath;
        }

        // Update the submission form record
        $submissionForm->update($validatedData);

        return redirect()->route('student_submission_form.index')->with('success', 'Submission Form Updated Successfully.');
    }

    public function studentDestroy(SubmissionForm $submissionForm)
    {
        // Ensure the authenticated student is the owner of the submission form
        $this->authorize('delete', $submissionForm);

        $submissionForm->delete();

        return redirect()->route('student_submission_form.index')->with('success', 'Submission Form Deleted Successfully.');
    }
}

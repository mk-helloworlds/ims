<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\StudentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvisorSelectionController extends Controller
{
    public function index($internshipId)
    {
        $advisors = User::whereHas('role', function($query) {
            $query->where('role_name', 'advisor');
        })
        ->whereHas('internships', function($query) use ($internshipId) {
            $query->where('internship_id', $internshipId);
        })
        ->withCount([
            'studentRequests as accepted_students' => function ($query) {
                $query->where('status', 'Accepted');
            },
            'studentRequests as pending_students' => function ($query) {
                $query->where('status', 'Pending');
            },
            'studentRequests as rejected_students' => function ($query) {
                $query->where('status', 'Rejected');
            },
        ])
        ->get();

        // Check if the logged-in student has been accepted by an advisor
        $acceptedRequest = StudentRequest::where('student_id', Auth::id())->where('status', 'Accepted')->with('advisor')->first();

        // // Check if the advisor has 3 or more accepted students
        // $acceptedCount = StudentRequest::where('advisor_id', $advisor->id)->where('status', 'Accepted')->count(); 

        $currentStudent = Auth::user()->id;
        $CurrentStudentRequest = StudentRequest::where('student_id', $currentStudent)->where('internship_id', $internshipId)->get();

        $internships = Internship::with('participants')->findOrFail($internshipId);
        $participants = $internships->participants;

        return view('back_end.preference.advisor_selection.index', compact('advisors','acceptedRequest','internships','CurrentStudentRequest','internshipId'));
    }

    public function sendRequest(Request $request)
    {
        $request->validate([
            'advisor_id' => 'required|exists:users,id',
            'internship_id' => 'required|exists:internships,id',
            'message' => 'nullable|string|max:500', 
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048', 
        ]);

        $studentId = Auth::id();
        $advisorId = $request->input('advisor_id');
        $internshipId = $request->input('internship_id');

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cvs', 'public');
        }

        $existingRequest = StudentRequest::where('student_id', $studentId)
        ->where('advisor_id', $advisorId)
        ->where('internship_id', $internshipId)
        ->where('status', 'Pending')
        ->exists();

        if ($existingRequest) {
            return redirect()->back()->withErrors('You have already sent a request to this advisor for this internship.');
        }

        // Check if the student has already been accepted for this internship by any advisor
        $acceptedRequest = StudentRequest::where('student_id', $studentId)
        ->where('internship_id', $internshipId)
        ->where('status', 'Accepted')
        ->exists();

        if ($acceptedRequest) {
            return redirect()->back()->withErrors('You have already been accepted by an advisor for this internship.');
        }

        // Check if the advisor has 3 or more accepted students
        $acceptedCount = StudentRequest::where('advisor_id', $advisorId)
        ->where('internship_id', $internshipId)
        ->where('status', 'Accepted')
        ->count();

        if ($acceptedCount >= 3) {
            return redirect()->back()->withErrors('This advisor already has 3 accepted students for this internship. Please choose another advisor.');
        }

        // Check if the student already has an accepted advisor
        $studentHasAcceptedAdvisor = StudentRequest::where('student_id', Auth::id())
        ->where('status', 'Accepted')
        ->exists();
       
        StudentRequest::create([
            'student_id' => $studentId,
            'internship_id' => $internshipId,
            'advisor_id' => $advisorId,
            'status' => 'Pending',
            'message' => $request->input('message'), // Save student message
            'cv' => $cvPath, // Save CV path
        ]);

        return redirect()->route('student_advisor_selection.index', $internshipId)->with('success', 'Request sent successfully');
    }

    public function viewPendingRequests($internshipId)
    {
        if (Auth::user()->role->role_name == 'admin') {
            $requests = StudentRequest::where('status', 'Pending')
                                      ->with('student') 
                                      ->get();
        } elseif (Auth::user()->role->role_name == 'advisor'){
            $requests = StudentRequest::where('status', 'Pending')
                          ->where('advisor_id', Auth::id())
                          ->where('internship_id', $internshipId)
                          ->with('student') 
                          ->get();
        }

        $currentAdvisor = Auth::user()->id;
        $AdvisorStudentRequest = StudentRequest::where('advisor_id', $currentAdvisor)->get();

        $internships = Internship::get();

        return view('back_end.preference.advisor_selection.pending', compact('requests', 'internships','AdvisorStudentRequest','internshipId'));
    }

    public function respondToRequest(Request $request, $internshipId)
    {
        $request->validate([
            'request_id' => 'required|exists:student_requests,id',
            'status' => 'required|in:Accepted,Rejected',
            'advisor_response_message' => 'nullable|string|max:500', // Optional response message
        ]);

        // Fetch the student request by ID
        $studentRequest = StudentRequest::find($request->input('request_id'));

        // Ensure that only the assigned advisor or an admin can respond to the request
        if (Auth::user()->role->role_name === 'advisor' && $studentRequest->advisor_id !== Auth::id()) {
            return redirect()->back()->withErrors('Unauthorized Action: You are not assigned to this request. Only the requested advisor can confirm the student.');
        }

        // Check if the student is already accepted by another advisor for the same internship
        $alreadyAccepted = StudentRequest::where('student_id', $studentRequest->student_id)
            ->where('internship_id', $studentRequest->internship_id)
            ->where('status', 'Accepted')
            ->exists();

        if ($alreadyAccepted && $request->input('status') === 'Accepted') {
            return redirect()->back()->withErrors('This student has already been accepted by another advisor for this internship.');
        }

        // Check if the advisor has already accepted 3 students for the same internship
        $acceptedCount = StudentRequest::where('advisor_id', $studentRequest->advisor_id)
            ->where('internship_id', $studentRequest->internship_id)  // Ensure it's the same internship
            ->where('status', 'Accepted')
            ->count();

        if ($acceptedCount >= 3 && $request->input('status') === 'Accepted') {
            return redirect()->back()->withErrors('This advisor already has 3 accepted students for this internship and cannot accept more requests.');
        }

        // Check if this specific advisor has already accepted this student for the same internship (avoid duplicates)
        $duplicateRequest = StudentRequest::where('advisor_id', $studentRequest->advisor_id)
            ->where('student_id', $studentRequest->student_id)
            ->where('internship_id', $studentRequest->internship_id)  // Fix: This should compare internship_id to internship_id, not student_id
            ->where('status', 'Accepted')
            ->exists();

        if ($request->input('status') === 'Accepted' && $duplicateRequest) {
            return redirect()->back()->withErrors('This student has already been accepted by this advisor for the same internship.');
        }

        // Update the request's status to Accepted or Rejected
        $studentRequest->update([
            'status' => $request->input('status'),
            'advisor_response_message' => $request->input('advisor_response_message'),
        ]);

        return redirect()->route('advisor_advisor_selection.pending', $internshipId)->with('success', 'Request updated successfully.');
    }
}

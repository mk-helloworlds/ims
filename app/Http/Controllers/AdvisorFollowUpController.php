<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use App\Models\StudentRequest;
use App\Models\User;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\InternshipAdvisorStudent;
use App\Models\Category;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Pagination\LengthAwarePaginator;

class AdvisorFollowUpController extends Controller
{
    // public function advisorIndex()
    // {
    //     $advisorId = Auth::user()->id;
    
    //     $results = FollowUp::whereHas('studentRequest', function($query) use ($advisorId) {
    //         $query->where('advisor_id', $advisorId)->where('status', 'Accepted');
    //     })->paginate(10);

    //     // $results = StudentRequest::where('advisor_id', $advisorId)->where('status', 'Accepted')->paginate(10);
    
    //     return view('back_end.preference.advisor.follow_up.index', compact('results'));
    // }

    public function advisorIndex()
    {
        $advisorId = Auth::user()->id;

        // Get accepted student requests for the advisor
        $studentRequests = StudentRequest::where('advisor_id', $advisorId)
            ->where('status', 'Accepted')
            ->with('student', 'internship') // Load related student and internship data
            ->get();

        // Get the existing follow-ups for these student requests
        $followUps = FollowUp::whereIn('student_request_id', $studentRequests->pluck('id'))
            ->get()
            ->keyBy('student_request_id'); // Key follow-ups by their student_request_id for easy lookup

        // Pass both the student requests and their related follow-ups to the view
        return view('back_end.preference.advisor.follow_up.index', compact('studentRequests', 'followUps'));
    }

    public function advisorStudentDetail(string $studentRequestID)
    {
        // Fetch the specific Student Request
        $studentRequest = StudentRequest::with('student', 'advisor', 'internship')
                        ->where('id', $studentRequestID)
                        ->firstOrFail();
    
        // Fetch any existing follow-up records for this student request
        $followUps = FollowUp::where('student_request_id', $studentRequestID)
                        ->paginate(10);
    
        // If no follow-ups exist, we still return an empty paginated instance
        if ($followUps->isEmpty()) {
            // Create a dummy empty paginator for display purposes
            $followUps = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
        }
    
        // Pass the student request and follow-up data to the view
        return view('back_end.preference.advisor.follow_up.student_detail', compact('studentRequest', 'followUps'));
    }

    public function advisorStudentDetailCreate(string $studentRequestID)
    {
        // Fetch the specific Student Request
        $studentRequest = StudentRequest::with('student', 'advisor', 'internship')
                        ->where('id', $studentRequestID)
                        ->firstOrFail();

        // Pass the fetched data to the create view
        return view('back_end.preference.advisor.follow_up.create', compact('studentRequest'));
    }

    public function advisorStudentDetailStore(Request $request, string $studentRequestID)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'follow_up_date' => 'required|date',
            'notes' => 'nullable|string',
            'status' => 'required|in:On Track,Behind Schedule,Completed',
        ]);

        // Create a new follow-up using the validated data and the studentRequestID from the URL
        FollowUp::create([
            'student_request_id' => $studentRequestID, // Pass the student_request_id from the URL
            'follow_up_date' => $validatedData['follow_up_date'],
            'notes' => $validatedData['notes'],
            'status' => $validatedData['status'],
        ]);

        // Redirect back to the student detail page with a success message
        return redirect()->route('advisor.follow_up.student_detail', $studentRequestID)
                        ->with('success', 'Follow-up created successfully.');
    }

    public function advisorStudentDetailEdit(string $followUpID)
    {
        // Fetch the specific FollowUp record
        $followUp = FollowUp::with('studentRequest.student', 'studentRequest.internship')
                            ->where('id', $followUpID)
                            ->firstOrFail();
    
        // Pass the follow-up data to the view for editing
        return view('back_end.preference.advisor.follow_up.edit', compact('followUp'));
    }
    
    public function advisorStudentDetailUpdate(Request $request, string $followUpID)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'follow_up_date' => 'required|date',
            'notes' => 'nullable|string',
            'status' => 'required|in:On Track,Behind Schedule,Completed',
        ]);
    
        // Find the follow-up by its ID and update its data
        $followUp = FollowUp::where('id', $followUpID)->firstOrFail();
        $followUp->update([
            'follow_up_date' => $validatedData['follow_up_date'],
            'notes' => $validatedData['notes'],
            'status' => $validatedData['status'],
        ]);
    
        // Redirect back to the student detail page with a success message
        return redirect()->route('advisor.follow_up.student_detail', $followUp->student_request_id)
                         ->with('success', 'Follow-up updated successfully.');
    }

    public function advisorStudentDetailDestroy(string $followUpID)
    {
        // Find the follow-up record by ID
        $followUp = FollowUp::where('id', $followUpID)->firstOrFail();
        $studentRequestID = $followUp->student_request_id;
    
        // Delete the follow-up record
        $followUp->delete();
    
        // Redirect back to the student detail page with a success message
        return redirect()->route('advisor.follow_up.student_detail', $studentRequestID)
                         ->with('success', 'Follow-up deleted successfully.');
    }
    
    // ____________________________________________________________________________
    // ____________________________________________________________________________
   
    public function studentIndex($studentId)
    {
        // Fetch the student requests that belong to this student
        $studentRequests = StudentRequest::where('student_id', $studentId)
            ->with('internship', 'advisor')
            ->get();

        // Fetch the follow-ups associated with these student requests
        $studentRequestIds = $studentRequests->pluck('id'); // Get an array of all student request IDs

        // Fetch the follow-ups that belong to this student
        $results = FollowUp::whereIn('student_request_id', $studentRequestIds)
            ->with('studentRequest.internship', 'studentRequest.advisor')
            ->paginate(10);

        // Pass the follow-up data to the view
        return view('back_end.preference.student.follow_up.index', compact('results'));
    }
    
    // public function studentIndex($studentId)
    // {
    //     $studentId = Auth::user()->id;

    //     $results = FollowUp::where('user_student_id', $studentId)->paginate(10);

    //     $advisor = User::whereHas('role', function ($query) {
    //         $query->where('role_name', 'advisor');
    //     })->where('id', $studentId)->first();

    //     return view('back_end.preference.student.submission_form.follow_up.index', compact('results'));
    // }
}

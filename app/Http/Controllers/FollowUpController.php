<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use App\Http\Requests\StoreFollowUpRequest;
use App\Http\Requests\UpdateFollowUpRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentRequest;

class FollowUpController extends Controller
{
    public function index()
    {
        $results = FollowUp::paginate(10);

        return view('back_end.preference.follow_up.index')->with(['results' => $results]);
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

        $internships = Internship::get();
        $companies = Company::get();
        $categories = Category::get(); 
        $currentStudent = Auth::user(); 

        $data = array(
            'students' => $students,
            'advisors' =>$advisors,
            'companies' => $companies,
            'internships' => $internships,
            'categories' => $categories,
            'currentStudent' => $currentStudent,
            'acceptedStudentRequests' => $acceptedStudentRequests,
        );

        return view('back_end.preference.follow_up.create')->with($data);
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'student_request_id' => 'required|exists:student_requests,id',
            'follow_up_date' => 'required|date',
            'notes' => 'nullable|string',
            'status' => 'required|in:On Track,Behind Schedule,Completed',
        ]);
    
        try {
            // Create the follow-up record
            FollowUp::create([
                'student_request_id' => $validatedData['student_request_id'],
                'follow_up_date' => $validatedData['follow_up_date'],
                'notes' => $validatedData['notes'],
                'status' => $validatedData['status'],
            ]);
    
            // Redirect to the index page with a success message
            return redirect()->route('follow_up.index')->with('success', 'Follow-up created successfully.');
        } catch (\Exception $e) {
            // Handle any errors during the creation process
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create Follow-up. Please try again.');
        }
    }

    public function edit(FollowUp $followUp)
    {
        // Fetch the accepted student requests to populate the dropdown
        $acceptedStudentRequests = StudentRequest::with(['student', 'advisor', 'internship'])
            ->where('status', 'Accepted')
            ->get();
    
        return view('back_end.preference.follow_up.edit', compact('followUp', 'acceptedStudentRequests'));
    }

    public function update(Request $request, FollowUp $followUp)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'student_request_id' => 'required|exists:student_requests,id',
            'follow_up_date' => 'required|date',
            'notes' => 'nullable|string',
            'status' => 'required|in:On Track,Behind Schedule,Completed',
        ]);
    
        try {
            // Update the follow-up record
            $followUp->update([
                'student_request_id' => $validatedData['student_request_id'],
                'follow_up_date' => $validatedData['follow_up_date'],
                'notes' => $validatedData['notes'],
                'status' => $validatedData['status'],
            ]);
    
            return redirect()->route('follow_up.index')->with('success', 'Follow-up updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update Follow-up. Please try again.');
        }
    }

    
    public function destroy(FollowUp $followUp)
    {
        $followUp->delete();
        
        return redirect()->route('follow_up.index')->with('success','Follow_up Deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\StudentRequest;
use App\Models\User;
use Illuminate\Http\Request;

use function PHPUnit\Framework\returnValueMap;

class AdminAdvisorSelectionController extends Controller
{
    public function index($internshipId)
    {
        $results = StudentRequest::where('internship_id', $internshipId)->paginate(10);

        return view('back_end.preference.admin_advisor_selection.index', compact('internshipId','results'));
    }
 
    public function create($internshipId)
    {
        $studentRequest = StudentRequest::get();

        $advisors = User::whereHas('role', function($query) {
            $query->where('role_name', 'advisor');
        })
        ->whereHas('internships', function($query) use ($internshipId) {
            $query->where('internship_id', $internshipId);
        })->get();

        $students = User::whereHas('role', function($query) {
            $query->where('role_name', 'student');
        })
        ->whereHas('internships', function($query) use ($internshipId) {
            $query->where('internship_id', $internshipId);
        })->get();

        // $internship_title = Internship::where('id',$internshipId)->get('internship_title');

        $internship_title = Internship::where('id', $internshipId)->value('internship_title');

        $internships = Internship::get();

         $data = array(
            'student_requests' => $studentRequest,
            'students' => $students,
            'advisors' => $advisors,
            'internships' => $internships,
            'internship_title' => $internship_title,
         );

         return view('back_end.preference.admin_advisor_selection.create', compact('internshipId'))->with($data);
     }
 
     public function store(Request $request, $internshipId)
     {
        $request->validate([
            'internship_id' => 'required|exists:internships,id',
            'advisor_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:users,id',
         ]);
      
        $existingRequest = StudentRequest::where('internship_id',  $request->input('internship_id'))
         ->where('advisor_id', $request->input('advisor_id'))
         ->where('student_id', $request->input('student_id'))
         ->exists();
      
        if ($existingRequest) {
            return redirect()->back()->withErrors('This advisor and student combination for the internship already exists.');
        }
      
        $studentRequest = StudentRequest::create([
               'internship_id' => $request->input('internship_id'),
               'advisor_id' => $request->input('advisor_id'),
               'student_id' => $request->input('student_id'),
        ]);
         
        if ($studentRequest->save()){
            return redirect()->route('admin_advisor_selection.index', $internshipId)->with('success', 'Advisor Section created successfully');
        }
        return back()->with('error', 'User Can not be created, Please try again.');
    }
 
    public function edit($internshipId, $id)
    {
        $studentRequest = StudentRequest::findOrFail($id);

        $advisors = User::whereHas('role', function($query) {
            $query->where('role_name', 'advisor');
        })
        ->whereHas('internships', function($query) use ($internshipId) {
            $query->where('internship_id', $internshipId);
        })->get();
        
        $students = User::whereHas('role', function($query){
            $query->where('role_name', 'student');
        })
        ->whereHas('internships', function($query) use ($internshipId) {
            $query->where('internship_id', $internshipId);
        })->get();

        $internships = Internship::get();

        $internship_title = Internship::where('id', $internshipId)->value('internship_title');

        $data = array(
            'student_request' => $studentRequest,
            'students' => $students,
            'advisors' => $advisors,
            'internships' => $internships,
            'internship_title' => $internship_title,
        );

        return view('back_end.preference.admin_advisor_selection.edit',['internshipId' => $internshipId])->with($data);
    }
 
    public function update(Request $request, $internshipId, $id)
    {
        $studentRequest = StudentRequest::findOrFail($id);
     
        // Validate the incoming request data
        $request->validate([
             'internship_id' => 'required|exists:internships,id',
             'student_id' => 'required|exists:users,id',
             'advisor_id' => 'required|exists:users,id',
             'status' => 'required|in:Accepted,Pending,Rejected',
        ]);
     
        $existingRequest = StudentRequest::where('internship_id', $request->input('internship_id'))
             ->where('advisor_id', $request->input('advisor_id'))
             ->where('student_id', $request->input('student_id'))
             ->where('id', '!=', $studentRequest->id)
             ->exists();
    
        if ($existingRequest) {
             return redirect()->back()->withErrors('This advisor and student combination for the internship already exists.');
        }
     
        $requestData = $request->only(['internship_id', 'student_id', 'advisor_id', 'status']);
     
        if ($studentRequest->update($requestData)) {
            return redirect()->route('admin_advisor_selection.index', ['internship' => $internshipId])->with('success', 'Advisor Selection updated successfully');
        }
        return back()->with('error', 'Request cannot be updated, please try again.');
    }

    public function destroy($internshipId,$id)
    {
        $studentRequest = StudentRequest::find($id);

        if ($studentRequest->delete()) {
            return redirect()->route('admin_advisor_selection.index', ['internship' => $internshipId])->with('success', 'Request deleted successfully.');
        }
        return back()->with('error', 'Failed to delete the request. Please try again.');
     }
}
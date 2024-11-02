<?php

namespace App\Http\Controllers;

use App\Models\InternshipAdvisorStudent;
use App\Http\Requests\StoreInternshipAdvisorStudentRequest;
use App\Http\Requests\UpdateInternshipAdvisorStudentRequest;
use App\Http\Requests\UpdateInternshipRequest;
use App\Models\Internship;
use App\Models\User;
use LDAP\Result;
use Illuminate\Database\QueryException;

class InternshipAdvisorStudentController extends Controller
{
    public function index()
    {
        $results = InternshipAdvisorStudent::paginate(10);

        return view('back_end.preference.internship_advisor_student.index')->with(['results' => $results]);
    }

    public function create()
    {
        $internships = Internship::get();

        $students = User::whereHas('role' , function($q){
            $q->where('role_name','student');
        })->get();

        $advisors = User::whereHas('role', function($q){
            $q->where('role_name', 'advisor');
        })->get();

        return view('back_end.preference.internship_advisor_student.create', compact('internships','students','advisors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInternshipAdvisorStudentRequest $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'internship_id' => 'required|exists:internships,id',
            'user_student_id' => 'required|exists:users,id',
            'user_advisor_id' => 'required|exists:users,id',
        ]);

        // Check if the advisor already has 3 students for this internship
        $advisorStudentCount = InternshipAdvisorStudent::where('user_advisor_id', $validatedData['user_advisor_id'])
                            ->where('internship_id', $validatedData['internship_id'])
                            ->count();

        if ($advisorStudentCount >= 3) {
            // Return with an error if advisor already has 3 students
            return redirect()->back()->withErrors(['error' => 'This advisor already has 3 students for this internship.']);
        }

        try {
            // Attempt to create the record
            $internshipAdvisorStudent = InternshipAdvisorStudent::create([
                'internship_id' => $validatedData['internship_id'],
                'user_student_id' => $validatedData['user_student_id'],
                'user_advisor_id' => $validatedData['user_advisor_id'],
            ]);

            // Redirect to index with success message if creation is successful
            return redirect()->route('internship_advisor_student.index')->with('success', 'Internship Advisor Student created successfully');

        } catch (QueryException $exception) {
            // Check for unique constraint violation (error code 23000)
            if ($exception->getCode() == 23000) {
                // Return with a specific error message for unique constraint violation
                return redirect()->back()->withErrors(['error' => 'A unique constraint violation occurred: This advisor already has this student for the selected internship.']);
            }

            // Catch any other database-related errors
            return redirect()->back()->withErrors(['error' => 'An error occurred while creating the Internship Advisor Student. Please try again.']);
        }

    }

    public function show(InternshipAdvisorStudent $internshipAdvisorStudent)
    {
        //
    }

    
    public function edit(InternshipAdvisorStudent $internshipAdvisorStudent)
    {
        // $internshipAdvisorStudent = InternshipAdvisorStudent::get();

        $internships = Internship::get();

        $students = User::whereHas('role' , function($q){
            $q->where('role_name','student');
        })->get();

        $advisors = User::whereHas('role', function($q){
            $q->where('role_name', 'advisor');
        })->get();

        return view('back_end.preference.internship_advisor_student.edit', compact('internships','students','advisors','internshipAdvisorStudent'));
    }

    // VERSION 1 (UPDATE)
    // public function update(UpdateInternshipAdvisorStudentRequest $request, InternshipAdvisorStudent $internshipAdvisorStudent)
    // {
    //     $validatedData = $request->validate([
    //         'internship_id' => 'required|',
    //         'user_student_id' => 'required|exists:users,id',
    //         'user_advisor_id' => 'required|exists:users,id',
    //     ]);

    //     // Check if the advisor already has 3 students for this internship
    //     $advisorStudentCount = InternshipAdvisorStudent::advisorStudentCount($validatedData['user_advisor_id'], $validatedData['internship_id']);
        
    //     if ($advisorStudentCount > 3 && $internshipAdvisorStudent->user_advisor_id != $validatedData['user_advisor_id']) {
    //         return back()->with('error', 'This advisor already has 3 students for this internship.');
    //     }

    //     if($internshipAdvisorStudent->update($validatedData)){
    //         return redirect()->route('internship_advisor_student.index')->with('success', "internship advisor student updated successfully!");
    //     }
    //     return back()->with('error','An error occureed with updating the internship advisor student');
    // }

    // VERSION 2 (UPDATE: Add Condition + TRY/catch)
    public function update(UpdateInternshipRequest $request, InternshipAdvisorStudent $internshipAdvisorStudent){

        $validatedData = $request->validate([
            'internship_id' => 'required|exists:internships,id',
            'user_student_id' => 'required|exists:users,id',
            'user_advisor_id' => 'required|exists:users,id',
        ]);

        // Check the number of students assigned to this advisor for the given internship
        $advisorStudentCount = InternshipAdvisorStudent::where('user_advisor_id', $validatedData['user_advisor_id'])
            ->where('internship_id', $validatedData['internship_id'])
            ->where('id', '!=', $internshipAdvisorStudent->id) // Exclude the current record
            ->count();

        // If advisor already has 3 students, deny the update
        if ($advisorStudentCount >= 3) {
        return back()->with('error', 'This advisor already has 3 students for this internship.');
        }

        // $advisorStudentCount = InternshipAdvisorStudent::advisorStudentCount($validatedData['user_advisor_id'], $validatedData['internship_id']);

        // // Check if advisor already has 3 student
        // if($advisorStudentCount >= 3 && $internshipAdvisorStudent->user_advisor_id != $validatedData['user_advisor_id']){
        //     return back()->with('error', 'this advisor already has 3 students for this internship.');
        // }

        try{
            // Update the existing record
            $internshipAdvisorStudent->update([
                'internship_id' => $validatedData['internship_id'],
                'user_student_id' => $validatedData['user_student_id'],
                'user_advisor_id' => $validatedData['user_advisor_id'],
            ]);

            return redirect()->route('internship_advisor_student.index')->with('success','Internship Advisor Student updated successfully');
        } catch (QueryException $exception){
            if ($exception->getCode() == 23000){
                return redirect()->back()->withErrors(['error' => 'A unique constraint violation occurred: This advisor already has this student for the selected internship.']);
            }

            // Handle any other database errors
            return redirect()->back()->withErrors(['error' => 'An error occurred while updating the Internship Advisor Student.']);
        } 
    }

    public function destroy(InternshipAdvisorStudent $internshipAdvisorStudent)
    {
        $internshipAdvisorStudent->delete();
        
        return back()->with('success','Internship advisor student deleted successfully');
    }
}

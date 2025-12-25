<?php

namespace App\Http\Controllers;

use App\Models\InternshipProject;
use App\Models\User;
use App\Http\Requests\StoreInternshipProjectRequest;
use App\Http\Requests\UpdateInternshipProjectRequest;
use App\Http\Controllers\Auth;
use App\Models\Internship;
use App\Models\StudentRequest;

class InternshipProjectController extends Controller
{
    public function index()
    {
        $results = InternshipProject::with('studentRequest.student', 'studentRequest.advisor', 'studentRequest.internship')->paginate(10);

        return view('back_end.preference.internship_project.index', compact('results'));
    }

    public function create()
    {

        $acceptedStudentRequests = StudentRequest::with(['student', 'advisor', 'internship'])
            ->where('status', 'accepted')
            ->get();

        $students = User::whereHas('role', function ($q) {
            $q->where('role_name', 'student');
        })->get();

        $advisors = User::whereHas('role', function ($q) {
            $q->where('role_name', 'advisor');
        })->get();

        $internships = Internship::get();

        return view('back_end.preference.internship_project.create', compact('students', 'advisors', 'internships', 'acceptedStudentRequests'));
    }

    public function store(StoreInternshipProjectRequest $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'student_request_id' => 'required|exists:student_requests,id',
            'project_name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Check if the student request already exists in the InternshipProject table
        $existingProject = InternshipProject::where('student_request_id', $validatedData['student_request_id'])->first();

        if ($existingProject) {
            return redirect()->back()->with('error', 'An internship project for this student request already exists.');
        }

        // Create a new internship project
        $internshipProject = InternshipProject::create([
            'student_request_id' => $validatedData['student_request_id'],
            'project_name' => $validatedData['project_name'],
            'description' => $validatedData['description'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
        ]);

        if ($internshipProject) {
            return redirect()->route('internship_project.index')->with('success', 'Internship Project created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create Internship Project. Please try again.');
        }
    }

    public function show($id)
    {
        $internshipProject = InternshipProject::with(['student', 'advisor'])->find($id);

        return view('back_end.preference.internship_project.show', compact('internshipProject'));
    }

    public function edit(InternshipProject $internshipProject)
    {
        $studentRequest = $internshipProject->studentRequest;

        $acceptedStudentRequests = StudentRequest::with(['student', 'advisor', 'internship'])
            ->where('status', 'accepted')
            ->get();

        return view('back_end.preference.internship_project.edit', compact('internshipProject', 'studentRequest', 'acceptedStudentRequests'));
    }

    public function update(UpdateInternshipProjectRequest $request, InternshipProject $internshipProject)
    {
        // Validate the request
        $validatedData = $request->validate([
            'student_request_id' => 'required|exists:student_requests,id',
            'project_name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Check if another project with the same student_request_id exists
        $existingProject = InternshipProject::where('student_request_id', $validatedData['student_request_id'])
            ->where('id', '!=', $internshipProject->id) // Exclude the current project
            ->first();

        if ($existingProject) {
            return redirect()->back()->with('error', 'An internship project for this student request already exists.');
        }

        // Try to update the internship project
        try {
            $internshipProject->update([
                'student_request_id' => $validatedData['student_request_id'],
                'project_name' => $validatedData['project_name'],
                'description' => $validatedData['description'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
            ]);

            return redirect()->route('internship_project.index')->with('success', 'Internship Project updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update Internship Project. Please try again.');
        }
    }

    public function destroy(InternshipProject $internshipProject)
    {
        $internshipProject->delete();
        return redirect()->route('internship_project.index')->with('success', 'Internship Project Deleted successfully');
    }
}

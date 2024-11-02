<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentRequest;
use App\Models\ThesisDocument;
use Illuminate\Support\Facades\Auth;
use App\Models\Internship;
use App\Models\InternshipAdvisorStudent;
use App\Models\Company;
use App\Models\Category;
use App\Models\User;

class AdvisorThesisDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentAdvisor = Auth::user();  // Get the logged-in advisor

        // Fetch all thesis documents where the advisor is assigned via student_request
        $results = ThesisDocument::whereHas('student_request', function($query) use ($currentAdvisor) {
            $query->where('advisor_id', $currentAdvisor->id);
        })->paginate(10);

        // dd($results);
        return view('back_end.preference.advisor.thesis_document.index', compact('results','request'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $id)
    {
        // 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:submitted,accepted,rejected',
        ]);
    
        // dd($id);

        // Find the thesis document using the ID passed in the URL
        $thesis_document = ThesisDocument::find($id);
    
        if (!$thesis_document) {
            return back()->withErrors('Thesis document not found.');
        }
    
        // Update the status of the thesis document
        $thesis_document->update([
            'status' => $validatedData['status'],
        ]);
    
        return redirect()->route('advisor_thesis_document.index')->with('success', 'Thesis document status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

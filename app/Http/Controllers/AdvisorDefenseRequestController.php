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
use App\Models\DefenseRequest;

class AdvisorDefenseRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentAdvisor = Auth::user();

        $results = DefenseRequest::whereHas('thesisDocument.student_request', function($q) use ($currentAdvisor){
            $q->where('advisor_id',$currentAdvisor->id);
        })->paginate(10);
        
        return view('back_end.preference.advisor.defense_request.index', compact('results','request'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $defense_request = DefenseRequest::find($id);

        if(!$defense_request){
            return back()->withErrors('Defense Request is not Found');
        }

        $defense_request->update([
            'status' => $validatedData['status'],
        ]);

        return redirect()->route('advisor_defense_request.index')->with('success','Defense Request Status Update Successfully');
    }

    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DefenseEnrollment;
use Illuminate\Support\Facades\Auth;
use App\Models\JuryGroup;

class JuryDefenseEnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the currently logged-in jury user
        $currentJury = Auth::user();

        // Fetch the jury groups the current jury member is involved in
        $juryGroups = JuryGroup::where(function ($query) use ($currentJury) {
            $query->where('user_jury1_id', $currentJury->id)
                ->orWhere('user_jury2_id', $currentJury->id)
                ->orWhere('user_jury3_id', $currentJury->id)
                ->orWhere('user_jury4_id', $currentJury->id);
        })->pluck('id');  // Get the jury group IDs

        // Check if the jury member is assigned to any groups
        if ($juryGroups->isEmpty()) {
            // If no groups are found, return an empty result
            $results = DefenseEnrollment::where('id', -1)->paginate(10);
        } else {
            // Fetch the DefenseEnrollment records that match the jury's assigned groups
            $results = DefenseEnrollment::whereIn('jury_group_id', $juryGroups)->paginate(10);
        }

        return view('back_end.preference.jury.defense_enrollment.index')->with(['results' => $results]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

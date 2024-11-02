<?php

namespace App\Http\Controllers;

use App\Models\JuryGroup;
use App\Http\Requests\StoreJuryGroupRequest;
use App\Http\Requests\UpdateJuryGroupRequest;
use App\Models\Internship;
use App\Models\User;
use App\Models\UserRole;

class JuryGroupController extends Controller
{

    public function index()
    {
        $results = JuryGroup::paginate(10);

        return view('back_end.preference.jury_group.index')->with(['results' => $results]);
    }


    public function create()
    {
        $internships = Internship::get();

        $jurys = User::whereHas('role', function($query){
            $query->where('role_name','jury');
        })->get();

        $data = array(
            'internships' => $internships,
            'jurys' => $jurys,
        );
        
        return view('back_end.preference.jury_group.create')->with($data);
    }

    public function getJuryGroup($id)
    {
        $juryGroup = JuryGroup::find($id);

        if ($juryGroup) {
            return response()->json([
                'internship_id' => $juryGroup->internship->id ?? 'N/A',
                'internship_title' => $juryGroup->internship->internship_title ?? 'N/A',
                'jury1' => $juryGroup->jury1->name ?? 'N/A',
                'jury2' => $juryGroup->jury2->name ?? 'N/A',
                'jury3' => $juryGroup->jury3->name ?? 'N/A',
                'jury4' => $juryGroup->jury4->name ?? 'N/A',
            ]);
        }

        return response()->json([
            'error' => 'Jury Group not found'
        ], 404);
    }

    public function store(StoreJuryGroupRequest $request)
    {
        
        $validatedData = $request->validate([
            'internship_id' => 'required|exists:internships,id',
            'user_jury1_id' => 'required|different:user_jury2_id|different:user_jury3_id|different:user_jury4_id|exists:users,id',
            'user_jury2_id' => 'required|different:user_jury1_id|different:user_jury3_id|different:user_jury4_id|exists:users,id',
            'user_jury3_id' => 'required|different:user_jury1_id|different:user_jury2_id|different:user_jury4_id|exists:users,id',
            'user_jury4_id' => 'required|different:user_jury1_id|different:user_jury2_id|different:user_jury3_id|exists:users,id',
        ]);

    // Create the JuryGroup with the validated data
        JuryGroup::create([
            'internship_id' => $validatedData['internship_id'],
            'user_jury1_id' => $validatedData['user_jury1_id'],
            'user_jury2_id' => $validatedData['user_jury2_id'],
            'user_jury3_id' => $validatedData['user_jury3_id'],
            'user_jury4_id' => $validatedData['user_jury4_id'],
        ]);

        // Redirect back to the Jury Group index page with a success message
        return redirect()->route('jury_group.index')->with('success', 'Jury Group created successfully!');
    }

    public function show(JuryGroup $juryGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JuryGroup $juryGroup)
    {
        
         // Fetch all internships
        $internships = Internship::get();

        // Fetch all users with the role of 'jury'
        $jurys = User::whereHas('role', function($query){
            $query->where('role_name', 'jury');
        })->get();

        // Pass data to the view, including the specific JuryGroup data for editing
        return view('back_end.preference.jury_group.edit', compact('juryGroup', 'internships', 'jurys'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJuryGroupRequest $request, JuryGroup $juryGroup)
    {
        // Validate the request to ensure unique jurors and valid internship
        $validatedData = $request->validate([
            'internship_id' => 'required|exists:internships,id',
            'user_jury1_id' => 'required|different:user_jury2_id|different:user_jury3_id|different:user_jury4_id|exists:users,id',
            'user_jury2_id' => 'required|different:user_jury1_id|different:user_jury3_id|different:user_jury4_id|exists:users,id',
            'user_jury3_id' => 'required|different:user_jury1_id|different:user_jury2_id|different:user_jury4_id|exists:users,id',
            'user_jury4_id' => 'required|different:user_jury1_id|different:user_jury2_id|different:user_jury3_id|exists:users,id',
        ]);

        // Update the Juryroup
        $juryGroup->update($validatedData);

        // Redirect with a success message including the JuryGroup ID
        return redirect()->route('jury_group.index')->with('success', "Jury Group ID: {$juryGroup->id} updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JuryGroup $juryGroup)
    {
        $juryGroup->delete();

        return redirect()->route('jury_group.index')->with('success', "Jury Group ID: {$juryGroup->id} deleted successfully.");
    }
}

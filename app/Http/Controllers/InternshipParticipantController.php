<?php

namespace App\Http\Controllers;

use App\Models\InternshipParticipant;
use App\Http\Requests\StoreInternshipParticipantRequest;
use App\Http\Requests\UpdateInternshipParticipantRequest;
use App\Models\Internship;
use App\Models\User;

class InternshipParticipantController extends Controller
{

    public function index($id)
    {
        $internship = Internship::with('participants')->findOrFail($id);
        $participants = $internship->participants;
        
        return view('back_end.preference.internship_participant.index', compact('internship', 'participants'));
    }

    // internship_participant

    public function create()
    {
        //
    }

    public function store(StoreInternshipParticipantRequest $request, $internshipId)
    {
        $request->validate([
            'user_id' => 'required|array',
            'user_id.*' => 'exists:users,id',
        ]);
    
        // PARAMETER
        $internship = Internship::findOrFail($internshipId);
    
        $userIds = $request->input('user_id');
    
        // Use 'users.id' in the pluck method to avoid ambiguity in the query
        $existingParticipantIds = $internship->participants()->pluck('users.id')->toArray();
    
        // Separate new and duplicate user IDs
        $newUserIds = array_diff($userIds, $existingParticipantIds);
        $duplicateUserIds = array_intersect($userIds, $existingParticipantIds);
    
        // Attach only new users to prevent duplicates
        if (!empty($newUserIds)) {
            $internship->participants()->attach($newUserIds);
        }
    
        // Prepare the messages
        $successMessage = null;
        $errorMessage = null;

        if (!empty($newUserIds)) {
            $successMessage = 'New participants added successfully.';
        }
        if (!empty($duplicateUserIds)) {
            $duplicateNames = User::whereIn('id', $duplicateUserIds)->pluck('name')->toArray();
            $errorMessage = 'The following participants were already added: ' . implode(', ', $duplicateNames) . '.';
        }

        // Redirect with conditional messages
        return redirect()->route('internships_participants.index', $internshipId)
                        ->with('success', $successMessage)
                        ->with('error', $errorMessage);
    }

    public function show(InternshipParticipant $internshipParticipant)
    {
        //
    }

    public function edit(InternshipParticipant $internshipParticipant)
    {
        //
    }

    public function update(UpdateInternshipParticipantRequest $request, InternshipParticipant $internshipParticipant)
    {
        //
    }

    public function destroy($internshipId, $userId)
    {
        $internship = Internship::findOrFail($internshipId);

        // Detach the user from the internship
        $internship->participants()->detach($userId);

        return redirect()->route('internships_participants.index', $internshipId)
                        ->with('success', 'Participant removed successfully');
    }
}

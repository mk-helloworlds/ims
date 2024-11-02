<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DefenseEnrollment;
use App\Models\Evaluation;
use Illuminate\Support\Facades\Auth;
use App\Models\JuryGroup;
use App\Models\EvaluationQuestion;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class JuryEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentJury = Auth::user();

        $juryGroups = JuryGroup::where(function ($query) use ($currentJury) {
             $query->where('user_jury1_id', $currentJury->id)
                 ->orWhere('user_jury2_id', $currentJury->id)
                 ->orWhere('user_jury3_id', $currentJury->id)
                 ->orWhere('user_jury4_id', $currentJury->id);
        })->pluck('id');
 
        if ($juryGroups->isEmpty()) {
             $results = DefenseEnrollment::where('id', -1)->paginate(10);
        } else {
             $results = DefenseEnrollment::whereIn('jury_group_id', $juryGroups)->paginate(10);
        }

        $data = array(
            'currentJury' => $currentJury,
            'results' => $results,
        );
 
        return view('back_end.preference.jury.evaluation.index')->with($data);
    }

    public function show(string $enrollment_id)
    {
        $currentJury = Auth::user();

        $defenseEnrollment = DefenseEnrollment::with([
            'defenseRequest.thesisDocument.student_request.student',
            'evaluations' => function ($query) use ($currentJury) {
                // Filter evaluations by the current jury member
                $query->where('user_jury_id', $currentJury->id);
            },
            'juryGroup'
        ])->findOrFail($enrollment_id);

        $totalScore = $defenseEnrollment->evaluations->sum('score');

        $data = array(
            'defenseEnrollment' => $defenseEnrollment,
            'currentJury' => $currentJury,
            'totalScore' => $totalScore, // Pass the total score to the view
        );

        return view('back_end.preference.jury.evaluation.show')->with($data);  
    }

    public function create($defenseEnrollment)
    {
        $currentJury = Auth::user();

        $evaluationQuestions = EvaluationQuestion::all();

        $defenseEnrollment = DefenseEnrollment::with([
            'defenseRequest.thesisDocument.student_request.student',
            'evaluations',
            'juryGroup'
        ])->findOrFail($defenseEnrollment);

        $totalScore = $defenseEnrollment->evaluations->sum('score');

        $data = [
            'defenseEnrollment' => $defenseEnrollment,
            'currentJury' => $currentJury,
            'evaluationQuestions' => $evaluationQuestions,
            'totalScore' => $totalScore,
        ];
        return view('back_end.preference.jury.evaluation.create')->with($data);
    }

    public function store(Request $request)
    {
        $currentJury = Auth::user();

        $defenseEnrollment = DefenseEnrollment::with(['defenseRequest.thesisDocument.student_request.student'])
            ->findOrFail($request->input('defense_enrollment_id'));

        $userStudentId = $defenseEnrollment->defenseRequest->thesisDocument->student_request->student->id;

        $evaluations = $request->input('evaluations');
        $defenseEnrollmentId = $defenseEnrollment->id;

        $jury_evaluation = $defenseEnrollmentId;

        foreach ($evaluations as $questionId => $evaluationData) {
            $existingEvaluation = DB::table('evaluations')
                ->where('defense_enrollment_id', $defenseEnrollmentId)
                ->where('user_jury_id', $currentJury->id)
                ->where('question_id', $questionId)
                ->first();

            if ($existingEvaluation) {
                continue; 
            }
            
        DB::table('evaluations')->insert([
            'user_student_id' => $userStudentId, 
            'user_jury_id' => $currentJury->id,
            'defense_enrollment_id' => $defenseEnrollmentId,
            'question_id' => $questionId,
            'score' => $evaluationData['score'],
            'feedback' => $evaluationData['feedback'],
            'note' => $evaluationData['note'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

        return redirect()->route('jury_evaluation.show', $defenseEnrollmentId)->with('success', 'Evaluation successfully saved.');
    }

    public function edit($evaluation_id)
    {
        $evaluation = Evaluation::findOrFail($evaluation_id);

        if (!$evaluation) {
            return redirect()->back()->with('error', 'Evaluation not found.');
        }

        return view('back_end.preference.jury.evaluation.edit', compact('evaluation'));
    }

    public function update(Request $request, $evaluation_id)
    {
        $request->validate([
            'score' => 'required|integer|min:1|max:10',
            'feedback' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        DB::table('evaluations')->where('id', $evaluation_id)->update([
            'score' => $request->input('score'),
            'feedback' => $request->input('feedback'),
            'note' => $request->input('note'),
            'updated_at' => now(),
        ]);

        return redirect()->route('jury_evaluation.show', ['jury_evaluation' => $request->input('defense_enrollment_id')])->with('success', 'Evaluation updated successfully.');
    }

    public function destroy($evaluation_id)
    {
        $evaluation = Evaluation::findOrFail($evaluation_id);

        // Check if evaluation exists before attempting to delete
        if (!$evaluation) {
            return redirect()->back()->with('error', 'Evaluation not found.');
        }

        // Delete the evaluation
        $evaluation->delete();

        // Redirect back to the show page with a success message
        return redirect()->route('jury_evaluation.show', ['jury_evaluation' => $evaluation->defense_enrollment_id])
            ->with('success', 'Evaluation deleted successfully.');
    }

    public function deleteAllEvaluations($enrollment_id)
    {
        $currentJury = Auth::user();

        DB::table('evaluations')
            ->where('defense_enrollment_id', $enrollment_id)
            ->where('user_jury_id', $currentJury->id)
            ->delete();

        return redirect()->route('jury_evaluation.show', $enrollment_id)
        ->with('success', 'All your evaluations have been deleted.');
    }

    public function markAsCompleted($enrollment_id)
    {
        // Find the defense enrollment record
        $defenseEnrollment = DefenseEnrollment::findOrFail($enrollment_id);

        // Update the status to 'Completed'
        $defenseEnrollment->status = 'Completed';
        $defenseEnrollment->save();

        // Redirect back to the index with a success message
        return redirect()->route('jury_evaluation.index')->with('success', 'The defense has been marked as completed.');
    }



}

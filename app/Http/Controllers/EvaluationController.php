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
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreEvaluationRequest;

class EvaluationController extends Controller
{
    public function index()
    {
        // Fetch jury groups that the current user is associated with
        $juryGroups = JuryGroup::select('id')->get();

        // Get the relevant defense enrollments associated with those jury groups
        $results = DefenseEnrollment::whereIn('jury_group_id', $juryGroups)->paginate(10);

        // Iterate through each defense enrollment to check the scores
        foreach ($results as $defenseEnrollment) {
            $juryGroup = $defenseEnrollment->juryGroup;

            // Initialize the flag for marking as completed
            $markAsCompleted = true;

            // Check total score for each jury member in the group
            foreach (['user_jury1_id', 'user_jury2_id', 'user_jury3_id', 'user_jury4_id'] as $juryColumn) {
                $juryId = $juryGroup->$juryColumn;
                
                // Sum the scores for the current jury member
                $totalScore = Evaluation::where('defense_enrollment_id', $defenseEnrollment->id)
                                        ->where('user_jury_id', $juryId)
                                        ->sum('score');

                // If any jury member has a total score of 10 or less, mark this as not completed
                if ($totalScore <= 10) {
                    $markAsCompleted = false;
                    break;
                }
            }

            // If all juries have a score > 10, mark the defense as completed
            if ($markAsCompleted) {
                if ($defenseEnrollment->status === 'Scheduled') {
                    $defenseEnrollment->status = 'Completed';
                    $defenseEnrollment->save();
                }
            } else {
                // If any jury member's score drops below or equal to 10, revert the status back to "Scheduled"
                if ($defenseEnrollment->status === 'Completed') {
                    $defenseEnrollment->status = 'Scheduled';
                    $defenseEnrollment->save();
                }
            }
        }

        $data = array(
            'results' => $results,
        );

        return view('back_end.preference.evaluation.index')->with($data);
    }

    public function filterByJury($defense_enrollment_id, $jury_id)
    {
        $defenseEnrollment = DefenseEnrollment::with([
            'defenseRequest.thesisDocument.student_request.student',
            'juryGroup',
            'evaluations' => function ($query) use ($jury_id) {
                // Filter evaluations by the specific jury member
                $query->where('user_jury_id', $jury_id);
            }
        ])->findOrFail($defense_enrollment_id);

        $juryMember = User::find($jury_id); // Assuming User is your model for jury members

        // Calculate the total score for this jury member
        $totalScore = $defenseEnrollment->evaluations->sum('score');

        return view('back_end.preference.evaluation.show')
            ->with([
                'defenseEnrollment' => $defenseEnrollment,
                'juryMember' => $juryMember,
                'totalScore' => $totalScore
            ]);
    }

    // public function show(Evaluation $evaluation)
    // {

    // }

    public function create($defense_enrollment_id, $jury_id)
    {
        // Fetch all the evaluation questions
        $evaluationQuestions = EvaluationQuestion::all();

        // Fetch the defense enrollment data along with related data
        $defenseEnrollment = DefenseEnrollment::with([
            'defenseRequest.thesisDocument.student_request.student',  // Get the student details
            'juryGroup',  // Get the jury group details
            'evaluations' // Fetch the evaluations
        ])->findOrFail($defense_enrollment_id);

        // Optionally, calculate total score for the evaluations
        $totalScore = $defenseEnrollment->evaluations->sum('score');

        // Fetch the specific jury member information
        $juryMember = User::findOrFail($jury_id);

        // Pass the necessary data to the create view
        $data = [
            'defenseEnrollment' => $defenseEnrollment,
            'juryMember' => $juryMember,  
            'evaluationQuestions' => $evaluationQuestions,
            'totalScore' => $totalScore,
        ];

        // Render the create view with the passed data
        return view('back_end.preference.evaluation.create')->with($data);
    }

    public function store(StoreEvaluationRequest $request)
    {
        $defenseEnrollment = DefenseEnrollment::with(['defenseRequest.thesisDocument.student_request.student'])
            ->findOrFail($request->input('defense_enrollment_id'));

        $userStudentId = $defenseEnrollment->defenseRequest->thesisDocument->student_request->student->id;

        $evaluations = $request->input('evaluations');
        $defenseEnrollmentId = $defenseEnrollment->id;

        // Assuming the jury ID is passed from the form
        $juryId = $request->input('jury_id'); 

        foreach ($evaluations as $questionId => $evaluationData) {
            $existingEvaluation = DB::table('evaluations')
                ->where('defense_enrollment_id', $defenseEnrollmentId)
                ->where('user_jury_id', $juryId)
                ->where('question_id', $questionId)
                ->first();

            if ($existingEvaluation) {
                continue; 
            }

            DB::table('evaluations')->insert([
                'user_student_id' => $userStudentId, 
                'user_jury_id' => $juryId,
                'defense_enrollment_id' => $defenseEnrollmentId,
                'question_id' => $questionId,
                'score' => $evaluationData['score'],
                'feedback' => $evaluationData['feedback'],
                'note' => $evaluationData['note'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Redirect to the filterByJury method after successful submission
        return redirect()->route('evaluation.filter_by_jury', [$defenseEnrollmentId, $juryId])
            ->with('success', 'Evaluation successfully saved.');
    }
    

    // public function edit(Evaluation $evaluation)
    // {
        
    // }

    public function edit($evaluation_id)
    {
        // Fetch the specific evaluation by its ID
        $evaluation = Evaluation::findOrFail($evaluation_id);

        // Get the evaluation question associated with this evaluation (optional, if you need it)
        $evaluationQuestion = $evaluation->evaluationQuestion;

        // Pass the evaluation to the view to populate the edit form
        return view('back_end.preference.evaluation.edit', compact('evaluation', 'evaluationQuestion'));
    }

    // public function update(UpdateEvaluationRequest $request, Evaluation $evaluation)
    // {
    //     //
    // }

    public function update(Request $request, $evaluation_id)
    {
        // Validate the input data
        $request->validate([
            'score' => 'required|numeric|min:1|max:10',
            'feedback' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        // Find the specific evaluation to update
        $evaluation = Evaluation::findOrFail($evaluation_id);

        // Update the evaluation details
        $evaluation->score = $request->input('score');
        $evaluation->feedback = $request->input('feedback');
        $evaluation->note = $request->input('note');

        // Save the changes
        $evaluation->save();

        // Redirect back to the page showing evaluations for the defense and jury
        return redirect()->route('evaluation.filter_by_jury', [$evaluation->defense_enrollment_id, $evaluation->user_jury_id])
                        ->with('success', 'Evaluation updated successfully.');
    }

    public function destroy(Evaluation $evaluation)
    {
        // Get the defense enrollment ID and jury ID before deletion
        $defenseEnrollmentId = $evaluation->defense_enrollment_id;
        $juryId = $evaluation->user_jury_id;

        // Delete the evaluation
        $evaluation->delete();

        // Redirect back to the evaluation list for this defense enrollment and jury
        return redirect()->route('evaluation.filter_by_jury', [$defenseEnrollmentId, $juryId])
                        ->with('success', 'Evaluation deleted successfully.');
    }

    public function deleteAllEvaluations($defense_enrollment_id, $jury_id)
    {
        Evaluation::where('defense_enrollment_id', $defense_enrollment_id)
                ->where('user_jury_id', $jury_id)
                ->delete();

        return redirect()->route('evaluation.filter_by_jury', [$defense_enrollment_id, $jury_id])
                        ->with('success', 'All evaluations for this jury member have been deleted.');
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

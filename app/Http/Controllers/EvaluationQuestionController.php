<?php

namespace App\Http\Controllers;

use App\Models\EvaluationQuestion;
use App\Http\Requests\StoreEvaluationQuestionRequest;
use App\Http\Requests\UpdateEvaluationQuestionRequest;

class EvaluationQuestionController extends Controller
{
    public function index()
    {
        $results = EvaluationQuestion::paginate(10);

        return view('back_end.preference.evaluation_question.index')->with(['results' => $results]);
    }

    public function create()
    {
        $data = array(

        );

        return view('back_end.preference.evaluation_question.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEvaluationQuestionRequest $request)
    {
        $request->validate([
            'question_text' => 'required',
        ]);

        // If the Validation Pass the test -> Procceed with Storing data
        $evaluation_question = new EvaluationQuestion([
            'question_text' => $request->input('question_text'),
        ]);

        if ($evaluation_question->save()) {
            return redirect()->route('evaluation_question.index')->with('success', 'evaluation_question created successfully.');
        }

        return back()->with('error', 'evaluation_question Can not be created, Please try again.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EvaluationQuestion $evaluationQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EvaluationQuestion $evaluationQuestion)
    {
        $data = array(

        );

        return view('back_end.preference.evaluation_question.edit', compact('evaluationQuestion'))->with($data);
    }

    public function update(UpdateEvaluationQuestionRequest $request, EvaluationQuestion $evaluationQuestion)
    {
        $request->validate([
            'question_text' => 'required',
        ]);

        $requestData = [];
        
        foreach ($request->all() as $key => $value) {
            if (! empty($value)) {
                $requestData[$key] = $value;
            }
        }

        if ($evaluationQuestion->update($requestData)) {
            return redirect()->route('evaluation_question.index')->with('success', 'evaluation_question updated successfully!');
        }

        return back()->with('error', 'evaluation_question Can not be update, Please try again.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EvaluationQuestion $evaluationQuestion)
    {
        $evaluationQuestion->delete();

        return back()->with('success', 'evaluation_question Deleted Successfully.');
    }
}

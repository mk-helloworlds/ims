@extends('layouts.back-end')
@section('main-title')
Jury Name: {{ $juryMember->name }} | Defense Enrollment ID: {{ $defenseEnrollment->id }}
<div>
    <h3>
        Evaluate Student: 
        <b>
            {{ $defenseEnrollment->defenseRequest->thesisDocument->student_request->student->name }}
        </b>
    </h3>
</div>
<div>
    <h3>
        Defense Enrollment ID: 
        <b>
            {{ $defenseEnrollment->id }}
        </b>
    </h3>
</div>
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
?>
@section('body')

<!-- IMPORTING JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        console.log("jQuery is working!");
    });
</script>

<div id="success-message"></div>
    <div class="col-md-12 offset-sm">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Evaluation Form for Student: {{ $defenseEnrollment->defenseRequest->thesisDocument->student_request->student->name }}</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('evaluation.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="defense_enrollment_id" value="{{ $defenseEnrollment->id }}">
                    <input type="hidden" name="jury_id" value="{{ $juryMember->id }}">

                    <h4 class="mt-4">Evaluation Questions</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm mt-3 table-hover">
                            <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Score (1-10)</th>
                                    <th>Feedback</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($evaluationQuestions as $question)
                                    <tr>
                                        <td>{{ $question->question_text }}</td>
                                        <td>
                                            <input type="number" name="evaluations[{{ $question->id }}][score]" min="1" max="10" class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="text" name="evaluations[{{ $question->id }}][feedback]" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" name="evaluations[{{ $question->id }}][note]" class="form-control">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Form Submit Button -->
                    <div class="form-group">
                        <a href="{{ route('evaluation.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Evaluation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

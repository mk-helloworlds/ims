    @php use App\Http\Controllers\MyUtility; @endphp
    @extends('layouts.back-end')
    @section('main-title')
    JURY : EDIT : EVALUTION ID: {{$evaluation->id}}
    @endsection
    <?php
    $maps = array(
            "/"=>"ផ្ទាំងគ្រប់គ្រង",
        "#one"=>"FORM",
    );
    ?>
    @section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Evaluation</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('jury_evaluation.update', $evaluation->id) }}" method="POST">
                        @csrf
                        @method('PATCH')  

                        <div class="form-group">
                            <h1>
                            {{$evaluation->EvaluationQuestion->question_text}}
                            </h1>
                        </div>

                        <input type="hidden" name="defense_enrollment_id" value="{{ $evaluation->defense_enrollment_id }}">

                        <div class="form-group">
                            <label for="score">Score (1-10)</label>
                            <input type="number" name="score" class="form-control" min="1" max="10" value="{{ $evaluation->score }}" required>
                        </div>

                        <div class="form-group">
                            <label for="feedback">Feedback</label>
                            <textarea name="feedback" class="form-control">{{ $evaluation->feedback }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="note">Note</label>
                            <textarea name="note" class="form-control">{{ $evaluation->note }}</textarea>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('jury_evaluation.show', $evaluation->defense_enrollment_id) }}" class="btn btn-secondary">Cancel</a>

                            <button type="submit" class="btn btn-primary">Update Evaluation</button>
                        </div>
                        
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @php use App\Http\Controllers\MyUtility; @endphp
    @extends('layouts.back-end')
    @section('main-title')
    Edit Evaluation Question : {{$evaluation->question_id}}
    @endsection
    <?php
    $maps = array(
            "/"=>"ផ្ទាំងគ្រប់គ្រង",
        "#one"=>"FORM",
    );
    ?>
    @section('body')
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Evaluation</h4>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('evaluation.update', $evaluation->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <h3><b>
                            {{ $evaluation->evaluationQuestion->question_text }}
                            </b></h3>
                            
                        </div>
                        

                        <div class="form-group">
                            <label for="score">Score (1-10)</label>
                            <input type="number" name="score" class="form-control" min="1" max="10" value="{{ old('score', $evaluation->score) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="feedback">Feedback</label>
                            <textarea name="feedback" class="form-control">{{ old('feedback', $evaluation->feedback) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="note">Note</label>
                            <textarea name="note" class="form-control">{{ old('note', $evaluation->note) }}</textarea>
                        </div>

                        <div class="form-group">
                            <a href="{{ route('evaluation.filter_by_jury', [$evaluation->defense_enrollment_id, $evaluation->user_jury_id]) }}" class="btn btn-secondary">Cancel</a>

                            <button type="submit" class="btn btn-primary">Update Evaluation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection

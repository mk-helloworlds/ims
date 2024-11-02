@php use App\Http\Controllers\MyUtility; @endphp
@extends('layouts.back-end')
@section('main-title')
EDIT : JURY GROUP 
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
                <div class="card-body">
                        @if($errors->all())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Validation Error!</strong> Please make sure the following requirements are met:
                                        <ul>
                                            @foreach($errors->all() as $message)
                                                <li>{{ $message }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                </div>
                        @endif
                </div>

        <div class="col-md-12">

            <div class="card">

            <!-- CONFIGURE THE ROUTE for Update  -->
                <form id="jury_group-form" action="{{ route('evaluation_question.update',$evaluationQuestion->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    
                    @csrf
                    <div class="card-body row">
                        <div class="col-md-12">

                        <!-- QUESTION TEXT -->

                        <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">

                                    <label for="question_text">QUESTION TEXT<span class="required-label">*</span></label>

                                    <textarea rows="4" name="question_text" id="question_text" class="form-control" placeholder="Question_text" required>{{ old('question_text', $evaluationQuestion->question_text) }}</textarea>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <a href="{{route('evaluation_question.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>

                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                    <input type="hidden" value="{{request()->page}}" name="page">
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

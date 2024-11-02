@extends('layouts.back-end')
@section('main-title')
CREATE : JURY GROUP 
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
                    

                <form id="user-form" action="{{ route('evaluation_question.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body row">
                        
                        <div class="col-md-12">

                            <!-- QUESTION TEXT -->

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">

                                    <label for="question_text">QUESTION TEXT<span class="required-label">*</span></label>

                                    <textarea rows="4" name="question_text" id="question_text" class="form-control" placeholder="Question_text" required></textarea>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <a href="{{route('evaluation_question.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                             
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

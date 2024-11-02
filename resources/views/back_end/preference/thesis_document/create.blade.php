@extends('layouts.back-end')
@section('main-title')
ADMIN : CREATE THESIS DOCUMENTS 
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
$selectedInternshipId = 0;
?>
@section('body')

    <div class="row">
        <!-- Button trigger modal -->
        <div class="col-md-12">

            <div class="card">

                <form id="user-form" action="{{ route('thesis_document.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="card-body row">

                        @if($errors->all())
                            <div class="alert alert-danger bg-danger">
                               <ul>
                                @foreach($errors->all() as $message)
                                    <li>{{$message}}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="col-md-12">

                            <!-- FORM FOR SELECTING THE STUDENT -->
                            <div class="form-group">
                                <label for="user_student_id">STUDENT NAME</label>
                                <select name="user_student_id" id="user_student_id" class="form-control">
                                    <option value="">Please Select Student</option>

                                    <!-- Loop through the students -->
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">
                                            {{ $student->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- FORM FOR SELECTING THE ADVISOR -->
                            <div class="form-group">
                                <label for="user_advisor_id">ADVISOR NAME</label>
                                <select name="user_advisor_id" id="user_advisor_id" class="form-control">
                                    <option value="">Please Select Advisor</option>

                                    <!-- Loop through the students -->
                                    @foreach($advisors as $advisor)
                                        <option value="{{ $advisor->id }}">
                                            {{ $advisor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- FORM FOR SELECTING THE INTERNSHIP -->
                            <div class="form-group">
                                <label for="internship_id">INTERNSHIP</label>
                                <select name="internship_id" id="internship_id" class="form-control">
                                    <option value="">Please Select Internship</option>

                                    <!-- Loop through the students -->
                                    @foreach($internships as $internship)
                                        <option value="{{ $internship->id }}">
                                            {{ $internship->internship_title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- STUDENT THESIS DOCUMENT FORM -->

                            <div class="form-group mb-3">
									<label for="student_thesis" >STUDENT THESIS DOCUMENT</label>

									<input type="file" class="form-control-file form-control" id="student_thesis" name="student_thesis" required>
							</div>

                            <!-- STATUS SELECTION -->
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Please Select Status</option>

                                    <option value="submitted" >Submitted</option>
                                    
                                    <option value="accepted" >Accepted</option>

                                    <option value="rejected" >Rejected</option>

                                </select>
                            </div>

                    <div class="col-md-12">
                        <a href="{{route('thesis_document.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                         
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                

            </div>
        </div>
    </div>
    
@endsection

@extends('layouts.back-end')
@section('main-title')
ADMIN : CREATE DEFENSE REQUEST
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
$selectedInternshipId = 0;
?>
@section('body')
        <div class="col-md-12">
            <div class="card">
                <form id="user-form" action="{{ route('admin_defense_request.store') }}" method="post" enctype="multipart/form-data">
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

                            <!-- STATUS SELECTION -->
                            <div class="form-group">
                                <label for="status">STATUS</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Please Select Status</option>
                                    <option value="pending" >Pending</option>
                                    <option value="approved" >Approved</option>
                                    <option value="rejected" >Rejected</option>
                                </select>
                            </div>

                            <!-- FEEDBACK -->

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">

                                    <label for="feedback">Feedback<span class="required-label">*</span></label>

                                    <textarea rows="2" name="feedback" id="feedback" class="form-control" placeholder="feedback" ></textarea>

                                </div>
                            </div>
                            
                            <div class="form-group">
                                    <a href="{{route('admin_defense_request.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                                     
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                </form>
                

            </div>
        </div>
    </div>
    
@endsection

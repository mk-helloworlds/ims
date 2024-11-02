@extends('layouts.back-end')
@section('main-title')
STUDENT : CREATE DEFENSE REQUEST
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

                <form id="user-form" action="{{ route('student_defense_request.store') }}" method="post" enctype="multipart/form-data">
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

                            <!-- AUTO SELECT STUDENT CURRENT AUTH -->
                            <div class="form-group col-md-12">
                                <label for="user_student_id">STUDENT</label>
                                <!-- Display the student's name in a read-only text input -->
                                <input type="text" class="form-control" id="user_student_name" name="user_student_name" value="{{ $currentStudent->name }}" readonly>
                                <!-- Store the student's ID in a hidden input to submit with the form -->
                                <input type="hidden" id="user_student_id" name="user_student_id" value="{{ $currentStudent->id }}">
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
                            <input type="hidden" id="status" name="status" value="pending">

                            

                    <div class="col-md-12">
                        <a href="{{route('student_defense_request.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                         
                        <button type="submit" class="btn btn-primary">REQUEST DEFENSE</button>
                    </div>
                </form>
                

            </div>
        </div>
    </div>
    
@endsection

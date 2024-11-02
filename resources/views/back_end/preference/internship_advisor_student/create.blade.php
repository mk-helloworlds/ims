@extends('layouts.back-end')
@section('main-title')
CREATE INTERNSHIP ADVISOR STUDENT 
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
?>
@section('body')
    <div class="row">
        <!-- Button trigger modal -->

        <div class="col-md-12">

            <div class="card">

                <form id="user-form" action="{{ route('internship_advisor_student.store') }}" method="post" enctype="multipart/form-data">
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

                            <!-- FORM FOR SELECTING THE INTERNSHIP ID -->
                            <div class="form-group">
                                <label for="internship_id">INTERNSHIP</label>
                                <select name="internship_id" id="internship_id" class="form-control">
                                    <option value="">Please Select Internship</option>

                                    <!-- Loop through the students -->
                                    @foreach($internships as $internship)
                                        <option value="{{ $internship->id }}">
                                            {{ $internship->id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- FORM FOR SELECTING THE STUDENT -->
                            <div class="form-group">
                                <label for="user_student_id">STUDENT</label>
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
                                <label for="user_advisor_id">ADVISOR</label>
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

                    <div class="col-md-12">
                        <a href="{{route('internship_advisor_student.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                         
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

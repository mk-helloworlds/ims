@php use App\Http\Controllers\MyUtility; @endphp
@extends('layouts.back-end')
@section('main-title')
    EDIT INTERNSHIP ADVISOR STUDENT
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

            <div class="card">

            <!-- CONFIGURE THE ROUTE for Update  -->
                <form id="user-form" action="{{ route('internship_advisor_student.update',$internshipAdvisorStudent->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    
                    @csrf
                    <div class="card-body row">
                        <div class="col-md-12">

                            <!-- FORM FOR SELECTING THE INTERNSHIP ID -->
                            <div class="form-group">
                                <label for="internship_id">INTERNSHIP</label>
                                <select name="internship_id" id="internship_id" class="form-control">
                                    <option value="">Please Select Internship</option>

                                    <!-- Loop through the students -->
                                    @foreach($internships as $internship)
                                        <option value="{{ $internship->id }}" {{$internship->id == $internshipAdvisorStudent->internship_id ? "selected" : ""}}> 
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
                                        <option value="{{ $student->id }}" {{$student->id == $internshipAdvisorStudent->user_student_id ? 'selected' : ''}}>
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
                                        <option value="{{ $advisor->id }}" {{$advisor->id == $internshipAdvisorStudent->user_advisor_id ? 'selected' : ""}}>
                                            {{ $advisor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    </div>

                    <div class="col-md-12">
                        <a href="{{route('internship_advisor_student.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                    <input type="hidden" value="{{request()->page}}" name="page">
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

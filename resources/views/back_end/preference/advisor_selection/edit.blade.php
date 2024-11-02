@php use App\Http\Controllers\MyUtility; @endphp
@extends('layouts.back-end')
@section('main-title')
    EDIT INTERNSHIP PROJECT
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

                <form id="internship_project_edit-form" action="{{ route('internship_project.update',
                $internshipProject->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')

                    @csrf
                    <div class="card-body row">
                        <div class="col-md-12">

                            <!-- STUDENT SELECTION -->

                            <div class="form-group">
                                <label for="user_student_id">Student's Name</label>
                                <select name="user_student_id" id="user_student_id" class="form-control">
                                    <option value="">Please Select Student</option>

                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{$internshipProject->user_student_id == $student->id ? "selected":""}}>
                                            {{ $student->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- ADVISOR SELECTION -->

                            <div class="form-group">
                                <label for="user_advisor_id">Advisor's Name</label>
                                <select name="user_advisor_id" id="user_advisor_id" class="form-control">
                                    <option value="">Please Select Advisor</option>
                                    @foreach($advisors as $advisor)
                                        <option value="{{ $advisor->id }}" {{ $internshipProject->user_advisor_id == $advisor->id ? 'selected' : '' }}>
                                            {{ $advisor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- PROJECT NAME -->

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">

                                    <label for="project_name">Project Name<span class="required-label">*</span></label>

                                    <input type="text" class="form-control" id="project_name" name="project_name"
                                    placeholder="Enter project_name" value="{{$internshipProject->project_name}}" required>

                                </div>
                            </div>

                            <!-- DESCRIPTION -->

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">

                                    <label for="description">Description<span class="required-label">*</span></label>

                                    <textarea rows="4" name="description" id="description" class="form-control" placeholder="Enter internship_project"  required>{{$internshipProject->description}}</textarea>

                                </div>
                            </div>

                            <!-- START DATE -->

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">

                                    <label for="start_date">Start Date <span class="required-label">*</span></label>

                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{$internshipProject->start_date}}" required>

                                </div>
                            </div>

                            <!-- END DATE -->

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="end_date">End Date<span class="required-label">*</span></label>

                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{$internshipProject->end_date}}" required>

                                </div>
                            </div>


                        </div>


                    </div>

                    <div class="col-md-12">
                        <!-- CANCEL BUTTON -->
                        <a href="{{route('internship_project.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>

                        <!-- SUBMIT BUTTON -->
                         <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
        </div>
    </div>
@endsection

@extends('layouts.back-end')
@section('main-title')
ADMIN : CREATE DEFENSE ENROLLMENT
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
?>
@section('body')

<!-- IMPORTING JQUERY -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        console.log("jQuery is working!");
    });
</script>

<div id="success-message"></div>


    <div class="row">

        <div class="col-md-12">

            <div class="card">

                <div class="card-body">
                        @if($errors->all())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                    

                <form id="defense_enrollment-form" action="{{ route('defense_enrollment.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body row">
                        
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

                                    <!-- Loop through the advisor -->
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

                                    <!-- Loop through the internship -->
                                    @foreach($internships as $internship)
                                        <option value="{{ $internship->id }}">
                                        ID {{$internship->id}} | {{ $internship->internship_title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>  

                            <!-- FORM FOR SELECTING THE JURY GROUP -->
                            <div class="form-group">
                                <label for="jury_group_id">JURY GROUP</label>
                                <select name="jury_group_id" id="jury_group_id" class="form-control">
                                    <option value="">Please Select JURY GROUP</option>
                                    @foreach($juryGroup as $j)
                                        <option value="{{ $j->id }}">
                                            Group {{ $j->id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Placeholder for displaying the jury names -->
                            <div class="form-group" id="jury-details">
                                <strong>JURY GROUP DETAILS:</strong>
                                <p id="internship_id">INTERNSHIP ID: <span></span></p>
                                <p id="internship_title">INTERNSHIP TITLE: <span></span></p>
                                <p id="jury1">Jury 1: <span></span></p>
                                <p id="jury2">Jury 2: <span></span></p>
                                <p id="jury3">Jury 3: <span></span></p>
                                <p id="jury4">Jury 4: <span></span></p>
                            </div>

                            <!-- Include jQuery and Script to Handle AJAX -->
                            <script>
                                $(document).ready(function() {
                                    $('#jury_group_id').change(function() {
                                        var groupId = $(this).val();
                                        if (groupId) {
                                            $.ajax({
                                                url: '/preference/get-jury-group/' + groupId,
                                                type: 'GET',
                                                success: function(response) {
                                                    $('#internship_id span').text(response.internship_id);
                                                    $('#internship_title span').text(response.internship_title);
                                                    $('#jury1 span').text(response.jury1);
                                                    $('#jury2 span').text(response.jury2);
                                                    $('#jury3 span').text(response.jury3);
                                                    $('#jury4 span').text(response.jury4);
                                                },
                                                error: function(error) {
                                                    console.log(error);
                                                }
                                            });
                                        }
                                    });
                                });
                            </script>

                            <!-- DEFENSE DATE -->
                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">

                                    <label for="defense_date">DEFENSE DATE <span class="required-label">*</span></label>

                                    <input type="date" class="form-control" id="defense_date" name="defense_date" required>
                                </div>
                            </div>

                            <!-- STATUS SELECTION -->
                            <div class="form-group">
                                <label for="status">STATUS</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Please Select Status</option>
                                    <option value="Scheduled" >Scheduled</option>
                                    <option value="Completed" >Completed</option>
                                </select>
                            </div>
                            
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <a href="{{route('defense_enrollment.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                             
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.back-end')
@section('main-title')
CREATE FOLLOW UP 
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
            <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

                <form id="user-form" action="{{ route('follow_up.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                            <!-- Student Request Selection (Optional) -->
                            <div class="form-group">
                                <label for="student_request_id">Select Student Request</label>
                                <select name="student_request_id" class="form-control">
                                    <option value="">Please select a student request</option>

                                    @foreach ($acceptedStudentRequests as $request)
                                        <option value="{{ $request->id }}">
                                            Internship: {{ $request->internship->internship_title }} | 
                                            Student Name : {{ $request->student->name }} | Advisor: {{ $request->advisor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- FOLLOW UP DATE -->

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">

                                    <label for="follow_up_date">follow_up_date <span class="required-label">*</span></label>

                                    <input type="date" class="form-control" id="follow_up_date" name="follow_up_date" required>
                                </div>
                            </div>

                            <!-- NOTE -->

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">

                                    <label for="notes">notes<span class="required-label">*</span></label>

                                    <textarea rows="4" name="notes" id="notes" class="form-control" placeholder="notes" required></textarea>

                                </div>
                            </div>

                            <!-- Status Selection -->
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Please Select Status</option>

                                    <option value="On Track" >On Track</option>
                                    
                                    <option value="Behind Schedule" >Behind Schedule</option>

                                    <option value="Completed" >Completed</option>

                                </select>
                            </div>

                    <div class="col-md-12">
                        <a href="{{route('follow_up.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                         
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                

            </div>
        </div>
    </div>
    
@endsection


@php use App\Http\Controllers\MyUtility; @endphp
@extends('layouts.back-end')
@section('main-title')
ADMIN : EDIT THESIS DOCUMENTS 
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
                <form id="follow_up-form" action="{{ route('thesis_document.update',$thesis_document->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    
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
                                        <option value="{{ $student->id }}" {{ $student->id == $thesis_document->student_request->student->id ? 'selected' : '' }}>
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

                                @foreach($advisors as $advisor)
                                        <option value="{{ $advisor->id }}" {{ $advisor->id == $thesis_document->student_request->advisor->id ? 'selected' : '' }}>

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

                                @foreach($internships as $internship)
                                <option value="{{ $internship->id }}" {{ $internship->id == $thesis_document->student_request->internship_id ? 'selected' : '' }}>
                                            {{ $internship->internship_title }}
                                        </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- STUDENT THESIS DOCUMENT FORM -->

                        <div class="form-group mb-3">
                            <label for="student_thesis">STUDENT THESIS DOCUMENT</label>

                            <!-- Check if there is an existing thesis document -->
                            @if($thesis_document->student_thesis)
                                <p>Current Thesis Document: 
                                    <a href="{{ asset('storage/'.$thesis_document->student_thesis) }}" target="_blank">
                                        {{ basename($thesis_document->student_thesis) }}
                                    </a>
                                </p>
                            @else
                                <p>No thesis document uploaded.</p>
                            @endif

                            <input type="file" class="form-control-file form-control" id="student_thesis" name="student_thesis">
                            
                            <small class="form-text text-muted">Leave blank if you don't want to change the file.</small>
                        </div>

                        <!-- STATUS SELECTION -->
                        <div class="form-group">
                                <label for="status">Status</label>
                                
                                <select name="status" id="status" class="form-control">
                                    
                                    <option value="">Please Select Status</option>
                                        
                                    <option value="submitted" {{$thesis_document->status == "submitted" ? 'selected' : '' }}>Submitted</option>
                                        
                                    <option value="accepted" {{$thesis_document->status == "accepted" ? 'selected' : '' }}>Accepted</option>
                                    
                                    <option value="rejected" {{$thesis_document->status == "rejected" ? 'selected' : '' }}>Rejected</option>

                                </select>
                            </div>


                    <div class="col-md-12">
                        <a href="{{route('thesis_document.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                         
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                <br>

                
                        </div>
                    </div>
                </div>
                    <input type="hidden" value="{{request()->page}}" name="page">
            </div>
        </div>
    </div>
@endsection

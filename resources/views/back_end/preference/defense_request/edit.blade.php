
@php use App\Http\Controllers\MyUtility; @endphp
@extends('layouts.back-end')
@section('main-title')
ADMIN : EDIT DEFENSE REQUEST 
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
?>
@section('body')
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
                <form id="follow_up-form" action="{{ route('admin_defense_request.update', $admin_defense_request->id) }}" method="post" enctype="multipart/form-data">
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
                                        <option value="{{ $student->id }}" {{ $student->id == $admin_defense_request->thesisDocument->student_request->student->id ? 'selected' : '' }}>
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
                                        <option value="{{ $advisor->id }}" {{ $advisor->id == $admin_defense_request->thesisDocument->student_request->advisor->id ? 'selected' : '' }}>

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
                                <option value="{{ $internship->id }}" {{ $internship->id == $admin_defense_request->thesisDocument->student_request->internship_id ? 'selected' : '' }}>
                                            {{ $internship->internship_title }}
                                        </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- STATUS SELECTION -->
                        <div class="form-group">
                                <label for="status">Status</label>
                                
                                <select name="status" id="status" class="form-control">
                                    <option value="">Please Select Status</option>
                                    <option value="pending" {{$admin_defense_request->status == "pending" ? 'selected' : '' }}>pending</option>
                                    <option value="approved" {{$admin_defense_request->status == "approved" ? 'selected' : '' }}>approved</option>
                                    <option value="rejected" {{$admin_defense_request->status == "rejected" ? 'selected' : '' }}>rejected</option>
                                </select>
                            </div>
                        
                        <!-- FEEDBACK -->

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="notes">Feedback<span class="required-label">*</span></label>

                                    <textarea rows="4" name="feedback" id="feedback" class="form-control" placeholder="feedback" >{{ old('feedback', $admin_defense_request->feedback) }}</textarea>
                                </div>
                            </div>


                    <div class="form-group">
                        <a href="{{route('admin_defense_request.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                         
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

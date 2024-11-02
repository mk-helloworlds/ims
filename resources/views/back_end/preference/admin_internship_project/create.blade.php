@extends('layouts.back-end')
@section('main-title')
CREATE INTERNSHIP
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
?>
@section('body')
        <div class="col-md-12 offset-sm">
            <div>
                @if($errors->all())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach($errors->all() as $messsage)
                                <li>{{$messsage}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <!-- CONFIGURE THE ROUTE for Store  -->
                    <form id="internship_project-form" action="{{ route('internship_project.store') }}" method="post" enctype="multipart/form-data">
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
    
                                <!-- PROJECT NAME -->
                                
                                <div class="form-group form-show-validation row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
    
                                        <label for="project_name">Project Name<span class="required-label">*</span></label>
    
                                        <input type="text" class="form-control" id="project_name" name="project_name"
                                            placeholder="Enter project_name" required>
    
                                    </div>
                                </div>
                                
                                <!-- DESCRIPTION -->
    
                                <div class="form-group form-show-validation row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
    
                                        <label for="description">Description<span class="required-label">*</span></label>
    
                                        <textarea rows="4" name="description" id="description" class="form-control" placeholder="Enter internship_project" required></textarea>
    
                                    </div>
                                </div>
    
                                <!-- START DATE -->
    
                                <div class="form-group form-show-validation row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
    
                                        <label for="start_date">Start Date <span class="required-label">*</span></label>
    
                                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                                    </div>
                                </div>
    
                                <!-- END DATE -->
    
                                <div class="form-group form-show-validation row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <label for="end_date">End Date<span class="required-label">*</span></label>
    
                                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                                    </div>
                                </div>
    
                            </div>
                                <div class="form-group">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <a href="{{route('internship_project.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
    
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
    
                        
                    </form>
                    <br>
                </div>

            </div>
        </div>
    </div>
@endsection

@extends('layouts.back-end')
@section('main-title')
STUDENT : CREATE SUBMISSION FORM STUDENT
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
$selectedInternshipId = 0;
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

<script>
$(document).ready(function () {
    $('#create-company-form').on('submit', function (e) {
        e.preventDefault(); // Prevent the form from submitting the normal way

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'), // URL to send the AJAX request
            method: $(this).attr('method'), // POST request
            data: formData, // Form data to be sent
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }, 

            success: function(response) {
                console.log("Response Data: ", response); 

                if (response && response.id && response.company_name) {
                    
                    $('#success-message').html('<div class="alert alert-success">Company created successfully! Refreshing page...</div>');

                    $('#createCompanyModal').modal('hide');
                    
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    
                    $('#success-message').html('<div class="alert alert-danger">Failed to create company. Please try again.</div>');
                }
            },
            error: function (xhr, status, error) {
                console.log("Error Status: " + status);
                console.log("Error Message: " + error);
                console.log("Response Text: " + xhr.responseText);

                // Show an error message in the div
                $('#success-message').html('<div class="alert alert-danger">Error creating company. Please check your input.</div>');
            }
        });
    });
});

</script>
<div class="col-md-12 offset-sm">
    <div>
        @if($errors->all())
            <div class="alert alert-danger">
               <ul>
                @foreach($errors->all() as $message)
                    <li>{{$message}}</li>
                @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>

<div class="col-md-12 ">
    <div class="card">

                <form id="user-form" action="{{ route('student_submission_form.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="card-body row">
                        <div class="col-md-12">

                            <!-- AUTO SELECT STUDENT REQUEST -->
                            <div class="form-group col-md-12">
                                <label for="student_request_id">STUDENT REQUEST</label>
                                <select name="student_request_id" id="student_request_id" class="form-control" required>
                                    <option value="">Select a Student Request</option>
                                    
                                    <!-- Loop through student requests -->
                                    @foreach($studentRequests as $request)
                                        <option value="{{ $request->id }}"> Student Name : {{$student->name}} | 
                                           Internship : {{ $request->internship->internship_title }} 
                                            | Advisor: {{ $request->advisor->name ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Add Company Button -->

                                 <div class="form-group">
                                        <label for="company_id">COMPANY</label>
                                        <select name="company_id" id="company_id" class="form-control">
                                            <option value="">Please Select Company</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                            @endforeach
                                        </select>
                                        <!-- Trigger the modal with this button -->
                                        <button type="button" class="btn btn-info mt-2" data-toggle="modal" data-target="#createCompanyModal">
                                            + Add New Company
                                        </button>
                                </div>

                            <!-- SUPERVISOR NAME -->

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="supervisor_name">Supervisor Name<span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="supervisor_name" name="supervisor_name" value=""
                                        placeholder="Enter supervisor_name">
                                </div>
                            </div>

                            <!-- INTERNSHIP AGREEMENT -->

                            <div class="form-group mb-3">
									<label for="internship_agreement">internship_agreement</label>
									<input type="file" class="form-control-file form-control" id="internship_agreement" name="internship_agreement" required>
							</div>

                            <!-- ADVISOR CONFIRMATION LETTER -->

                            <div class="form-group mb-3">
									<label for="advisor_confirmation_letter" class="form-label">advisor_confirmation_letter</label>
									<input type="file" class="form-control-file form-control" id="advisor_confirmation_letter" name="advisor_confirmation_letter" required>
							</div>

                            <!-- INTERNSHIP PROPOSAL -->

                            <div class="form-group mb-3">
									<label for="internship_proposal" class="form-label">internship_proposal</label>
									<input type="file" class="form-control-file form-control" id="internship_proposal" name="internship_proposal" required>
							</div>

                            <div class="col-md-12">
                                <a href="{{route('student_submission_form.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                                
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                </form>
                <br>

                <!-- Modal for Creating a Company (Place this outside the main form) -->
                <div id="createCompanyModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="create-company-form" action="{{ route('company.store.ajax') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h4 class="modal-title">Create New Company</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="company_name">Company Name</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="category_id">Category</label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="company_profile">Company Profile</label>
                                        <textarea class="form-control" id="company_profile" name="company_profile" rows="4" required></textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Create Company</button>

                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
@endsection

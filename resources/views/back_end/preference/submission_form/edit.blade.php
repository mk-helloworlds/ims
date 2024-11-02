@php use App\Http\Controllers\MyUtility; @endphp
@extends('layouts.back-end')
@section('main-title')
    EDIT SUBMISSION FORM
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
?>
@section('body')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function(){
        console.log("JQuery is working!");
    });
</script>

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

    <div class="col-md-12 offset-sm">
        <div class="card">
            
            <form id="submissionForm-form" action="{{ route('submission_form.update', $submissionForm->id) }}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf

                <div class="card-body row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="student_request_id">STUDENT REQUEST</label>
                            <select name="student_request_id" id="student_request_id" class="form-control">
                                <option value="">Please Select Student Request</option>

                                @foreach($studentRequests as $studentRequest)
                                    <option value="{{ $studentRequest->id }}" 
                                        {{ $studentRequest->id == $submissionForm->student_request_id ? 'selected' : '' }}>
                                        {{ $studentRequest->student->name }} - {{ $studentRequest->internship->internship_title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="company_id">COMPANY</label>
                            <select name="company_id" id="company_id" class="form-control">
                                <option value="">Please Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" 
                                        {{ $company->id == $submissionForm->company_id ? 'selected' : '' }}>
                                        {{ $company->company_name }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="button" class="btn btn-info mt-2" data-toggle="modal" data-target="#createCompanyModal">
                                + Add New Company
                            </button>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="supervisor_name">Supervisor Name</label>
                            <input type="text" class="form-control" id="supervisor_name" name="supervisor_name" value="{{ old('supervisor_name', $submissionForm->supervisor_name) }}">
                        </div>
                    
                        @if($submissionForm->internship_agreement)
                            <div class="form-group col-md-12 ">
                                <label for="internship_agreement" class="text-muted">Existing Internship Agreement</label>
                                    <a class="form-control bg-light text-dark" href="{{ asset('storage/' . $submissionForm->internship_agreement) }}" target="_blank">
                                        {{ basename($submissionForm->internship_agreement) }}
                                    </a>
                            </div>
                        @endif

                        <div class="form-group col-md-12">
                            <label for="internship_agreement">Upload New Internship Agreement</label>
                            <input type="file" class="form-control-file form-control" id="internship_agreement" name="internship_agreement">
                        </div>

                        @if($submissionForm->advisor_confirmation_letter)
                            <div class="form-group col-md-12">
                                <label for="advisor_confirmation_letter" class="text-muted">Existing Advisor Confirmation Letter</label>
                                    <a class="form-control bg-light text-dark" href="{{ asset('storage/' . $submissionForm->advisor_confirmation_letter) }}" target="_blank">
                                        {{ basename($submissionForm->advisor_confirmation_letter) }}
                                    </a>
                            </div>
                        @endif

                        <div class="form-group col-md-12">
                            <label for="advisor_confirmation_letter">Upload New Advisor Confirmation Letter</label>
                            <input type="file" class="form-control-file form-control" id="advisor_confirmation_letter" name="advisor_confirmation_letter">
                        </div>

                        @if($submissionForm->internship_proposal)
                            <div class="form-group col-md-12">
                                <label for="internship_proposal" class="text-muted">Existing Internship Proposal</label>
                                    <a class="form-control bg-light text-dark" href="{{ asset('storage/' . $submissionForm->internship_proposal) }}" target="_blank">
                                        {{ basename($submissionForm->internship_proposal) }}
                                    </a>
                            </div>
                        @endif

                        <div class="form-group col-md-12">
                            <label for="internship_proposal" class="form-label">Upload New Internship Proposal</label>

                            <input type="file" class="form-control-file form-control" id="internship_proposal" name="internship_proposal">
                        </div>

                        <div class="form-group">
                            <a href="{{ route('submission_form.index') }}" class="btn btn-secondary">Cancel</a>

                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                </div>
            </form>
        </div>
    </div>


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
                    <input type="hidden" value="{{request()->page}}" name="page">
            </div>
        </div>
    </div>
@endsection

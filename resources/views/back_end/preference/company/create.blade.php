@extends('layouts.back-end')
@section('main-title')
CREATE COMPANY
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
?>
@section('body')
<script>
    $(document).ready(function() {
    $('#create-company-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting the normal way

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Append the new company to the dropdown
                $('#company_id').append(new Option(response.company_name, response.id));

                // Select the new company in the dropdown
                $('#company_id').val(response.id);

                // Close the modal
                $('#createCompanyModal').modal('hide');

                // Reset the form
                $('#create-company-form')[0].reset();
            },
            error: function(xhr) {
                // Handle any errors here
                alert('Error creating company. Please check your input.');
            }
        });
    });
});
</script>
        <div class="col-md-12">

            <div class="card">

                <!-- CONFIGURE THE ROUTE for Store  -->
                <form id="company-form" action="{{ route('company.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body row">
                        @if($errors->all())
                            <div class="alert alert-danger bg-danger">
                                <ul>
                                    @foreach($errors->all() as $messsage)
                                        <li>{{$messsage}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="col-md-12">

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="company_name">Company Name <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="company_name" name="company_name"
                                        placeholder="Enter Company's Name" required>
                                </div>
                            </div>

                            <!-- FORM FOR SELECTING THE CATEGORY -->
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                <option value="">Please Select Category</option>

                                @foreach($category as $c)
                                <option value="{{$c->id}}">
                                    {{$c->category_name}}
                                </option>
                                @endforeach
                                </select>
                            </div>

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="company_profile">Company Profile <span class="required-label">*</span></label>
                                    <textarea rows="8" name="company_profile" id="company_profile" class="form-control" placeholder="Enter Company's Profile" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <!-- CANCEL BUTTON -->
                                <a href="{{route('company.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
        
                                <!-- SUBMIT BUTTON -->
                                 <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

@php use App\Http\Controllers\MyUtility; @endphp
@extends('layouts.back-end')
@section('main-title')
    EDIT COMPANY
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
?>
@section('body')
        @if($errors->all())
            <div>
                <ul>
                @foreach($errors->all() as $message)
                <li class="alert alert-primary" role="alert">{{$message}}</li>
                @endforeach
                </ul>
            </div>
        @endif

        <div class="col-md-12">
            <div class="card">

                <!-- CONFIGURE THE ROUTE for Update  -->
                <form id="company-form" action="{{ route('company.update', $company->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')

                    @csrf
                    <div class="card-body row">
                        <div class="col-md-12">

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="company_name">Company Name <span class="required-label">*</span></label>

                                    <input type="text" class="form-control" id="company_name" name="company_name" value="{{$company->company_name}}" required>
                                </div>
                            </div>

                            <!-- FORM FOR SELECTING THE CATEGORY -->
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                <option value="">Please Select Category</option>

                                @foreach($category as $c)
                                <option value="{{$c->id}}" {{$c->id == $company->category_id ? "selected":""}}>
                                    {{$c->category_name}}
                                </option>
                                @endforeach
                                </select>
                            </div>

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="company_profile">Company Profile <span class="required-label">*</span></label>
                                    <textarea rows="8" name="company_profile" id="company_profile" class="form-control" value="{{$company->company_profile}}" required>{{$company->company_profile}}</textarea>
                                </div>
                            </div>
                            <div >
                                <div class="col-md-12">
                                    <!-- CANCEL BUTTON -->
                                    <a href="{{route('company.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
            
                                    <!-- SUBMIT BUTTON -->
                                     <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>

                        </div>


                    </div>

                </form>
        </div>
    </div>
@endsection

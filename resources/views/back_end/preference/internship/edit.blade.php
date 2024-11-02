@php use App\Http\Controllers\MyUtility; @endphp
@extends('layouts.back-end')
@section('main-title')
EDIT INTERNSHIPS 
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
?>
@section('body')
        @if($errors->all())
            <div class="alert alert-danger">
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
                <form id="user-form" action="{{ route('internship.update',$internship->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    
                    @csrf
                    <div class="card-body row">
                        <div class="col-md-12">

                        <div class="form-group form-show-validation row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="internship_title">Internship Title<span class="required-label">*</span></label>
                                <input type="text" class="form-control" id="internship_title" name="internship_title" value="{{ $internship->internship_title }}"
                                    placeholder="Enter Internship Title" required>
                            </div>
                        </div>

                        <div class="form-group form-show-validation row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="type">Type <span class="required-label">*</span></label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="">Please Select Type</option>                
                                    <option value="1" {{ $internship->type == 1 ? 'selected' : '' }}>Type 1</option>
                                    <option value="2" {{ $internship->type == 2 ? 'selected' : '' }}>Type 2</option>
                                    </option>
                                </select>
                            </div>
                        </div>          

                        <div class="form-group form-show-validation row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="period">Internship Period (Months)<span class="required-label">*</span></label>
                                <input type="number" class="form-control" id="period" name="period" value="{{ $internship->period }}"
                                    placeholder="Enter Internship Period" required>
                            </div>
                        </div>

                        <div class="form-group form-show-validation row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="school">School <span class="required-label">*</span></label>
                                <select class="form-control" id="school" name="school" required>
                                    <option value="">Please Select School</option>
                                    <option value="DB" {{ $internship->school == 'DB' ? 'selected' : '' }}>Digital Business</option>
                                    <option value="CS" {{ $internship->school == 'CS' ? 'selected' : '' }}>Computer Science</option>
                                    <option value="TN" {{ $internship->school == 'TN' ? 'selected' : '' }}>Telecom and Networking</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-show-validation row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="generation">Generation <span class="required-label">*</span></label>
                                <input type="number" class="form-control" id="generation" name="generation" value="{{$internship->generation}}"
                                    placeholder="Enter Generation" required>
                            </div>
                        </div>

                        <div class="form-group form-show-validation row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Description">{{ $internship->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group form-show-validation row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="start_date">Start Date<span class="required-label">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $internship->start_date }}" required>
                            </div>
                        </div>

                        <div class="form-group form-show-validation row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="end_date">End Date<span class="required-label">*</span></label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $internship->end_date }}" required>
                            </div>
                        </div>

                        <div class="">
                            <div class="col-md-12">
                                <a href="{{route('internship.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                                
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                        
                    </div>


                    <input type="hidden" value="{{request()->page}}" name="page">
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

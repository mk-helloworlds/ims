@extends('layouts.back-end')
@section('main-title')
CREATE INTERNSHIPS
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
?>
@section('body')
        <div class="col-md-12">

            <div class="card">

                <form id="user-form" action="{{ route('internship.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="card-body row">
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

                        <div class="form-group form-show-validation row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="internship_title">Internship Title<span class="required-label">*</span></label>
                                <input type="text" class="form-control" id="internship_title" name="internship_title" value="{{ old('internship_title') }}"
                                    placeholder="Enter Internship Title" required>
                            </div>
                        </div>

                        <div class="form-group form-show-validation row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="type">Type <span class="required-label">*</span></label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="">Please Select Type</option>
                                    <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>Internship 1</option>
                                    <option value="2" {{ old('type') == 2 ? 'selected' : '' }}>Internship 2</option>
                                </select>
                            </div>
                        </div>          

                        <div class="form-group form-show-validation row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="period">Internship Period (Months)<span class="required-label">*</span></label>
                                <input type="number" class="form-control" id="period" name="period" value="{{ old('period') }}"
                                    placeholder="Enter Internship Period" required>
                            </div>
                        </div>

                        <div class="form-group form-show-validation row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="school">School <span class="required-label">*</span></label>
                                <select class="form-control" id="school" name="school" required>
                                    <option value="">Please Select School</option>
                                    <option value="DB" {{ old('school') == 'DB' ? 'selected' : '' }}>Digital Business</option>
                                    <option value="CS" {{ old('school') == 'CS' ? 'selected' : '' }}>Computer Science</option>
                                    <option value="TN" {{ old('school') == 'TN' ? 'selected' : '' }}>Telecom and Networking</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-show-validation row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="generation">Generation <span class="required-label">*</span></label>
                                <input type="number" class="form-control" id="generation" name="generation" value="{{ old('generation') }}"
                                    placeholder="Enter Generation" required>
                            </div>
                        </div>

                        <div class="form-group form-show-validation row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Description">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group form-show-validation row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="start_date">Start Date<span class="required-label">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                            </div>
                        </div>

                        <div class="form-group form-show-validation row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="end_date">End Date<span class="required-label">*</span></label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <a href="{{route('internship.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                             
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

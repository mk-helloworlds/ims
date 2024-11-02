@php use App\Http\Controllers\MyUtility; @endphp
@extends('layouts.back-end')
@section('main-title')
    EDIT INTERNSHIP PROJECT
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
                <!-- Existing Project Data -->
                <form action="{{ route('internship_project.update', $internshipProject->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Student Request Selection (Optional) -->
                    <div class="form-group">
                        <label for="student_request_id">Select Student Request</label>
                        <select name="student_request_id" class="form-control">
                            <option value="">Please select a student request</option>

                            @foreach ($acceptedStudentRequests as $request)
                                <option value="{{ $request->id }}" 
                                    {{ $request->id == $internshipProject->student_request_id ? 'selected' : '' }}>
                                    Internship: {{ $request->internship->internship_title }} | 
                                    Student Name : {{ $request->student->name }} | Advisor: {{ $request->advisor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Project Name -->
                    <div class="form-group">
                        <label for="project_name">Project Name</label>
                        <input type="text" name="project_name" class="form-control" value="{{ $internshipProject->project_name }}" required>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" rows="4" required>{{ $internshipProject->description }}</textarea>
                    </div>

                    <!-- Start Date -->
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $internshipProject->start_date }}" required>
                    </div>

                    <!-- End Date -->
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $internshipProject->end_date }}" required>
                    </div>

                    <div class="form-group">
                        <a href="{{route('internship_project.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>

                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
        </div>
    </div>
@endsection

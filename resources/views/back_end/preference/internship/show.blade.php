@extends('layouts.back-end')
@section('main-title')
INTERNSHIPS
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
        <div class="card-body">
            <div class="d-flex align-items-center">
                    <a href="{{ route('dashboard') }}"
                    class="btn btn-sm btn-light btn-round ml-auto">
                    <i class="fa fa-arrow-left"></i>
                    Return to dashboard
                    </a>
            </div>
        </div>
    </div>
</div>


<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="col-md-12">
                <div class="row d-flex align-items-stretch">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h1>{{ $internship->internship_title }}</h1>
                                <p>{{ $internship->description }}</p>
                                <p><strong>School: </strong>{{ $internship->school }} | <strong>Generation:</strong> {{ $internship->generation }} | <strong>Period:</strong> {{ $internship->period }} months | <strong>Type:</strong> {{ $internship->type }}</p>
                            </div>        
                        </div>
                    </div>
                
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h1>Duration</h1>
                                <p><strong class="badge badge-primary">Start Date:</strong> {{ $internship->start_date }}</p>
                                <p><strong  class="badge badge-success">End Date:</strong> {{ $internship->end_date }}</p>    
                            </div>        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- <div class="card-body">
            <div class="row">
                <a class="btn btn-dark" href="{{route('internships_participants.index', $internship->id)}}">Manage Participant</a>
                
                <a class="btn btn-dark" href="{{route('internships_participants.index', $internship->id)}}">Manage Participant</a>
            </div>
        </div> -->
        
        
    </div>
</div>

<!-- Scrollable Sub-Navigation Bar -->
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
                <!-- <div class="d-flex align-items-center">
                        <a href="{{ route('dashboard') }}"
                        class="btn btn-sm btn-light btn-round ml-auto">
                        <i class="fa fa-arrow-left"></i>
                        Return to dashboard
                        </a>
                </div> -->
                <div class="d-flex overflow-auto flex-nowrap w-100" style="white-space: nowrap; max-width: 100%; overflow-x: auto; padding-bottom: 10px;">
                <a href="{{route('internships_participants.index', $internship->id)}}" class="btn btn-outline-primary mx-1">Manage Participant</a>

                <!-- ADVISOR SELECTION -->
                 <!-- STUDENT -->
                <a href="{{route('student_advisor_selection.index', $internship->id)}}" class="btn btn-outline-primary mx-1">Student: advisor_selection</a>
                <!-- ADVISOR -->
                <a href="{{route('advisor_advisor_selection.pending', $internship->id)}}" class="btn btn-outline-primary mx-1">Advisor: advisor_selection </a>
                <!-- ADMIN -->
                <a href="{{route('admin_advisor_selection.index', $internship->id)}}" class="btn btn-outline-primary mx-1">Admin: advisor_selection</a>

                <!-- INTERNSHIP PROJECT -->
                <!-- STUDENT -->
                <a href="#section5" class="btn btn-outline-secondary mx-1">Student: internship_project</a>
                <!-- ADVISOR -->
                <a href="#section6" class="btn btn-outline-secondary mx-1">Advisor: internship_project</a>
                <!-- ADMIN -->
                <a href="#section6" class="btn btn-outline-secondary mx-1">Admin: internship_project</a>





                <a href="#section7" class="btn btn-primary mx-1">Section 7</a>
                <a href="#section8" class="btn btn-primary mx-1">Section 8</a>
                <a href="#section9" class="btn btn-primary mx-1">Section 9</a>
                <a href="#section10" class="btn btn-primary mx-1">Section 10</a>
                <a href="#section10" class="btn btn-primary mx-1">Section 10</a>
                <a href="#section10" class="btn btn-primary mx-1">Section 10</a>
                <a href="#section10" class="btn btn-primary mx-1">Section 10</a>
                <a href="#section10" class="btn btn-primary mx-1">Section 10</a>
                <a href="#section10" class="btn btn-primary mx-1">Section 10</a>
                <!-- Add more items as needed -->
            </div>
        </div>
    </div>
</div>
<!-- End of Scrollable Sub-Navigation Bar -->

@endsection

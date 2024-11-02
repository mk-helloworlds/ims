@extends('layouts.back-end')
@section('main-title')
ADVISOR : CREATE FOLLOW UP
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
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th >ADVISOR</th>
                        <th >STUDENT</th>
                    </tr>
                </thead>

                <tbody>
                    <td>
                        <h4>USER ADVISOR ID: {{ Auth::user()->id }}</h4>
                        <h4>{{ Auth::user()->name }}</h4>
                        <h4>{{ Auth::user()->email }}</h4>
                        <h4>{{ Auth::user()->role->role_name }}</h4>
                    </td>

                    <td>
                        <h4>USER STUDENT ID: {{ $studentRequest->student->id }}</h4>
                        <h4>{{ $studentRequest->student->name }}</h4>
                        <h4>{{ $studentRequest->student->email }}</h4>
                        <h4>{{ $studentRequest->student->role->role_name }}</h4>
                    </td>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <form id="user-form" action="{{ route('advisor.follow_up.student_detail.store', $studentRequest->id) }}" method="post" enctype="multipart/form-data">
        @csrf

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
        <div class="card-body">
            <table class="table">

                <!-- Student (Read-Only) -->
                <div class="form-group">
                    <label for="user_student_id">STUDENT NAME</label>
                    <input type="text" class="form-control" value="{{ $studentRequest->student->name }}" readonly>
                    <input type="hidden" name="user_student_id" value="{{ $studentRequest->student->id }}">
                </div>

                <!-- Advisor (Read-Only) -->
                <div class="form-group">
                    <label for="user_advisor_id">ADVISOR NAME</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                    <input type="hidden" name="user_advisor_id" value="{{ Auth::user()->id }}">
                </div>

                <!-- Internship (Read-Only) -->
                <div class="form-group">
                    <label for="internship_id">INTERNSHIP</label>
                    <input type="text" class="form-control" value="{{ $studentRequest->internship->internship_title }}" readonly>
                    <input type="hidden" name="internship_id" value="{{ $studentRequest->internship->id }}">
                </div>

                <!-- Follow-Up Date -->
                <div class="form-group form-show-validation row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <label for="follow_up_date">FOLLOW UP DATE <span class="required-label">*</span></label>
                        <input type="date" class="form-control" id="follow_up_date" name="follow_up_date" required>
                    </div>
                </div>

                <!-- Notes -->
                <div class="form-group form-show-validation row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <label for="notes">NOTES<span class="required-label">*</span></label>
                        <textarea rows="4" name="notes" id="notes" class="form-control" placeholder="notes" required></textarea>
                    </div>
                </div>

                <!-- Status Selection -->
                <div class="form-group">
                    <label for="status">STATUS</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Please Select Status</option>
                        <option value="On Track">On Track</option>
                        <option value="Behind Schedule">Behind Schedule</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <a href="{{route('advisor.follow_up.student_detail', $studentRequest->id)}}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@php use App\Http\Controllers\MyUtility; @endphp
@extends('layouts.back-end')
@section('main-title')
    EDIT ADMIN ADVISOR SELECTION CRUD
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
?>
@section('body')

<div class="col-md-12">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
</div>

        <div class="col-md-12">

            <div class="card">

            <!-- CONFIGURE THE ROUTE for Update  -->
            <form id="AdminAdvisorSelection-form" action="{{ route('admin_advisor_selection.update', ['internship' => $internshipId, 'id' => $student_request->id]) }}" method="post" enctype="multipart/form-data">

                @method('PUT')  
                @csrf
                    
                    <div class="card-body row">

                        <div class="col-md-12">

                            <!-- Internship SLECTION -->
                            <div class="form-group">
                                <label for="internship_id">Selected Internship</label>
                                
                                <select id="internship_id_display" class="form-control" disabled>
                                    <option value="{{ $internshipId }}">{{ $internship_title }}</option>
                                </select>
                                
                                <input type="hidden" name="internship_id" value="{{ $internshipId }}">
                            </div>

                            <!-- STUDENT SLECTION -->
                            <div class="form-group">
                                <label for="student_id">Student's Name</label>

                                <select name="student_id" id="student_id" class="form-control">
                                    <option value="">Please Select Student's Name</option>

                                    @foreach($students as $student)
                                        <option value="{{$student->id}}" {{$student->id == $student_request->student_id ? "selected" : ""}}>

                                            {{$student->name}}

                                        </option>
                                        
                                    @endforeach
                                </select>
                            </div>

                            <!-- ADVISOR SLECTION -->
                            <div class="form-group">
                                <label for="student_id">Advisor's Name</label>

                                <select name="advisor_id" id="advisor_id" class="form-control">
                                    <option value="">Please Select Advisor's Name</option>

                                    @foreach($advisors as $advisor)
                                        <option value="{{$advisor->id}}" {{$advisor->id == $student_request->advisor_id ? "selected" : ""}}>

                                            {{$advisor->name}}

                                        </option>
                                        
                                    @endforeach
                                </select>
                            </div>
                            
                            

                            <!-- Status Selection -->
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Please Select Status</option>

                                    <option value="Accepted" {{ $student_request->status == 'Accepted' ? 'selected' : '' }}>Accepted</option>

                                    <option value="Pending" {{ $student_request->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    
                                    <option value="Rejected" {{ $student_request->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>

                    </div>

                    <div class="col-md-12">
                        <a href="{{route('admin_advisor_selection.index', $internshipId)}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                         
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

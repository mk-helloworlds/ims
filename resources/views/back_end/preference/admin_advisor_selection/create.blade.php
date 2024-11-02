@extends('layouts.back-end')
@section('main-title')
CREATE ADMIN STUDENT_ADVISOR CRUD
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

                <form id="AdminAdvisorSelection-form" action="{{ route('admin_advisor_selection.store', $internshipId) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="internship_id">Selected Internship</label>
                                
                                <select id="internship_id_display" class="form-control" disabled>
                                    <option value="{{ $internshipId }}">{{ $internship_title }}</option>
                                </select>
                                
                                <input type="hidden" name="internship_id" value="{{ $internshipId }}">
                            </div>

                            <div class="form-group">
									<label for="student_id">Student's Name</label>
                                    <select name="student_id" id="student_id"  class="form-control">
                                        <option value="">Please Select Student's Name</option>
                                        
                                        @foreach($students as $s)
                                        <option value="{{$s->id}}">
                                            {{$s->name}}
                                        </option>
                                        @endforeach
                                    </select>
							</div>

                            <div class="form-group">
									<label for="advisor_id">Advisor's Name</label>
                                    <select name="advisor_id" id="advisor_id"  class="form-control">
                                        <option value="">Please Select Advisor's Name</option>
                                        
                                        @foreach($advisors as $a)
                                        <option value="{{$a->id}}">
                                            {{$a->name}}
                                        </option>
                                        @endforeach
                                    </select>
							</div>

                            <div class="form-group">
									<label for="status">Status</label>
                                    <select name="status" id="status"  class="form-control">
                                        <option value="">Please Select Status</option>
                                            <option value="Accepted">Accepted </option>
                                            <option value="Pending">Pending </option>
                                            <option value="Rejected">Rejected </option>
                                            
                                        
                                    </select>
							</div>
                            <div class="form-group">
                                <a href="{{route('admin_advisor_selection.index', $internshipId)}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                                
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                    </div>

                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

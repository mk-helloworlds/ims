@extends('layouts.back-end')
@section('main-title')
STDUENT REQUEST ADVISOR
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
);
?>
@section('body')
    <!-- Display error messages, if any -->

<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                    <a href="{{ route('internship.show', $internshipId) }}"
                    class="btn btn-sm btn-light btn-round ml-auto">
                    <i class="fa fa-arrow-left"></i>
                    Return to Internship
                </a>
            </div>
        </div>
    </div>
</div>
    
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
                <h3>PENDING REQUESTED | REJECTED REQUESTED</h3>

                <p>User ID: {{Auth::id()}} | User Role: {{Auth::user()->role->role_name}}</p>
                <p>Advisor's Name: {{Auth::user()->name}}</p>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Internship ID</th>
                            <th>Internship name</th>
                            <th>Student Name</th>
                            <th>Advisor Name</th>
                            <th>Student CV</th>
                            <th>Student Comment</th>
                            <th>Advisor Note</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($CurrentStudentRequest as $request)
                    <tr>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->internship->id }}</td>
                        <td>{{ $request->internship->internship_title }}</td>
                        <td>{{ $request->student->name }}</td>
                        <td>{{ $request->advisor->name }}</td>
                        <td>
                            @if($request->cv)
                                <a href="{{ asset('storage/' . $request->cv) }}" target="_blank">View CV</a>
                            @else
                                No CV uploaded
                            @endif
                        </td>
                        <th>
                            @if($request->message)
                                {{ $request->message }}
                            @else
                                N/A
                            @endif
                        </th>

                        <th>
                            @if($request->advisor_response_message)
                                {{ $request->advisor_response_message }}
                            @else
                                N/A
                            @endif  
                        </th>
                        <td>
                            <span class="badge badge-{{ $request->status == 'Rejected' ? 'danger' : ($request->status == 'Accepted' ? 'success' : 'warning') }}">
                            {{ $request->status }}         
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <h4><strong>CURRENT USER  |  User ID: {{Auth::id()}} | User Role: {{Auth::user()->role->role_name}}</strong></h4>        
                
                <p>User's Name: {{Auth::user()->name}}</p>

                <h3>Available Advisors</h3>

                <form action="{{ route('student_advisor_selection.request', $internships->id) }}" method="POST" enctype="multipart/form-data">

                    @csrf

                        <div class="form-group">
                            <label for="advisor_id">Select Advisor</label>
                            <select name="advisor_id" id="advisor_id" class="form-control" required>
                                <option value="">-- Select an Advisor --</option>
                                @foreach ($advisors as $advisor)
                                    <option value="{{ $advisor->id }}">{{ $advisor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="internship_id">Selected Internship ID</label>
                            
                            <!-- Dropdown with a disabled attribute -->
                            <select id="internship_id_display" class="form-control" disabled>
                                <option value="{{ $internships->id }}">{{ $internships->internship_title }}</option>
                            </select>
                            
                            <!-- Hidden input to pass the value to the controller -->
                            <input type="hidden" name="internship_id" value="{{ $internships->id }}">
                        </div>

                        <!-- Message Field -->
                        <div class="form-group">
                            <label for="message">Message (optional)</label>
                            <textarea class="form-control" name="message" id="message" rows="3" placeholder="Add a message for the advisor"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="cv">Upload CV (optional, PDF/DOC)</label>
                            <input type="file" class="form-control-file" name="cv" id="cv" accept=".pdf,.doc,.docx">
                        </div>

                        
                        <div class="form-group">
                            <button type="submit" class="form-group btn btn-primary">Send Request</button>
                        </div>
                </form>

                <!-- For student to View the Advisor-->
                <br>
                <div class="col-md-12">
                    <div class="card">
                        <table class="table">
                            <div class="card-header">ADVISOR</div>
                            <thead>
                                <tr>
                                    <th>Advisor ID</th>
                                    <th>Advisor Name</th>
                                    <th>Advisor Email</th>
                                    <th>Image Profile</th>
                                    <th>Accepted Student</th>
                                    <th>Pending Student</th>
                                    <th>Rejected Student</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
        
                            <tbody>
                                @foreach ($advisors as $advisor)
                                    <tr>
                                        <td>{{ $advisor->id }}</td>
                                        <td>{{ $advisor->name }}</td>
                                        <td>{{ $advisor->email }}</td>
                                        <td><img src="/storage/{{$advisor->img_profile }}" alt="" height="80"></td>
                                        <td>{{ $advisor->accepted_students }}</td>
                                        <td>{{ $advisor->pending_students }}</td>
                                        <td>{{ $advisor->rejected_students }}</td>
                                        <td>
                                        @if ($advisor->accepted_students >= 3)
                                            <span style="color: red; font-weight: bold;">Full</span>
                                        @else
                                            <span style="color: green; font-weight: bold;">Available</span>
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
@section('js-script')
    <!-- jQuery Scrollbar -->
    <script src="/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Datatables -->
    <script src="/assets/js/plugin/datatables/datatables.min.js"></script>
    <!-- Atlantis JS -->
    <script src="/assets/js/atlantis.min.js"></script>
    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="/assets/js/setting-demo2.js"></script>
    	<!-- Sweet Alert -->
	<script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({});

            $('.btn-edit').click(function(e) {
                $('#editModalCenter').modal({
                        show: true
                            });
            });
            $('.btn-del').click(function(e) {

					swal({
						title: 'Are you sure?',
						text: "You won't be able to revert this!",
						type: 'warning',
						buttons:{
							confirm: {
								text : 'Yes, delete it!',
								className : 'btn btn-success'
							},
							cancel: {
								visible: true,
								className: 'btn btn-danger'
							}
						}
					}).then((Delete) => {
						if (Delete) {
                            $('#frm-'+this.id).submit();
						} else {
							swal.close();
						}
					});
				});



        });


    </script>
@endsection

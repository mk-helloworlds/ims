@extends('layouts.back-end')
@section('main-title')
ADVISOR PENDING REQUEST
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
);
?>
@section('body')

    <!-- Button trigger modal -->
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

<div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <!-- For Advisor to See the Request Student -->

                <h3>Pending Requests</h3>

                <p>User ID: {{Auth::id()}} | User Role: {{Auth::user()->role->role_name}}</p>
                <p>Advisor's Name: {{Auth::user()->name}}</p>
                <!-- <p>{{Auth::user()}}</p> -->
                <!-- <strong>User Role: {{Auth::user()->role}}</strong>
                <strong>User Role: {{Auth::user()->role->role_name}}</strong> -->
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Internship ID</th>
                            <th>Internship name</th>
                            <th>Student Name</th>
                            <th>Advisor Name</th>
                            <th>Student CV</th>
                            <th>Student Message</th>
                            <th>Advisor Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($requests as $request)
                            <tr>
                                <td>{{ $request->id }}</td>
                                <td>{{ $request->internship->id }}</td>
                                <td>{{ $request->internship->internship_title }}</td>
                                <td>{{ $request->student->name }}</td>
                                <td>{{ $request->advisor->name }}</td>
                                <td>
                                    @if($request->cv)
                                    <a href="{{ asset('storage/' . $request->cv) }}" target="_blank">View CV</a>
                                    @endif
                                </td>
                                <td>{{ $request->message }}</td>
                                <td>
                                    <span class="badge badge-{{ $request->status == 'Rejected' ? 'danger' : ($request->status == 'Accepted' ? 'success' : 'warning') }}">
                                        {{ $request->status }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('advisor_advisor_selection.respond', $internshipId) }}" method="POST" style="display: inline-flex; align-items: center;">
                                        @csrf
                                        <input type="hidden" name="request_id" value="{{ $request->id }}">

                                        <!-- Response Message Field -->
                                        <div class="form-group mb-0" style="margin-right: 8px;">
                                            <textarea name="advisor_response_message" class="form-control" rows="1" placeholder="Response (optional)" style="resize: none; width: 150px;"></textarea>
                                        </div>

                                        <button name="status" value="Accepted" class="btn btn-sm btn-success mr-2">Accept</button>

                                        <button name="status" value="Rejected" class="btn btn-sm btn-danger">Reject</button>
                                    </form>
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

            <h3>ACCEPTED / REJECTED STUDENT</h3>

            <p>User ID: {{Auth::id()}} | User Role: {{Auth::user()->role->role_name}}</p>
            <p>Advisor's Name: {{Auth::user()->name}}</p>
            <!-- <p>{{Auth::user()}}</p> -->
            <!-- <strong>User Role: {{Auth::user()->role}}</strong>
            <strong>User Role: {{Auth::user()->role->role_name}}</strong> -->
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Internship ID</th>
                        <th>Internship name</th>
                        <th>Student Name</th>
                        <th>Advisor Name</th>
                        <th>Student CV</th>
                        <th>Student Message</th>
                        <th>Status</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($AdvisorStudentRequest as $request)
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
                    <th>{{ $request->message}}</th>
                    <th>{{ $request->advisor_response_message }}</th>
                    <td>
                    <span class="badge badge-{{ $request->status == 'Rejected' ? 'danger' : ($request->status == 'Accepted' ? 'success' : 'warning') }}">
                    {{ $request->status }}         
                    </span></td>
                </tr>
                @endforeach
                </tbody>
            </table>
            
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

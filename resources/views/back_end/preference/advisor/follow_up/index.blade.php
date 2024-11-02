@extends('layouts.back-end')
@section('main-title')
ADVISOR : FOLLOW UP FORM
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
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
            
            <!-- ADD NEW USER BUTTON

            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title"></h4>
                    <a href="{{route('follow_up.create')}}"
                        class="btn btn-sm btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Add New FOLLOW UP
                </a>
                </div>
            </div> -->

            <div class="card-body">
                <h4><b>ADVISOR INFORMATION</b></h4>
                <h4>USER ID: {{Auth::user()->id}}</h4>
                <h4>ADVISOR NAME : {{Auth::user()->name}}</h4>
                <h4>ROLE : {{strtoupper(Auth::user()->role->role_name)}}</h4>
                <td><img src="{{Auth::user()->img_profile}}" alt="" height="80"></td>

                
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">MY STUDENTS</h4>
                </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-hover mt-3">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Request ID</th>
                            <th scope="col">Internship ID</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Advisor</th>
                            <th scope="col">Request Status</th>
                            <th scope="col">Last Follow Up Date</th>
                            <th scope="col">Notes</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($studentRequests as $key => $request)
                            @php
                                // Get the follow-up for this student request, if it exists
                                $followUp = $followUps->get($request->id);
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $request->id }}</td>
                                <td>{{ $request->internship->internship_title }}</td>
                                <td>{{ $request->student->name }}</td>
                                <td>{{ $request->advisor->name }}</td>
                                <td>
                                    <span class="badge badge-{{ $request->status == 'Accepted' ? 'success' : 'danger' }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                
                                <!-- Display Follow-up Info or N/A -->
                                <td>{{ $followUp ? $followUp->follow_up_date : 'N/A' }}</td>
                                <td>{{ $followUp ? $followUp->notes : 'N/A' }}</td>
                                <td>{{ $followUp ? $followUp->status : 'N/A' }}</td>
                                <td>
                                    <div class="d-inline-flex">
                                        <a href="{{route('advisor.follow_up.student_detail', $request->id)}}"
                                            class="btn btn-sm btn-primary">
                                            Show Details
                                        </a>
                                    </div>
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
								className : 'btn btn-sm btn-success'
							},
							cancel: {
								visible: true,
								className: 'btn btn-sm btn-danger'
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

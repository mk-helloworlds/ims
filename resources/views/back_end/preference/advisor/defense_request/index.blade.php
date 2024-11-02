@extends('layouts.back-end')
@section('main-title')
ADVISOR : DEFENSE REQUEST
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
            <div class="table-responsive">
                <table class="table table-hover mt-3">
                    <thead>
                        <tr>
                            <th scope="col">No</th>

                            <th scope="col">Defense Reuqest ID</th>
                            <th scope="col">Thesis Document ID</th>
                            <th scope="col">Student_Request_ID</th>

                            <th scope="col">student Name</th>
                            <th scope="col">Advisor Name</th>
                            <th scope="col">Internship ID</th>
                            <th scope="col">Request_Status</th>
                            <th scope="col">Thesis Document status</th>

                            <th scope="col">Defense Request status</th>

                            <th scope="col">Action</th>
                        </tr>
                    </thead>    
                 
                    <tbody>
                        @foreach ($results as $row)

                            <tr>
                                <td class="">
                                    {{ ($loop->iteration) + ($results->perPage() * ($results->currentPage() - 1)) }}
                                </td>
                                <td class="">{{ $row->id}}</td>
                                <td class="">{{ $row->thesisDocument->id}}</td>
                                <td class="">{{ $row->thesisDocument->student_request->id}}</td>

                                <td class="">{{ $row->thesisDocument->student_request->student->name}}</td>
                                <td class="">{{ $row->thesisDocument->student_request->advisor->name}}</td>

                                <td class="">{{ $row->thesisDocument->student_request->internship_id}}</td>

                                <td>
                                    <span class="badge badge-{{ $row->thesisDocument->student_request->status == 'Accepted' ? 'success' : ($row->thesisDocument->student_request->status == 'Pending' ? 'primary' : 'danger')}}">
                                        {{ ucfirst($row->thesisDocument->student_request->status)}}
                                    </span>
                                </td>


                                <td>
                                    <span class="badge badge-{{ $row->thesisDocument->status == 'submitted' ? 'primary' : ($row->thesisDocument->status == 'accepted' ? 'success' : 'danger') }}">
                                        {{ ucfirst($row->thesisDocument->status) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge badge-{{ $row->status == "pending" ? 'warning' : ($row->status == 'approved' ? 'success' : 'danger') }} ">
                                    {{ ucfirst($row->status) }}
                                    </span>
                                </td>

                                <!-- ACTION BUTTON -->
                                
                                <td>
                                        <form action="{{ route('advisor_defense_request.update', $row->id)}}" method="POST">
    
                                            @method('put')
                                            @csrf
                                            <div class="d-inline-flex">
                                            <button name="status" value="approved" class="btn btn-sm btn-success">Approved</button>
    
                                            <button name="status" value="rejected" class="btn btn-sm btn-danger">Reject</button>
                                            </div>
                                        </form>
                                    </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            <div class="card-footer">
                {{$results->appends(request()->input())->links()}}
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

@extends('layouts.back-end')
@section('main-title')
STUDENT THESIS DOCUMENT
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
);
?>
@section('body')
    <div class="col-md-12">
        <div class="card">
            
            <!-- ADD NEW USER BUTTON -->

            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title"></h4>
                    <a href="{{route('student_thesis_document.create')}}"
                        class="btn btn-sm btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        ADD STUDENT : THESIS DOCUMENTS
                </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-hover mt-3">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Thesis Document ID</th>

                            <th scope="col">Student_Request_ID</th>
                            <th scope="col">User Student ID</th>
                            <th scope="col">User Advisor ID</th>
                            <th scope="col">Internship ID</th>
                            <th scope="col">Request Status</th>

                            <th scope="col">Document status</th>
                            <th scope="col">student_thesis</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                 
                    <tbody>
                        @foreach ($results as $row)

                            <tr>
                            <td class="text-center">
                                    {{ ($loop->iteration) + ($results->perPage() * ($results->currentPage() - 1)) }}
                                </td>
                                <td class="text-center">{{ $row->id}}</td>

                                <td class="text-center">{{ $row->student_request->id}}</td>
                                <td class="text-center">{{ $row->student_request->student->name}}</td>
                                <td class="text-center">{{ $row->student_request->advisor->name}}</td>
                                <td class="text-center">{{ $row->student_request->internship_id}}</td>
                                <td class="text-center">{{ $row->student_request->status}}</td>

                                <td>
                                    <span class="badge badge-{{ $row->status == 'submitted' ? 'primary' : ($row->status == 'accepted' ? 'success' : 'danger') }}">
                                        {{ ucfirst($row->status) }}
                                    </span>
                                </td>
                                <td class="">{{ $row->student_thesis }}</td>
                                
                                <td>
                                    <!-- EDIT BUTTON -> EDIT PAGE -->
                                    <a href="{{ route('student_thesis_document.edit', $row->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                    <!-- DELETE BUTTON -> DELETE DIRECTLY BASED ON ID-->
                                    <form action="{{ route('student_thesis_document.destroy', $row->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
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

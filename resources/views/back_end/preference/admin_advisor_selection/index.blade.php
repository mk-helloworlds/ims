@extends('layouts.back-end')
@section('main-title')
ADMIN STUDENT_ADVISOR CRUD
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
);
?>
@section('body')
    <!-- Display error messages, if any -->
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

    <div class="col-md-12">
        <div class="card">

            <!-- ADD NEW STUDENT REQUEST BUTTON -->

            <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title"></h4>
                            <a href="{{ route('admin_advisor_selection.create', $internshipId) }}"
                                class="btn btn-sm btn-primary btn-round ml-auto">
                                <i class="fa fa-plus"></i>
                                ADD NEW STUDENT REQUEST
                            </a>
                    </div>
                </div>  
            <div class="card-body">

                <h4><strong>CURRENT USER  |  User ID: {{Auth::id()}} | User Role: {{Auth::user()->role->role_name}}</strong></h4>        
                    
                <p>User's Name: {{Auth::user()->name}}</p>

                <!-- DISPLAYING CURRENT LOG (AUTH) USER -->

                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Request ID</th>
                            <th>Internship ID</th>
                            <th>Internship Title</th>
                            <th>Student Name</th>
                            <th>Advisor Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($results as $result)
                            <tr>
                                <td class="text-center">
                                    {{ ($loop->iteration) + ($results->perPage() * ($results->currentPage() - 1)) }}
                                </td>
                                <td>{{ $result->id }}</td>
                                <td>{{ $result->internship->id }}</td>
                                <td>{{ $result->internship->internship_title }}</td>
                                <td>{{ $result->student->name }}</td>
                                <td>{{ $result->advisor->name }}</td>

                                <td>
                                    <span class="badge badge-{{ $result->status == 'Accepted' ? 'success' : ($result->status == 'Pending' ? 'primary' : 'danger')}}">
                                        {{ ucfirst($result->status)}}
                                    </span>
                                </td>

                                <td>
                                        <!-- EDIT BUTTON -> EDIT PAGE -->
                                        <a href="{{ route('admin_advisor_selection.edit', ['internship' => $internshipId, 'id' => $result->id]) }}" class="btn btn-sm btn-primary">Edit</a>

                                        <!-- DELETE BUTTON -> DELETE DIRECTLY BASED ON ID-->
                                        <form action="{{ route('admin_advisor_selection.destroy',['internship' => $internshipId, 'id' => $result->id]) }}" method="POST" style="display:inline;">
                                            
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                        </form>
                                    </td>
                                </td>
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

@extends('layouts.back-end')
@section('main-title')
INTERNSHIP PROJECTS
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
);
?>
@section('body')
    <div class="col-md-12 offset-sm">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title"></h4>

                    <!-- ADD NEW BUTTON -->
                    <a href="{{route('internship_project.create')}}"

                        class="btn btn-primary btn-sm btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Add New Internship Project
                </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table mt-3">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Internship ID</th>
                                <th scope="col">Internship Title</th>
                                <th scope="col">Project Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Student Name</th>
                                <th scope="col">Advisor Name</th>
                                <th scope="col">Student Request Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $i=>$row)
                                <tr>
                                    <td class="text-center">{{ $i+1+($results->perPage()*($results->currentPage()-1))}}</td>
                                    
                                    <td>{{ $row->studentRequest->internship->id }}</td>
    
                                    <td>{{ $row->studentRequest->internship->internship_title }}</td>
                                    
                                    <!-- Project Information -->
                                    <td>{{ $row->project_name }}</td>
                                    <td>{{ $row->description }}</td>
                                    <td>{{ $row->start_date }}</td>
                                    <td>{{ $row->end_date }}</td>
    
                                    <!-- Student and Advisor are accessed via studentRequest relationship -->
                                    <td>{{ $row->studentRequest->student->name }}</td>
                                    <td>{{ $row->studentRequest->advisor->name }}</td>
    
                                    <td class="text-center">
                                        <span class="badge badge-{{ $row->studentRequest->status == 'Accepted' ? 'success' : ($row->studentRequest->status == 'Pending' ? 'primary' : 'danger')}}">{{ucfirst($row->studentRequest->status)}}
                                        </span>
                                    </td>
                                    
                                    <td>
                                        <div class="d-inline-flex">
                                            <a href="{{ route('internship_project.edit', $row->id) }}" class="btn btn-sm btn-primary">Edit</a>
        
                                            <!-- DELETE BUTTON -> DELETE DIRECTLY BASED ON ID -->
                                            <form action="{{ route('internship_project.destroy', $row->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
        
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this project?');">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
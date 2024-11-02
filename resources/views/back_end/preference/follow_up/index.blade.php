@extends('layouts.back-end')
@section('main-title')
ADMIN : FOLLOW UP FORM
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

            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title"></h4>
                    <a href="{{route('follow_up.create')}}"
                        class="btn btn-sm btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Add New FOLLOW UP
                </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mt-3">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">ID</th>
                                <th scope="col">Request ID</th>
                                <th scope="col">User Name</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Internship ID</th>
                                
                                <th scope="col">Student Request Status</th>
                                <th scope="col">follow_up_date</th>
                                <th scope="col">notes</th>
                                <th scope="col">status</th>
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
                                    <td class="">{{ $row->studentRequest->id }}</td>
                                    <td class="text-center">{{ $row->studentRequest->student->name}}</td>
                                    <td class="">{{ $row->studentRequest->advisor->name }}</td>
                                    <td class="">{{ $row->studentRequest->internship->internship_title }}</td>
                                    

                                    <td class="text-center">
                                    <span class="badge badge-{{ $row->studentRequest->status == 'Pending' ? 'warning' : ($row->studentRequest->status == 'Accepted' ? 'success' : 'danger') }}">
                                        {{ $row->studentRequest->status }}
                                    </span>
                                    </td>

                                    <td class="">{{ $row->follow_up_date }}</td>
                                    <td class="">{{ $row->notes }}</td>

                                    <td class="text-center">
                                        <span class="badge badge-{{ $row->status == 'On Track' ? 'primary' : ($row->status == 'Behind Schedule' ? 'warning' : 'success') }}">
                                            {{ $row->status }}
                                        </span>
                                    </td>
                                    
                                    <td>
                                        <div class="d-inline-flex">
                                            <a href="{{ route('follow_up.edit', $row->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        
                                            <form action="{{ route('follow_up.destroy', $row->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                
                                                @method('DELETE')
    
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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

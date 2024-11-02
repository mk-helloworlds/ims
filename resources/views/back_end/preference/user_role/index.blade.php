@extends('layouts.back-end')
@section('main-title')
USER ROLES
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
);
?>
@section('body')
    <div class="col-md-12">
        <div class="card">

            <!-- Button for Create -->
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title"></h4>
                    <a href="{{route('user_role.create')}}"
                        class="btn btn-sm btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Add New User Roles
                </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-hover mt-3">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Role</th>
                            <th scope="col">Updated</th>
                            <th scope="col">Created</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($results as $i=>$row)

                        <tr>
                            <!-- <td class="text-center">{{ $i+1+($results->perPage()*($results->currentPage()-1))}}</td> -->

                                <td>{{ $row->id }}</td>
                                <td>{{ $row->role_name }}</td>
                                <td>{{ $row->updated_at }}</td>
                                <td>{{ $row->created_at }}</td>
                                <td>
                                    <div class="d-inline-flex">
                                        <a href="{{ route('user_role.edit', $row->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <!-- DELETE BUTTON -> DELETE DIRECTLY BASED ON ID-->
                                        <form action="{{ route('user_role.destroy', $row->id) }}" method="POST" style="display:inline;">
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

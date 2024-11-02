@extends('layouts.back-end')
@section('main-title')
JURY GROUP
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
                    <a href="{{route('jury_group.create')}}"
                        class="btn btn-sm btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Add New JURY GROUP
                </a>
                </div>
            </div>

            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mt-3">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">internship_id</th>
                            <th scope="col">Internship_name</th>
                            <th scope="col">Jury 1 [ID | Name]</th>
                            <th scope="col">Jury 2 [ID | Name]</</th>
                            <th scope="col">Jury 3 [ID | Name]</</th>
                            <th scope="col">Jury 4 [ID | Name]</</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($results as $row)

                            <tr>
                                <td>{{ $row->id}}</td>
                                <td>{{ $row->internship_id }}</td>
                                <td>{{ $row->internship->internship_title }}</td>
                                <td>{{ $row->user_jury1_id }} | {{$row->jury1->name}}</td>
                                <td>{{ $row->user_jury2_id }} | {{$row->jury2->name}}</td>
                                <td>{{ $row->user_jury3_id }} | {{$row->jury3->name}}</td>
                                <td>{{ $row->user_jury4_id }} | {{$row->jury4->name}}</td>
                                <td>
                                    <div class="d-inline-flex">
                                        <a href="{{ route('jury_group.edit', $row->id) }}" class="btn btn-sm btn-primary">Edit</a>
    
                                        <form action="{{ route('jury_group.destroy', $row->id) }}" method="POST" style="display:inline;">
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

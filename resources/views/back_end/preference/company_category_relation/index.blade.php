@extends('layouts.back-end')
@section('main-title')
COMPANY CATEGORY RELATION
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
);
?>
@section('body')
<div class="row">
    <!-- Button trigger modal -->


    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title"></h4>

                    <!-- ADD NEW BUTTON -->
                    <a href="{{route('company_category_relation.create')}}"

                        class="btn btn-sm btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Add New Company Category Relation
                </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">company_id</th>
                            <th scope="col">category_id</th>
                            <th scope="col">company_name</th>
                            <th scope="col">category_name</th>
                            <th scope="col">action</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <!-- $results is the value getting from the controller 
                        Controller(with(['results' => $results])) -->

                        <!-- dd($results) -->

                        <!-- $results return values as array like this 
                         Company {
                                id: 1
                                company_name: "Tech1"
                                company_profile: "Tech1 Hello worldHello worldHello worldHello world"
                                created_at: "2024-08-27 10:00:00"
                                updated_at: "2024-08-27 10:00:00"
                                }, -->

                        @foreach ($results as $i=>$row)

                            <tr>
                                <td class="text-center">{{ $i+1+($results->perPage()*($results->currentPage()-1))}}</td>

                                <td>{{ $row->company_id }}</td>
                                <td>{{ $row->category_id }}</td>
                                <!-- Using the ELOQUENT Relationship -->
                                <td>{{ $row->company->company_name ?? 'N/A'}}</td>
                                <td>{{ $row->category->category_name ?? 'N/A'}}</td>
                                <td>
                                    <!-- EDIT BUTTON -> EDIT PAGE -->
                                    <a href="{{ route('company_category_relation.edit', $row->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                    <!-- DELETE BUTTON -> DELETE DIRECTLY BASED ON ID-->
                                    <form action="{{ route('company_category_relation.destroy', $row->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                    </form>
                                    </div>


                              </form>
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

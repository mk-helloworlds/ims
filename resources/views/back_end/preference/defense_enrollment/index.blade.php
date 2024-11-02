@extends('layouts.back-end')
@section('main-title')
DEFENSE ENROLLMENT
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
);
?>
@section('body')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title"></h4>
                    <a href="{{route('defense_enrollment.create')}}"
                        class="btn btn-sm btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Add New DEFENSE ENROLLMENT
                </a>
                </div>
            </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>

                            <!-- INTERNSHIP TABLE-->
                            <th scope="col">Internship_ID</th>
                            <th scope="col">Internship_Title</th>
                            <th scope="col">School</th>
                            <th scope="col">Generation</th>
                            <th scope="col">Internship Type</th>

                            <!-- STUDENT REQUEST TABLE -->
                            <th scope="col">Student_Request ID</th>
                            <th scope="col">Student</th>
                            <th scope="col">Advisor</th>
                            <th class="text-center" scope="col">Student_Request Status</th>

                            <!-- THESIS & DEFENSE REQUEST -->
                            <th class="text-center" scope="col">Thesis_document Status</th>
                            <th class="text-center" scope="col">Defense Request Status</th>

                            <th scope="col">Jury Group</th>
                            <th scope="col">Jury 1</th>
                            <th scope="col">Jury 2</</th>
                            <th scope="col">Jury 3</</th>
                            <th scope="col">Jury 4</</th>

                            <th scope="col">defense_date</</th>
                            <th scope="col">status</</th>

                            <th scope="col">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($results as $row)

                            <tr>
                                <td>{{$row->id}}</td>

                                <!-- INTERNSHIP TABLE-->
                                <td>{{$row->defenseRequest->thesisDocument->student_request->internship->id}}</td>
                                <td>{{$row->defenseRequest->thesisDocument->student_request->internship->internship_title}}</td>
                                <td>{{$row->defenseRequest->thesisDocument->student_request->internship->school}}</td>
                                <td>{{$row->defenseRequest->thesisDocument->student_request->internship->generation}}</td>
                                <td>{{$row->defenseRequest->thesisDocument->student_request->internship->type}}</td>

                                <!-- STUDENT REQUEST TABLE -->
                                <td>{{$row->defenseRequest->thesisDocument->student_request->id}}</td>
                                <td >{{$row->defenseRequest->thesisDocument->student_request->student->name}}</td>
                                <td>{{$row->defenseRequest->thesisDocument->student_request->advisor->name}}</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $row->defenseRequest->thesisDocument->student_request->status == 'Accepted' ? 'success' : ($row->defenseRequest->thesisDocument->student_request->status == 'Pending' ? 'primary' : 'danger')}}">{{ucfirst($row->defenseRequest->thesisDocument->student_request->status)}}
                                    </span>
                                </td>

                                <!-- THESIS & DEFENSE REQUEST -->
                                <td class="text-center">
                                    <span class="badge badge-{{ $row->defenseRequest->thesisDocument->status == 'submitted' ? 'primary' : ($row->defenseRequest->thesisDocument->status == 'accepted' ? 'success' : 'danger') }}">
                                        {{ ucfirst($row->defenseRequest->thesisDocument->status) }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="badge badge-{{ $row->defenseRequest->status == "pending" ? 'warning' : ($row->defenseRequest->status == 'approved' ? 'success' : 'danger') }}">
                                    {{ ucfirst($row->status) }}
                                    </span>
                                </td>

                                <!-- JURY -->
                                <td class="text-center" >{{$row->jury_group_id}}</td>
                                <td>{{$row->juryGroup->user_jury1_id}} | {{$row->juryGroup->jury1->name}}</td>
                                <td>{{$row->juryGroup->user_jury2_id}} | {{$row->juryGroup->jury2->name}}</td>
                                <td>{{$row->juryGroup->user_jury3_id}} | {{$row->juryGroup->jury3->name}}</td>
                                <td>{{$row->juryGroup->user_jury4_id}} | {{$row->juryGroup->jury4->name}}</td>
                               
                                
                                <td>{{$row->defense_date}}</td>

                                <td>
                                    <span class="badge badge-{{ $row->status == "Scheduled" ? 'primary' : 'success'}}">
                                    {{ ucfirst($row->status) }}
                                    </span>
                                </td>
                                
                                <td>
                                    <div class="d-inline-flex">
                                        <a href="{{ route('defense_enrollment.edit', $row->id) }}" class="btn btn-sm btn-primary">Edit</a>
    
                                        <form action="{{ route('defense_enrollment.destroy', $row->id) }}" method="POST" style="display:inline;">
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

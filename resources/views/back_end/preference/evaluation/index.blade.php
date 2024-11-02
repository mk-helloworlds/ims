@extends('layouts.back-end')
@section('main-title')
ADMIN -
ALL STUDENT EVALUATION
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
);
?>
@section('body')
<div class="row">
    <!-- Button trigger modal -->

        <div class="card">

        <div class="card-body">
            
        <div class="card-body">
            <h3>STUDENT BELONGING TO THE JURY</h3>
            <div class="table-responsive">
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th scope="col">Enrollment ID</th>

                            <!-- INTERNSHIP TABLE-->
                            <th scope="col">Internship_Title</th>
                           

                            <!-- STUDENT REQUEST TABLE -->
                            <th scope="col">Student</th>
                            <th scope="col">Advisor</th>
                            <th class="text-center" scope="col">Defense Request Status</th>

                            <th scope="col">Jury Group</th>
                            <th scope="col">Jury 1</th>
                            <th scope="col">Jury 2</</th>
                            <th scope="col">Jury 3</</th>
                            <th scope="col">Jury 4</</th>

                            <th scope="col">defense_date</</th>
                            <th scope="col">Evaluation status</</th>

                            <th class="text-center" scope="col">Jury 1</th>
                            <th class="text-center" scope="col">Jury 2</th>
                            <th class="text-center" scope="col">Jury 3</th>
                            <th class="text-center" scope="col">Jury 4</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($results as $row)

                            <tr>
                                <td>{{$row->id}}</td>

                                <!-- INTERNSHIP TABLE-->
                                
                                <td>{{$row->defenseRequest->thesisDocument->student_request->internship->internship_title}}</td>
                                

                                <!-- STUDENT REQUEST TABLE -->
                                <td>{{$row->defenseRequest->thesisDocument->student_request->student->name}}</td>
                                <td>{{$row->defenseRequest->thesisDocument->student_request->advisor->name}}</td>
                                
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
                                    <span class="badge badge-{{ $row->status == 'Scheduled' ? 'primary' : 'success'}}">
                                        {{ ucfirst($row->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('evaluation.filter_by_jury', ['defense_enrollment_id' => $row->id, 'jury_id' => $row->juryGroup->user_jury1_id]) }}" class="btn btn-sm btn-warning">Jury 1 Evaluation</a>
                                </td>
                                <td>
                                    <a href="{{ route('evaluation.filter_by_jury', ['defense_enrollment_id' => $row->id, 'jury_id' => $row->juryGroup->user_jury2_id]) }}" class="btn btn-sm btn-warning">Jury 2 Evaluation</a>
                                </td>
                                <td>
                                    <a href="{{ route('evaluation.filter_by_jury', ['defense_enrollment_id' => $row->id, 'jury_id' => $row->juryGroup->user_jury3_id]) }}" class="btn btn-sm btn-warning">Jury 3 Evaluation</a>
                                </td>
                                <td>
                                    <a href="{{ route('evaluation.filter_by_jury', ['defense_enrollment_id' => $row->id, 'jury_id' => $row->juryGroup->user_jury4_id]) }}" class="btn btn-sm btn-warning">Jury 4 Evaluation</a>
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

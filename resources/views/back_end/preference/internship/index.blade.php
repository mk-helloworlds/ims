@extends('layouts.back-end')
@section('main-title')
MANAGE INTERNSHIPS
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
                    <a href="{{route('internship.create')}}"
                        class="btn btn-sm btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Add New Internship
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
                            <th scope="col">Internship Title</th>
                            <th scope="col">Type</th>
                            <th scope="col">Period</th>
                            <th scope="col">School</th>
                            <th scope="col">Generation</th>
                            <th scope="col">description</th>
                            <th scope="col">start_date</th>
                            <th scope="col">end_date</th>
                            <th scope="col" class="text-center">Manage Participant</th>
                            <th scope="col" class="text-center">Advisor Selection</th>
                            <th scope="col" class="text-center">Student Internship Project (NEW)</th>
                            <th scope="col" class="text-center">Submission Form</th>
                            <th scope="col" class="text-center">Follow Up</th>
                            <th scope="col" class="text-center">Thesis Document</th>
                            <th scope="col" class="text-center">Defense Request</th>
                            <th scope="col" class="text-center">Manage Jury Group</th>
                            <th scope="col" class="text-center">Defense Enrollment</th>
                            <th scope="col" class="text-center">Evaluation</th>
                            <th scope="col" class="text-center">Defense Results</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($results as $row)

                            <tr>
                            <td class="text-center">
                                    {{ ($loop->iteration) + ($results->perPage() * ($results->currentPage() - 1)) }}
                                </td>
                                <td class="text-center">{{ $row->id}}</td>
                                <td>{{ $row->internship_title }}</td>
                                <td class="text-center">{{ $row->type }}</td>
                                <td class="text-center">{{ $row->period }}</td>
                                <td class="text-center">{{ $row->school }}</td>
                                <td class="text-center">{{ $row->generation }}</td>
                                <td>{{ $row->description }}</td>
                                <td>{{ $row->start_date }}</td>
                                <td>{{ $row->end_date }}</td>
                                <td>
                                    <a href="{{ route('internship.show', $row->id) }}" class="btn btn-sm btn-info mr-1">Manage Participant</a>
                                </td>

                                <td>
                                    <div class="d-inline-flex">
                                    <a href="" class="btn btn-sm btn-info mr-1">student_advisor_selection</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">advisor_advisor_selection</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">admin_manage_advisor_selection</a>
                                </td>

                                <td>
                                    <div class="d-inline-flex">
                                    <a href="" class="btn btn-sm btn-info mr-1">student_internship_project</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">advisor_internship_project</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">admin_manage_internship_project</a>
                                </td>

                                <td>
                                    <div class="d-inline-flex">
                                    <a href="" class="btn btn-sm btn-info mr-1">student_submission_form</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">admin_manage_submission_form</a>
                                </td>

                                <td>
                                    <div class="d-inline-flex">
                                    <a href="" class="btn btn-sm btn-info mr-1">student_follow_up</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">advisor_follow_up</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">admin_manage_follow_up</a>
                                </td>

                                <td>
                                    <div class="d-inline-flex">
                                    <a href="" class="btn btn-sm btn-info mr-1">student_thesis_document</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">advisor_thesis_document</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">admin_manage_thesis_document</a>
                                </td>

                                <td>
                                    <div class="d-inline-flex">
                                    <a href="" class="btn btn-sm btn-info mr-1">student_defense_request</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">advisor_defense_request</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">admin_manage_defense_request</a>
                                </td>

                                <td>
                                    <div class="d-inline-flex">
                                    <a href="" class="btn btn-sm btn-info mr-1">admin_manage_jury group</a>
                                </td>

                                <td>
                                    <div class="d-inline-flex">
                                    <a href="" class="btn btn-sm btn-info mr-1">student_defense_enrollment</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">advisor_defense_enrollment</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">admin_manage_defense_enrollment</a>
                                </td>

                                <td>
                                    <div class="d-inline-flex">
                                    <a href="" class="btn btn-sm btn-info mr-1">jury_evaluation</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">admin_manage_evaluation</a>
                                </td>

                                <td>
                                    <div class="d-inline-flex">
                                    <a href="" class="btn btn-sm btn-info mr-1">advisor_defense_results</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">jury_defense_results</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">student_defense_results</a>
                                    <a href="" class="btn btn-sm btn-info mr-1">admin_manage_defense_results</a>
                                </td>

                                <td>
                                    <div class="d-inline-flex">

                                        <!-- EDIT BUTTON -> EDIT PAGE -->
                                        <a href="{{ route('internship.edit', $row->id) }}" class="btn btn-sm btn-primary">Edit</a>
    
                                        <!-- DELETE BUTTON -> DELETE DIRECTLY BASED ON ID-->
                                        <form action="{{ route('internship.destroy', $row->id) }}" method="POST" style="display:inline;">
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

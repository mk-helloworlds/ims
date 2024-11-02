@extends('layouts.back-end')
@section('main-title')
ALL STUDENT EVALUATION
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
                <h4 class="card-title">ALL STUDENT EVALUATION</h4>
            </div>

    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-hover mt-3">
                <thead>
                    <tr>
                        <th>DE ID</th>
                        <th>Generation</th>
                        <th>Student Name</th>
                        <th>Advisor Name</th>
                        <th>Internship Title</th>
                        <th>School</th>
                        <th>Internship Type</th>
                        <th>DE Status</th>
                        <th>Company Name</th> <!-- New Column -->
                        <th style="width: 10%;">Internship Project</th> <!-- New Column -->
                        <th>Jury 1 (Score)</th>
                        <th>Jury 2 (Score)</th>
                        <th>Jury 3 (Score)</th>
                        <th>Jury 4 (Score)</th>
                        <th>Total Score</th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($defenseEnrollments as $defenseEnrollment)
                        <tr>
                            <td>{{ $defenseEnrollment->id }}</td>
                            <td>{{ $defenseEnrollment->defenseRequest->thesisDocument->student_request->internship->generation }}</td>
                            <td>{{ $defenseEnrollment->defenseRequest->thesisDocument->student_request->student->name }}</td>
                            <td>{{ $defenseEnrollment->defenseRequest->thesisDocument->student_request->advisor->name }}</td>
                            <td>{{ $defenseEnrollment->defenseRequest->thesisDocument->student_request->internship->internship_title }}</td>
                            <td>{{ $defenseEnrollment->defenseRequest->thesisDocument->student_request->internship->school }}</td>
                            
                            <td>{{ $defenseEnrollment->defenseRequest->thesisDocument->student_request->internship->type == 1 ? 'Internship 1' : 'Internship 2' }}</td>

                            <!-- Defense Enrollment Status Badge -->
                            <td class="text-center">
                                <span class="badge badge-{{ $defenseEnrollment->status == 'Scheduled' ? 'primary' : 'success'}}">
                                    {{ ucfirst($defenseEnrollment->status) }}
                                </span>
                            </td>

                            <!-- Company Name -->
                            <td>{{ $defenseEnrollment->defenseRequest->thesisDocument->student_request->submissionForm->company->company_name ?? 'N/A' }}</td> 
                            
                            <!-- Internship Project -->
                            <td>{{ $defenseEnrollment->defenseRequest->thesisDocument->student_request->internshipProject->project_name ?? 'N/A' }}</td> 
                            
                            <!-- Jury names and scores -->
                            <td>{{ $defenseEnrollment->juryGroup->jury1->name }} ({{ $defenseEnrollment->evaluations->where('user_jury_id', $defenseEnrollment->juryGroup->user_jury1_id)->sum('score') }})</td>
                            <td>{{ $defenseEnrollment->juryGroup->jury2->name }} ({{ $defenseEnrollment->evaluations->where('user_jury_id', $defenseEnrollment->juryGroup->user_jury2_id)->sum('score') }})</td>
                            <td>{{ $defenseEnrollment->juryGroup->jury3->name }} ({{ $defenseEnrollment->evaluations->where('user_jury_id', $defenseEnrollment->juryGroup->user_jury3_id)->sum('score') }})</td>
                            <td>{{ $defenseEnrollment->juryGroup->jury4->name }} ({{ $defenseEnrollment->evaluations->where('user_jury_id', $defenseEnrollment->juryGroup->user_jury4_id)->sum('score') }})</td>
    
                            <!-- Total Jury Group Score with Conditional Color -->
                            <td class="text-center">
                                @php
                                    $totalScore = $defenseEnrollment->evaluations->sum('score');
                                @endphp
                                <span class="badge badge-{{ $totalScore < 60 ? 'danger' : ($totalScore <= 80 ? 'warning' : 'success') }}">
                                    {{ $totalScore }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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

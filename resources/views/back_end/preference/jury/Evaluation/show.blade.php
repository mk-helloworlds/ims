@extends('layouts.back-end')
@section('main-title')
JURY {{$currentJury->id}} | {{$currentJury->name}}
<div>
    <h3>
        Evaluate Student: 
        <b>
            {{ $defenseEnrollment->defenseRequest->thesisDocument->student_request->student->name }}
        </b>
    </h3>
</div>
<div>
    <h3>
        Defense Enrollment ID: 
        <b>
        {{ $defenseEnrollment->id }}
            <div>   
                    <br>
                    <p class="btn btn-lg btn-success btn ml-auto">
                    Total Score: {{ $totalScore }}
                    </p>
            </div>
        </b>
    </h3>
</div>
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
);
?>
@section('body')


<div class="row">
    <div class="card-body">
    <div class="col-md-12">
        <div class="card">
            <!-- Card Header -->
            <div class="card-header">
                <div class="align-items-center">
                    <div>
                        <h4 class="card-title">Defense Enrollment Details</h4>
                    </div>
                    <div>
                        <a href="{{route('jury_evaluation.create_with_param',$defenseEnrollment->id)}}" class="btn btn-sm btn-primary btn-round ml-auto">
                            <i class="fa fa-plus"></i>
                            Add New Evaluation
                        </a>
                    </div>

                    <div>
                        <form action="{{ route('jury_evaluation.delete_all', $defenseEnrollment->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger btn-round ml-auto" 
                                onclick="return confirm('Are you sure you want to delete all evaluations? This action cannot be undone.');">
                                <i class="fa fa-minus"></i>
                                Delete All Evaluations
                            </button>
                        </form>
                    </div>

                </div>
            </div>
            
            <!-- Card Body -->
            <div class="card-body">
                    <!-- Display Evaluation Data related to the Defense Enrollment -->
                    <h4 class="mt-4">Evaluation Data</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead table-bordered">
                                <tr>
                                    <th scope="col" class="text-center">QID</th>
                                    <th scope="col">Question</th>
                                    <th scope="col" class="text-center">Score</th>
                                    <th scope="col">Feedback</th>
                                    <th scope="col">Note</th>
                                    <th scope="col" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($defenseEnrollment->evaluations as $evaluation)
                                    <tr>
                                        <td class="text-center">{{ $evaluation->question_id }}</td>
                                        <td>{{ $evaluation->EvaluationQuestion->question_text }}</td>
                                        <td class="text-center">{{ $evaluation->score }}</td>
                                        <td>{{ $evaluation->feedback }}</td>
                                        <td>{{ $evaluation->note }}</td>
                                        <td class="text-center">
                                            <!-- EDIT BUTTON -->
                                            <a href="{{ route('jury_evaluation.edit', $evaluation->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                            <!-- DELETE BUTTON -->
                                            <form action="{{ route('jury_evaluation.destroy', $evaluation->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Card Footer -->
            <div class="">
                <a href="{{ route('jury_evaluation.index') }}" class="btn btn-primary">Back to Evaluations</a>
            </div>

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

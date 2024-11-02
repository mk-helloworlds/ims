@extends('layouts.back-end')
@section('main-title')
STUDENT : SUBMISSION FORM
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
);
?>
@section('body')
<div class="col-md-12 offset-sm">
    <div>
        @if($errors->all())
            <div class="alert alert-danger">
               <ul>
                @foreach($errors->all() as $message)
                    <li>{{$message}}</li>
                @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>

    <div class="col-md-12">
        <div class="card">
            
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title"></h4>
                    <a href="{{route('student_submission_form.create')}}"
                        class="btn btn-sm btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Add New SUBMISSION FORM
                </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                            <th scope="col">No</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Internship</th>
                                    <th scope="col">Student</th>
                                    <th scope="col">Advisor</th>
                                    <th scope="col">Student Request Status</th>
                                    <th scope="col">Company</th>
                                    <th scope="col">Supervisor Name</th>
                                    <th scope="col">Internship Agreement</th>
                                    <th scope="col">Advisor Confirmation Letter</th>
                                    <th scope="col">Internship Proposal</th>
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
    
                                    <td class="">{{ optional($row->student_request->internship)->internship_title ?? 'N/A' }}</td>
    
                                    <td class="">{{ optional($row->student_request->student)->name ?? 'N/A' }}</td>
        
                                    <td class="">{{ optional($row->student_request->advisor)->name ?? 'N/A' }}</td>
    
                                    <td class="text-center">
                                        <span class="badge badge-{{ $row->student_request->status == 'Accepted' ? 'success' : ($row->student_request->status == 'Pending' ? 'primary' : 'danger')}}">{{ucfirst($row->student_request->status)}}
                                        </span>
                                    </td>
    
                                    <!-- Company Information -->
                                    <td class="">{{ optional($row->company)->company_name ?? 'N/A' }}</td>
    
                                    <!-- Supervisor Name -->
                                    <td class="">{{ $row->supervisor_name }}</td>
        
                                    <!-- Internship Agreement PDF Link -->
                                    <td class="">
                                        @if ($row->internship_agreement)
                                            <a href="{{ Storage::url($row->internship_agreement) }}" target="_blank">{{ basename($row->internship_agreement) }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
    
                                    <!-- Advisor Confirmation Letter PDF Link -->
                                    <td class="">
                                        @if ($row->advisor_confirmation_letter)
                                            <a href="{{ Storage::url($row->advisor_confirmation_letter) }}" target="_blank">{{ basename($row->advisor_confirmation_letter) }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
    
                                    <!-- Internship Proposal PDF Link -->
                                    <td class="">
                                        @if ($row->internship_proposal)
                                            <a href="{{ Storage::url($row->internship_proposal) }}" target="_blank">{{ basename($row->internship_proposal) }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
    
                                    <!-- <td class="">{{ $row->internship_agreement }}</td>
                                    <td class="">{{ $row->advisor_confirmation_letter }}</td>
                                    <td class="">{{ $row->internship_proposal }}</td> -->
                                    
                                    <td>
                                        <div class="d-inline-flex">
                                            <a href="{{ route('student_submission_form.edit', $row->id) }}" class="btn btn-sm btn-primary">Edit</a>
        
                                            <!-- DELETE BUTTON -> DELETE DIRECTLY BASED ON ID-->
                                            <form action="{{ route('student_submission_form.destroy', $row->id) }}" method="POST" style="display:inline;">
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

@extends('layouts.back-end')
@section('main-title')
HOME PAGE
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
                    <a href="{{route('internship.create')}}"
                        class="btn btn-sm btn-primary btn-round ml-auto">
                        <i class="fa fa-plus"></i>
                        Add New Internship
                    </a>
                </div>
            </div>
            <br>
            <div class="col-md-12">
                    <div class="row">
                        @foreach ($internships as $internship)
                            <div class="col-md-4 mb-4">
                                <div id="card-hover" class="card h-100 shadow-md transition-shadow">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $internship->internship_title }}</h5>
                                        
                                        <p class="card-text">{{ Str::limit($internship->description, 100) }}</p>
                                        <p><strong>Generation:</strong> {{ $internship->generation }} | <strong>School:</strong> {{ $internship->school }} | <strong>Type:</strong> {{ $internship->type }} | <strong>Participants:</strong> {{ $internship->participants_count }} </p>
                                        
                                        <div class="mt-auto d-flex">
                                            <a href="{{ route('internship.show', $internship->id) }}" class="btn btn-info btn-round btn-sm mr-1">View Internship</a>
                                            <!-- <a href="{{ route('internship.edit', $internship->id) }}" class="btn btn-primary btn-round btn-sm mr-1">Edit</a>
                                            <form action="{{ route('internship.destroy', $internship->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-round btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this internship?');">Delete</button>
                                            </form> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
								className : 'btn btn-success'
							},
							cancel: {
								visible: true,
								className: 'btn btn-danger'
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
@section('css')
<style>
    /* Custom card shadow for a subtle effect */
    .card {
        transition: box-shadow 0.3s ease-in-out;
    }
    .card:hover {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15), 0 6px 6px rgba(0, 0, 0, 0.10);
    }
</style>
@endsection
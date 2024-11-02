
@extends('layouts.back-end')
@section('main-title')
តារាងអ្នកប្រើប្រាស់
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
);
?>
@section('body')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Select all toggle buttons
        const toggleButtons = document.querySelectorAll(".toggle-password");

        // Add click event listener to each button
        toggleButtons.forEach(button => {
            button.addEventListener("click", function() {
                const targetId = this.getAttribute("data-target");
                const targetInput = document.getElementById(targetId);

                // Toggle the input type between "password" and "text"
                if (targetInput.type === "password") {
                    targetInput.type = "text";
                    this.textContent = "Hide"; // Change button text to "Hide"
                } else {
                    targetInput.type = "password";
                    this.textContent = "Show"; // Change button text back to "Show"
                }
            });
        });
    });
</script>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2>
            My Profiles
            </h2>
        </div>
            <div class="card-body">

                @if($user->img_profile)
                    <p><strong>Profile Image:</strong></p>
                    <img class="border rounded 1px" src="{{ asset('storage/' . $user->img_profile) }}" alt="Profile Image" width="200" height="200px" style="object-fit: cover;">
                @endif

                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
    
                

                <a href="{{ route('dashboard') }}" class="btn btn-dark mt-3">Back to Dashboard</a>

                <a href="{{ route('my-profile.edit') }}" class="btn btn-primary mt-3">Edit Profile</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">

                <h3>Change Password</h3>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            
                <form action="{{ route('my-profile.update-password') }}" method="POST">
                    @csrf
            
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="current_password">
                                Show
                            </button>
                        </div>
                        @error('current_password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password">
                                Show
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password_confirmation">
                                Show
                            </button>
                        </div>
                    </div>
            
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>

        
    </div>
</div>

@endsection
@section('js-script')
    <script src="/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="/assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="/assets/js/atlantis.min.js"></script>
    <script src="/assets/js/setting-demo2.js"></script>
	<script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="/assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="/assets/js/core/bootstrap.min.js"></script>
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


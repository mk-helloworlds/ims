
@extends('layouts.blank')
@section('main-title')
FORM
@endsection

<?php
$maps = array(
    "/" => "ផ្ទាំងគ្រប់គ្រង",
    "#one" => "FORM",
);
?>
<style>
	body {
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 50vh;
    margin: 0;
}

button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

.floating-buttons {
    position: fixed;
    bottom: 20px;
    right: 20px;
    display: flex;
    flex-direction: column;
}

.floating-buttons button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px;
    margin: 5px 0;
    border-radius: 50px;
    cursor: pointer;
    font-size: 14px;
}

.floating-buttons button:hover {
    background-color: #0056b3;
}

</style>

@section('body')

<!-- Testing User account:  -->

	<div class="floating-buttons btn btn-sm btn-lg border">
		<p>Testing User account: </p>
        <button onclick="fillCredentials('admin@admin.com', '123123123')">Admin</button>
        <button onclick="fillCredentials('advisor@advisor.com', '123123123')">Advisor</button>
        <button onclick="fillCredentials('student@student.com', '123123123')">Student</button>
        <button onclick="fillCredentials('J1@gmail.com', '123123123')">Jury</button>
    </div>

	<script>
        function fillCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>

<!-- Testing User account:  -->


<div class="login">
<div class="wrapper wrapper-login">
		<div class="container container-login animated fadeIn">
			<h3 class="text-center">Login To System</h3>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    @if($errors->all())
                        <div class="alert alert-danger" role="alert">
                            @foreach($errors->all() as $message)
                                <li>{{$message}}</li>
                            @endforeach
                        </div>
                    @endif
                </div>
				
			<div class="login-form">
				<div class="form-group form-floating-label">
                    <input id="email" type="email" name="email" class="form-control input-border-bottom" value="mk@gmail.com" required autofocus>

					<label for="email" class="placeholder">Email</label>
			</div>

			<div class="form-group form-floating-label">
            
                    <input id="password" type="password" class="form-control input-border-bottom" name="password" value="123123123" required>
					<label for="password" class="placeholder" >Password</label>

					<!-- Show and Hide Passwords -->
					<div class="show-password">
						<i class="icon-eye"></i>
					</div>

				</div> 
				<div class="form-action mb-3">
					<button type="submit" class="btn btn-sm btn-primary btn-rounded btn-login">Sign In</button>
				</div>
			</div>

			</form>
		</div>

	</div> 


    @endsection
    @section('js-script')
	<script src="/assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="/assets/js/core/popper.min.js"></script>
	<script src="/assets/js/core/bootstrap.min.js"></script>
	<script src="/assets/js/atlantis.min.js"></script>
    @endsection
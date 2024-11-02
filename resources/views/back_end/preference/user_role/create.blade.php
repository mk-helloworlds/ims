@extends('layouts.back-end')
@section('main-title')
FORM
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
?>
@section('body')
    <div class="row">
        <!-- Button trigger modal -->


        <div class="col-md-12">
    
        <div class="card">
                <form id="user_role-form" action="{{ route('user_role.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body row">
                        @if($errors->all())
                            <div class="alert alert-danger bg-danger">
                               <ul>
                                @foreach($errors->all() as $message)
                                    <li>{{$message}}</li>
                                @endforeach
                                </ul>
                            </div>

                            <!-- the X button that does not work  -->
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        @endif

                        <div class="col-md-12">

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="role_name"> Name<span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="role_name" name="role_name" 
                                        placeholder="Enter the User Role" required>
                                </div>
                            </div>
                            
                        </div>


                    </div>

                    <div class="col-md-12">
                        <a href="{{route('user_role.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                         <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

@php use App\Http\Controllers\MyUtility; @endphp
@extends('layouts.back-end')
@section('main-title')
    My Profile
@endsection
<?php
$maps = array(
    "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"Edit Profile",
);
?>
@section('body')
    <div class="row">
        <!-- Button trigger modal -->


        <div class="col-md-12">

            <div class="card">
                <form id="user_role-form" action="{{ route('user.update_profile',$result->id) }}" method="post"
                      enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="card-body row">
                        @if($errors->all())
                            <div class="alert alert-danger bg-warning col-md-12 text-white" id="success-alert"  role="alert" data-notify-position="top-right"  data-mdb-delay="3000" style="opacity: 500; display: none;">
                                {{$errors->all()[2]}}
                            </div>
                        @endif
                        <div class="col-md-8">

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <label for="name">Display Name<span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="" value="{{$result->name}}" required>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <label for="email">Email <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="email" name="email"
                                           placeholder="" value="{{$result->email}}" required>
                                </div>
                            </div>
                            <div class="form-group form-show-validation row">
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label for="username">Username <span class="required-label">*</span></label>
                                    <input type="email" class="form-control" disabled
                                           placeholder="" value="{{$result->username}}" required>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label for="old_password">Old Password</label>
                                    <input type="text" class="form-control" id="old_password" name="old_password"
                                           placeholder="" >
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label for="password">Password</label>
                                    <input type="text" class="form-control" id="password" name="password"
                                           placeholder="" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <label for="photo">Image Profile</label>
                                    <input type="file" class="form-control" id="profile_img" name="profile_img"
                                           placeholder="Enter Photo"
                                           onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])">
                                </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                    <img id="preview" src="{{$result->profile_img}}" width="100">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <a href="/" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

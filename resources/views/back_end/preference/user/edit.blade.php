@php use App\Http\Controllers\MyUtility; @endphp
@extends('layouts.back-end')
@section('main-title')
    EDIT USER
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
        @if($errors->all())
            <div class="alert alert-danger bg-danger">
                <ul>
                @foreach($errors->all() as $message)
                <li>{{$message}}</li>
                @endforeach
                </ul>
            </div>
        @endif

        <div class="col-md-12">

            <div class="card">

            <!-- CONFIGURE THE ROUTE for Update  -->
                <form id="user-form" action="{{ route('user.update',$user->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    
                    @csrf
                    <div class="card-body row">
                        <div class="col-md-12">

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="name"> Name<span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="" value="{{$user->name}}" required>
                                </div>
                            </div>
                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="email">Email <span class="required-label">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           placeholder="" value="{{$user->email}}" required>
                                </div>
                            </div>

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="order">Role <span class="required-label">*</span></label>
                                </div>
                            </div>
                    
                            <!-- <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="old_password">Old Password</label>
                                    <input type="text" class="form-control" id="old_password" name="old_password"
                                           placeholder="" >
                                </div>
                            </div> -->

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="" >
                                </div>
                            </div>

                            <!-- DISPLAY THE CURRENT PIC/FILE -->
                            <div class="form-group">
                               <div class="col-lg-12 col-md-12 col-sm-12">
									<label for="img_profile">File input</label>
									<input type="file" class="form-control-file" id="img_profile" name="img_profile">
                                    <img src="/storage/{{$user->img_profile }}" alt="" height="150">
                               </div>
							</div>

                            <div class="form-group">

									<label for="img_profile">Role</label>

                                    <select name="user_role_id" id="user_role_id"  class="form-control">
                                        
                                        <option value="">Please Select</option>
                                        
                                        @foreach($roles as $r)

                                        <!-- TERINANRY OPERATOR FOR IF ELSE "SELECTED" Attribute -->
                                        <option value="{{$r->id}}" 
                                        
                                        {{$r->id==$user->user_role_id ?"selected":""}}>

                                            {{$r->role_name}}

                                        </option>
                                        @endforeach
                                    </select>
							</div>
                            

                        </div>


                    </div>

                    <div class="col-md-12">
                        <a href="{{route('user.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                    <input type="hidden" value="{{request()->page}}" name="page">
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

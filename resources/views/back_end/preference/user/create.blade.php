@extends('layouts.back-end')
@section('main-title')
CREATE USER
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

                <form id="user-form" action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
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
                                    <label for="name"> Name<span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}"
                                        placeholder="Enter Khmer Title" required>
                                </div>
                            </div>

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="email">Email <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email')}}"
                                        placeholder="Enter English Title" required>
                                </div>
                            </div>  

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="password">Password <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="password" name="password" value="{{ old('password')}}"
                                        placeholder="Enter English Title" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
									<label for="img_profile">File input</label>
									<input type="file" class="form-control-file" id="img_profile" name="img_profile" required>
							</div>

                            <div class="form-group">
									<label for="user_role_id">Role</label>
                                    <select name="user_role_id" id="user_role_id"  class="form-control">
                                        <option value="">Please Select</option>
                                        
                                        @foreach($roles as $r)
                                        <option value="{{$r->id}}">
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
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

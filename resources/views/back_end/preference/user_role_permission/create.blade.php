@extends('layouts.back-end')
@section('main-title')
CREATE USER ROLE PERMISSION
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
                <form id="user_role_permission-form" action="{{ route('user_role_permission.store') }}" method="post" enctype="multipart/form-data">
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

                                    <label for="user_id">Username<span class="required-label">*</span></label>

                                    <select name="user_id" id="">

                                        <option value="">-- Select Username --</option>
                                        
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    
                                <label for="role_id">Rolename<span class="required-label">*</span></label>
                                    
                                <select name="role_id" id="">

                                        <option value="">-- Select Role --</option>

                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                            @endforeach

                                    </select>
                                </div>
                            </div>
                            
                        </div>


                    </div>

                    <div class="col-md-12">
                        <a href="{{route('user_role_permission.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>

                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.back-end')
@section('main-title')
    EDIT USER PERMISSION
@endsection

<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"Edit",
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
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        @endif

        <div class="col-md-12">

            <div class="card">
                <form id="user_role_permission-form" action="{{ route('user_role_permission.update',$user_role_permission->id) }}" method="post"
                    enctype="multipart/form-data">
                    @method("PUT")

                    @csrf
                    <div class="card-body row">
                        <div class="col-md-12">

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                <label for="user_id">Username<span class="required-label">*</span></label>
                                    <select name="user_id" id="">

                                        <option value="">-- Select Username --</option>

                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ $user_role_permission->user_id == $user->id ? 'selected' : '' }}>
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

                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ $user_role_permission->role_id == $role->id ? 'selected' : '' }}>
                                                {{ $role->role_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-12">
                        <a href="{{route('user_role_permission.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                        
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                    <input type="hidden" value="{{request()->page}}" name="page">
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

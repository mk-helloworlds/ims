@extends('layouts.back-end')
@section('main-title')
    {{$user_role->role_name}}
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
                <form id="user_role-form" action="{{ route('user_role.update',$user_role->id) }}" method="post"
                    enctype="multipart/form-data">
                    @method("PUT")

                    @csrf
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="role_name">Role Name <span class="required-label">*</span></label>
                                    <input type="text" value="{{$user_role->role_name}}" class="form-control" id="role_name" name="role_name"
                                        placeholder="Update Role Name" required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <a href="{{route('user_role.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                    <input type="hidden" value="{{request()->page}}" name="page">
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

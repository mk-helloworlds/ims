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

@section('body')

<div class="row">
    <div class="col-md-12">
        <form id="user-form" action="{{route('login')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group form-show-validation row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <label for="name">Name<span class="required-label">*</span></label>
                    <input type="text" class="form-control" id="name" name="username" value=""
                        placeholder="Enter Username" required>
                </div>
            </div>

            <div class="form-group form-show-validation row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <label for="password">Password <span class="required-label">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" value=""
                        placeholder="Enter Password" required>
                </div>
            </div>

            <div class="col-md-12">
                <button type="submit" class="btn btn-sm btn-primary">Login</button>
            </div>
        </form>
    </div>
</div>
@endsection

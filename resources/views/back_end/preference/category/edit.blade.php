@php use App\Http\Controllers\MyUtility; @endphp
@extends('layouts.back-end')
@section('main-title')
EDIT CATEGORY
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
            <div>
                <ul>
                @foreach($errors->all() as $message)
                <li class="alert alert-primary" role="alert">{{$message}}</li>
                @endforeach
                </ul>
            </div>
        @endif

        <div class="col-md-12">

            <div class="card">

                <!-- CONFIGURE THE ROUTE for Update  -->
                <form id="category-form" action="{{ route('category.update', $category->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')

                    @csrf
                    <div class="card-body row">
                        <div class="col-md-12">

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="category_name">Category Name <span class="required-label">*</span></label>

                                    <input type="text" class="form-control" id="category_name" name="category_name" value="{{$category->category_name}}" required>
                                    
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <!-- CANCEL BUTTON -->
                        <a href="{{route('category.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>

                        <!-- SUBMIT BUTTON -->
                         <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
        </div>
    </div>
@endsection

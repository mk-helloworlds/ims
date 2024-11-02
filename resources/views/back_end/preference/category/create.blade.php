@extends('layouts.back-end')
@section('main-title')
CREATE COMPANY
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
?>
@section('body')
        <div class="col-md-12">

            <div class="card">

                <!-- CONFIGURE THE ROUTE for Store  -->
                <form id="company-form" action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body row">
                        @if($errors->all())
                            <div class="alert alert-danger bg-danger">
                                <ul>
                                    @foreach($errors->all() as $messsage)
                                        <li>{{$messsage}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="col-md-12">

                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <label for="company_name">Category Name <span class="required-label">*</span></label>
                                    <input type="text" class="form-control" id="company_name" name="category_name"
                                        placeholder="Enter Category's Name" required>
                                </div>
                            </div>
                        </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                <!-- CANCEL BUTTON -->
                                <a href="{{route('category.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>

                                <!-- SUBMIT BUTTON -->
                                <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                        </div>

                    </div>

                    
                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

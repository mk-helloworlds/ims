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
                <form id="company_category_relation-form" action="{{ route('company_category_relation.update', $company_category_relation->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')

                    @csrf
                    <div class="card-body row">
                        <div class="col-md-12">
                            <div class="form-group form-show-validation row">
                                <div class="col-lg-12 col-md-12 col-sm-12">

                                <!-- DEBUGGING -->
                                <!--
                                    <h1>DEBUGGING</h1>
                                        <div>
                                            <h3><b>Debugging Showing the $companies</b></h3>
                                            {{print($companies)}}
                                        </div>

                                        <div>
                                            <h3><b>Debugging Showing the $categories</b></h3>
                                            {{print($categories)}}
                                        </div>

                                        <div>
                                            <h3><b>Debugging Showing the $company_category_relation</b></h3>
                                            {{print($company_category_relation)}}
                                        </div>
                                -->

                                    <!-- LABEL FOR THE COMPANY -->
                                    <label for="company_id">company_id<span class="required-label">*</span></label>

                                    <!-- SELECT THE COMPANY -->
                                    <select name="company_id" id="">

                                        <option value="">-- SELECT COMPANY --</option>

                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}"

                                            <?php
                                            // NOTE
                                            // Adding the SELECTED attribute to the OPTION tag via the foreach looping with if statement

                                            // this techniques is using if else but also can use the TERINARY Operator
                                            // -> 
                                            // {{ $company_category_relation->company_id == $company->id ? 'selected' : '' }}
                                            ?>

                                            @if ($company_category_relation->company_id == $company->id)
                                                selected
                                            @endif
                                            >
                                                
                                                {{ $company->company_name }}
                                            </option>   
                                        @endforeach

                                    </select>

                                    <!-- LABEL FOR THE CATEGORY -->
                                    <label for="category_id">category_id<span class="required-label">*</span></label>

                                    <!-- SELECT THE CATEGORY -->
                                    <select name="category_id" id="">

                                        <option value="">-- Select Category --</option>

                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                            {{ $company_category_relation->category_id == $category->id ? 'selected' : ''}}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <!-- CANCEL BUTTON -->
                        <a href="{{route('company_category_relation.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>

                        <!-- SUBMIT BUTTON -->
                         <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
        </div>
    </div>
@endsection

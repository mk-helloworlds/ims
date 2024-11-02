@extends('layouts.back-end')
@section('main-title')
CREATE COMPANY CATEGROY RELATION
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

                <!-- CONFIGURE THE ROUTE for Store  -->
                <form id="company_category_relation-form" action="{{ route('company_category_relation.store') }}" method="post" enctype="multipart/form-data">
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
                                    
                                <!-- LABEL FOR THE COMPANY -->
                                <label for="company_id">company_id<span class="required-label">*</span></label>

                                <!-- SELECT THE COMPANY -->
                                <select name="company_id" id="">

                                    <option value="">-- Select Company --</option>

                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">
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
                                        <option value="{{ $category->id }}">
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach

                                </select>

                                <?php
                                // <!-- 
                                // <div>
                                //     {{print($companies)}}
                                // </div>

                                // <div>
                                //     {{dd($companies)}}
                                // </div> -->
                                ?>
                                
                                <!-- <select name="company_id" id="">
                                    <option value="">-- Select Company --</option>
                                    <option value="1">Tech1</option>
                                    <option value="2">Tech2</option>
                                    <option value="3">Tech3</option>
                                </select>  -->
                                
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
                <br>
            </div>
        </div>
    </div>
@endsection

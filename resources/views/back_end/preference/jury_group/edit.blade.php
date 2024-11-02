@php use App\Http\Controllers\MyUtility; @endphp
@extends('layouts.back-end')
@section('main-title')
EDIT : JURY GROUP 
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
            <div class="card-body">
                @if($errors->all())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Validation Error!</strong> Please make sure the following requirements are met:
                            <ul>
                                @foreach($errors->all() as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>

            <!-- CONFIGURE THE ROUTE for Update  -->
                <form id="jury_group-form" action="{{ route('jury_group.update',$juryGroup->id) }}" method="post" enctype="multipart/form-data">
                    @method('put')
                    
                    @csrf
                    <div class="card-body row">
                        <div class="col-md-12">

                            <div class="form-group">
									<label for="internship_id">INTERNSHIP</label>
                                    <select name="internship_id" id="internship_id"  class="form-control">
                                        <option value="">Please Internship</option>
                                        
                                        @foreach($internships as $i)
                                        <option value="{{$i->id}}" {{$i->id == $juryGroup->internship_id ? 'selected' : ''}}>
                                            {{$i->internship_title}}
                                        </option>
                                        @endforeach
                                    </select>
							</div>

                            <div class="form-group">
									<label for="user_jury1_id">JURY 1</label>
                                    <select name="user_jury1_id" id="user_jury1_id"  class="form-control">
                                        <option value="">Please Select JURY 1</option>
                                        
                                        @foreach($jurys as $j)
                                        <option value="{{$j->id}}" {{$j->id == $juryGroup->user_jury1_id ? 'selected' : ''}}>
                                            {{$j->name}}
                                        </option>
                                        @endforeach
                                    </select>
							</div>

                            <div class="form-group">
									<label for="user_jury2_id">JURY 2</label>
                                    <select name="user_jury2_id" id="user_jury2_id"  class="form-control">
                                        <option value="">Please Select JURY 2</option>
                                        
                                        @foreach($jurys as $j)
                                        <option value="{{$j->id}}"  {{$j->id == $juryGroup->user_jury2_id ? 'selected' : ''}}>
                                            {{$j->name}}
                                        </option>
                                        @endforeach
                                    </select>
							</div>

                            <div class="form-group">
									<label for="user_jury3_id">JURY 3</label>
                                    <select name="user_jury3_id" id="user_jury3_id"  class="form-control">
                                        <option value="">Please Select JURY 3</option>
                                        
                                        @foreach($jurys as $j)
                                        <option value="{{$j->id}}" {{$j->id == $juryGroup->user_jury3_id ? 'selected' : ''}}>
                                            {{$j->name}}
                                        </option>
                                        @endforeach
                                    </select>
							</div>

                            <div class="form-group">
									<label for="user_jury4_id">JURY 4</label>
                                    <select name="user_jury4_id" id="user_jury4_id"  class="form-control">
                                        <option value="">Please Select JURY 4</option>
                                        
                                        @foreach($jurys as $j)
                                        <option value="{{$j->id}}" {{$j->id == $juryGroup->user_jury4_id ? 'selected' : ''}}>
                                            {{$j->name}}
                                        </option>
                                        @endforeach
                                    </select>
							</div>
                            
                            <div class="form-group">
                                    <a href="{{route('jury_group.index')}}" class="btn btn-secondary" data-dismiss="modal">Cancel</a>
            
                                    <button type="submit" class="btn btn-primary">Save changes</button>
            
                                <input type="hidden" value="{{request()->page}}" name="page">
                            </div>
                        </div>
                    </div>

                </form>
                <br>
            </div>
        </div>
    </div>
@endsection

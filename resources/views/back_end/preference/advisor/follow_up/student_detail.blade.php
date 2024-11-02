@php use App\Http\Controllers\MyUtility; @endphp
@extends('layouts.back-end')
@section('main-title')
    ADVISOR : STUDENT DETAILS
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
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
                        <div>
                            <a href="{{ route('advisor.follow_up.index') }}" class="btn btn-sm btn-round bg-light">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i> View ALL STUDENTS</a>
                        </div>

                        <h1></h1>
                        <br>

                        <!-- Advisor and Student Info -->
                        <div class="table">
                            <div class="card">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th >ADVISOR</th>
                                            <th >STUDENT</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <td>
                                            <h4>USER ADVISOR ID: {{Auth::user()->id}}</h4>
                                            <h4>{{Auth::user()->name}}</h4>
                                            <h4>{{Auth::user()->email}}</h4>
                                            <h4>{{Auth::user()->role->id}}</h4>
                                        </td>

                                        <td>
                                            <h4>USER STUDENT ID: {{$studentRequest->student->id}}</h4>
                                            <h4>{{$studentRequest->student->name}}</h4>
                                            <h4>{{$studentRequest->student->email}}</h4>
                                            <h4>{{$studentRequest->student->role->role_name}}</h4>
                                        </td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        

                        <!-- Add New Follow-Up -->
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title"></h4>
                                <a href="{{route('advisor.follow_up.student_detail.create', $studentRequest->id)}}"
                                   class="btn btn-sm btn-primary btn-round ml-auto">
                                   <i class="fa fa-plus"></i> Add New FOLLOW-UP
                                </a>
                            </div>
                        </div>

                        <!-- Follow-Up Data -->
                        <table class="table table-hover mt-3">
                            <thead>
                                <tr>
                                    <th scope="col">Follow-Up ID</th>
                                    <th scope="col">Internship</th>
                                    <th scope="col">Follow-up Date</th>
                                    <th scope="col">Notes</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($followUps as $followUp)
                                    <tr>
                                        
                                        <td>{{ $followUp['id'] }}</td>
                                        <td>{{ $studentRequest->internship->internship_title }}</td>
                                        <td>{{ $followUp['follow_up_date'] }}</td>
                                        <td>{{ $followUp['notes'] }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-{{ $followUp['status'] == 'On Track' ? 'primary' : ($followUp['status'] == 'Behind Schedule' ? 'warning' : 'success') }}">
                                            {{ $followUp['status'] }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($followUp['id'] != 'N/A')
                                            <div class="d-inline-flex">
                                                <a href="{{ route('advisor.follow_up.student_detail.edit', $followUp['id']) }}" class="btn btn-sm btn-primary">Edit</a>

                                                <form action="{{ route('advisor.follow_up.student_detail.destroy', $followUp['id']) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this follow-up?');">Delete</button>
                                                </form>
                                            </div>
                                            @else
                                                <!-- If follow-up is not available, no edit/delete options -->
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="card-footer">
                            {{$followUps->appends(request()->input())->links()}}
                        </div>

                    </div>
                </div>
            </div>
            <input type="hidden" value="{{request()->page}}" name="page">
        </div>
    </div>
@endsection

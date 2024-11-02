@extends('layouts.back-end')
@section('main-title')
Manage Participant
@endsection
<?php
$maps = array(
        "/"=>"ផ្ទាំងគ្រប់គ្រង",
    "#one"=>"FORM",
);
?>
@section('body')
<div class="col-md-12 offset-sm">
    <div>
        @if($errors->all())
            <div class="alert alert-danger">
               <ul>
                @foreach($errors->all() as $message)
                    <li>{{$message}}</li>
                @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                    <a href="{{ route('internship.show', $internship->id) }}"
                    class="btn btn-sm btn-light btn-round ml-auto">
                    <i class="fa fa-arrow-left"></i>
                    Return to dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="col-md-12">
                <div class="row d-flex align-items-stretch">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h1>{{ $internship->internship_title }}</h1>
                                <p>{{ $internship->description }}</p>
                                <p><strong>School: </strong>{{ $internship->school }} | <strong>Generation:</strong> {{ $internship->generation }} | <strong>Period:</strong> {{ $internship->period }} months | <strong>Type:</strong> {{ $internship->type }}</p>
                            </div>        
                        </div>
                    </div>
                
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h1>Duration</h1>
                                <p><strong class="badge badge-primary">Start Date:</strong> {{ $internship->start_date }}</p>
                                <p><strong  class="badge badge-success">End Date:</strong> {{ $internship->end_date }}</p>    
                            </div>        
                        </div>
                    </div>
                </div>
            </div>

            
               

            <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h3>Add Participant</h3>
                                <form action="{{ route('internships_participants.store', $internship->id) }}" method="POST">
                                    @csrf
                            
                                    <br>

                                    <div class="">
                                        <label for="user_id">Select User:</label>
                                        <select name="user_id[]" id="user_id" class="form-control" multiple>
                                            <option disabled selected value>-- Select Users (Multiple selection allowed) --</option>
                                            @foreach(\App\Models\User::with('role')->get() as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} | {{ $user->role->role_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <br>
                            
                                    <button type="submit" class="form-group btn btn-primary">Add Participant</button>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2>Participants</h2>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>User Name</th>
                                            <th>User Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($participants as $index => $participant)
                                            <tr>
                                                <td>{{ $index + 1 }}</td> <!-- Display participant number -->
                                                <td>{{ $participant->name }}</td> <!-- Display participant name -->
                                                <td>{{ $participant->role->role_name }}</td> <!-- Display participant name -->
                                                <td>
                                                    <!-- Delete Form -->
                                                    <form action="{{ route('internships_participants.destroy', ['internship' => $internship->id, 'user' => $participant->id]) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this participant?')">Remove</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    </div>
                </div>

            </div>


            </div>
        </div>
    </div>
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

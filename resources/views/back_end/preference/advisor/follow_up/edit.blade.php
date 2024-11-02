@extends('layouts.back-end')

@section('main-title')
    ADVISOR: EDIT FOLLOW UP
@endsection

<?php
$maps = array(
    "/" => "Dashboard",
    "#one" => "Edit Follow-up",
);
?>

@section('body')

<div class="col-md-12">
    <div class="card">
        <div class="card-body">

            <!-- Error handling -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form for editing the follow-up -->
            <form action="{{ route('advisor.follow_up.student_detail.update', $followUp->id) }}" method="post">
                @csrf
                @method('PUT')

                <!-- Advisor Information -->
                <div class="form-group">
                    <label for="user_advisor_id">Advisor Name</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                </div>

                <!-- Student Information -->
                <div class="form-group">
                    <label for="user_student_id">Student Name</label>
                    <input type="text" class="form-control" value="{{ $followUp->studentRequest->student->name }}" disabled>
                </div>

                <!-- Internship Information -->
                <div class="form-group">
                    <label for="internship_id">Internship</label>
                    <input type="text" class="form-control" value="{{ $followUp->studentRequest->internship->internship_title }}" disabled>
                </div>

                <!-- Follow-up Date -->
                <div class="form-group">
                    <label for="follow_up_date">Follow-up Date</label>
                    <input type="date" class="form-control" id="follow_up_date" name="follow_up_date" value="{{ old('follow_up_date', $followUp->follow_up_date) }}" required>
                </div>

                <!-- Notes -->
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="4" placeholder="Add notes">{{ old('notes', $followUp->notes) }}</textarea>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="On Track" {{ $followUp->status == 'On Track' ? 'selected' : '' }}>On Track</option>
                        <option value="Behind Schedule" {{ $followUp->status == 'Behind Schedule' ? 'selected' : '' }}>Behind Schedule</option>
                        <option value="Completed" {{ $followUp->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <!-- Save Button -->
                <div class="form-group">
                    <a href="{{ route('advisor.follow_up.student_detail', $followUp->student_request_id) }}" class="btn btn-secondary">Cancel</a>
                    
                    <button type="submit" class="btn btn-primary">Update Follow-up</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

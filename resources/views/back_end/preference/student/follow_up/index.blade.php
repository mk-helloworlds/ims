@extends('layouts.back-end')
@section('main-title')
    STUDENT : FOLLOW-UP DETAILS
@endsection
<?php
$maps = array(
        "/" => "Dashboard",
    "#one" => "Follow-Up",
);
?>
@section('body')

<div class="col-md-12">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<div class="col-md-12">
    <div class="card">
        <table>
            <th>
                <div class="card-header">
                    <b>STUDENT INFORMATION</b>
                </div>
            </th>
            <th>
                <div class="card-header">
                    <b>ADVISOR INFORMATION</b>
                </div>
            </th>
            <tbody>
                <tr>
                    <td>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">User ID: {{ Auth::user()->id }}</li>
                            <li class="list-group-item">Student Name : {{ Auth::user()->name }}</li>
                            <li class="list-group-item">Role : {{ Auth::user()->role->role_name }}</li>
                        </ul>
                    </td>

                    <td>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Advisor Name : {{ $results->first()->studentRequest->advisor->name ?? 'N/A' }}</li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="table-responsive">
            <table class="table table w-100">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Follow Up ID</th>
                        <th scope="col">Internship ID</th>
                        <th scope="col">Internship Name</th>
                        <th scope="col">Advisor Name</th>
                        <th scope="col">Follow Up Date</th>
                        <th scope="col">Notes</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($results as $row)
                        <tr>
                            <td class="text-center">
                                {{ ($loop->iteration) + ($results->perPage() * ($results->currentPage() - 1)) }}
                            </td>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->studentRequest->internship->id ?? 'N/A' }}</td>
                            <td>{{ $row->studentRequest->internship->internship_title ?? 'N/A' }}</td>
                            <td>{{ $row->studentRequest->advisor->name ?? 'N/A' }}</td>
                            <td>{{ $row->follow_up_date ?? 'N/A' }}</td>
                            <td>{{ $row->notes ?? 'N/A' }}</td>
                            <td>{{ $row->status ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card-footer">
    {{ $results->appends(request()->input())->links() }}
</div>

<input type="hidden" value="{{ request()->page }}" name="page">
@endsection
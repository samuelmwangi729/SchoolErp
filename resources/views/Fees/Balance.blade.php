@extends('layouts.main')
@section('content')
<div class="table-responsive">
    <h2>Students With Balances</h2>
    <table class="table table-hover table-condensed table-bordered text-center">
        <thead>
            <tr>
                <th>Student Admission</th>
                <th>Student Name</th>
                <th>Class</th>
                <th>Stream</th>
                <th>School Fees</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($balances as $student)
            <tr>
                <td>{{ $student->AdmissionNumber }}</td>
                <td>{{ $student->StudentName }}</td>
                <td>Form {{ $student->class }}</td>
                <td>{{ $student->Stream }}</td>
                <td style="font-weight:bold;">{{ $student->SchoolFees }}</td>
                <td style="color:red;font-weight:bold">Ksh {{ $student->Balance }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop

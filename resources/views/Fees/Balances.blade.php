@extends('layouts.main')
@section('content')
<h3>View Student Balances</h3>
<div class="well well-xs">
    @if($errors->all())
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
       @foreach ($errors->all() as $error)
       <span>{{ $error }}</span>
       @endforeach
    </div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">&timesbar;</a>
        {{ Session::get('error') }}
    </div>
    @endif
<form method="post" action="{{route('balances')}}">
    @csrf
    <div class="row">
        <!--start col-->
        <div class="col-sm-3">
            <div class="form-group">
                <label for="Class" class="fa fa-university label-control">&nbsp;Class</label>
                <select class="form-control input-sm" name="Class">
                    <option value="1">Form 1</option>
                    <option value="2">Form 2</option>
                    <option value="3">Form 3</option>
                    <option value="4">Form 4</option>
                </select>
            </div>
        </div>
        <!--end col-->
          <!--start col-->
          <div class="col-sm-3">
            <div class="form-group">
                <label for="Stream" class="fa fa-list label-control">&nbsp;Stream</label>
                <select class="form-control input-sm" name="Stream">
                    @foreach ($streams  as $stream)
                        <option value="{{ $stream->Stream }}">{{ $stream->Stream }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!--end col-->
          <!--start col-->
          <div class="col-sm-3">
            <div class="form-group">
                <label for="Balance" class="fa fa-money-bill-wave-alt label-control">&nbsp;Balance Amount</label>
                <select class="form-control input-sm" name="Amount">
                    <option value="1">&lt;5000</option>
                    <option value="2">&lt;10,000</option>
                    <option value="3">&lt;20,000</option>
                    <option value="4">&gt;20,000</option>
                </select>
            </div>
        </div>
        <!--end col-->
          <!--start col-->
          <div class="col-sm-3">
            <div class="form-group">
               <button style="margin-top:20px" class="btn btn-success btn-sm" type="submit"><i class="fa fa-eye">&nbsp;View</i></button>
            </div>
        </div>
        <!--end col-->
    </div>
</form>
</div>
<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>Student Admission</th>
                <th>Student Name</th>
                <th>Class</th>
                <th>Stream</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
            <tr>
                <td>{{ $student->AdmissionNumber }}</td>
                <td>{{ $student->StudentName }}</td>
                <td>Form {{ $student->class }}</td>
                <td>{{ $student->Stream }}</td>
                <td style="color:red;font-weight:bold">Ksh {{ $student->Balance }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop

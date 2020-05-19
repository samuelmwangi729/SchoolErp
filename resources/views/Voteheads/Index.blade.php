@extends('layouts.main')
@section('content')
<div class="container-fluid">
<ul class="nav nav-tabs">
    <li class="active"><a href="#" id="Vlist"><i class="fa fa-list"></i>&nbsp;VoteHeads List</a></li>
    <li><a href="javascript::void;" id="Add"><i class="fa fa-plus-circle"></i>&nbsp;Add VoteHeads</a></li>
</ul>
<div class="table-responsive" id="List">
    <table class="table table-hover table-striped table-codensed">
        <tr>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>VoteHead</th>
                    <th>Class</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($voteheads->count()==0)
                <tr rowspan="1">
                    <td colspan="4">
                        <div class="alert alert-danger">
                            No VoteHeads Available. Kindly Check Later
                        </div>
                    </td>
                </tr>
                @else
                @foreach ($voteheads  as $votehead)
                    <tr>
                    <td>{{ $votehead->id }}</td>
                    <td>{{ $votehead->VoteHead }}</td>
                    <td>Form {{ $votehead->Class }}</td>
                    <td>@if($votehead->Status==0) <button class="btn btn-xs btn-success disabled">Approved</button> @else <button class="btn btn-danger btn-xs disabled">Rejected</button> @endif</td>
                    <td>
                       @if($votehead->Status==0) <a href="{{ route('votehead.suspend',[$votehead->id]) }}" class="fa fa-times-circle btn btn-xs btn-warning">Suspend</a> @else &nbsp;  <a href="{{ route('votehead.approve',[$votehead->id]) }}" class="fa fa-check-circle btn btn-xs btn-info">Approve</a> @endif &nbsp; <a href="{{ route('votehead.edit',[$votehead->id]) }}" class="fa fa-edit btn btn-xs btn-primary">Edit</a>&nbsp;<a href="{{ route('votehead.delete',[$votehead->id]) }}" class="fa fa-trash-alt btn btn-xs btn-danger">Delete</a>
                    </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </tr>
    </table>
</div>
<div class="container" id="Vform">
    <div class="form">
        <br> <br> <br>
        <form method="post" action="{{ route('votehead.store') }}">
            @csrf
            <div class="row">
                <!--Start col-->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="Class" class="label-control"><i class="fa fa-university"></i>&nbsp;Class</label>
                        <select name="Class" class="form-control">
                            @foreach ($classes as $class )
                                <option value="{{ $class->Class }}">Form {{ $class->Class }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--End COl-->
                 <!--Start col-->
                 <div class="col-sm-3">
                    <div class="form-group">
                        <label for="VoteHead" class="label-control"><i class="fa fa-tags"></i>&nbsp;VoteHead</label>
                        <input type="text" name="VoteHead"  class="form-control">
                    </div>
                </div>
                <!--End COl-->
                 <!--Start col-->
                 <div class="col-sm-3">
                    <div class="form-group">
                        <button class="btn btn-success btn-sm" type="submit" style="margin-top:23px"><i class="fa fa-plus-circle"></i>&nbsp;Add VoteHead</button>
                    </div>
                </div>
                <!--End COl-->
            </div>
        </form>
    </div>
</div>
</div>
<script src="{{asset('js/jquery-1.12.1.min.js')}}"></script>
<script>
jQuery(document).ready(function(){
    $("#fadd").hide();
});
$(".nav li").on("click",function(){
    $(".nav li").removeClass("active");
    $(this).addClass("active");
});
$("#Add").on("click",function(){
    $("#List").hide();
$("#Vform").show();
})
$("#Vlist").on("click",function(){
    $("#List").show();
$("#Vform").hide();
})
jQuery(document).ready(function(){
$("#List").show();
$("#Vform").hide();
});
</script>
@stop

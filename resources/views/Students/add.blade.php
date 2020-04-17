@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <h1>Add Students</h1>
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active" id="Single"><a href="javascript::void" id="Single"><i class="fa fa-user-plus"></i>&nbsp;Add Student</a> </li>
            <li><a href="javascript::void" id="bulk"><i class="fa fa-users"></i><sup><i class="fa fa-plus"></i></sup>&nbsp;Bulk Admission</a> </li>
        </ul>
    </div><br>
    <div class="form-row" id="StudentForm">
        @if($errors->all())
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert"><u>&times;</u></a>
            <ul>
                @foreach ($errors->all() as $error )
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(Session::has('success'))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            {{ Session::get('success') }}
        </div>
        @endif
        <form method="post" action="{{ route('student.store') }}" enctype="multipart/form-data">
            @csrf
            @include('Students.AddStudentForm')
            <button class="btn btn-success"><i class="fa fa-user-plus"></i>&nbsp;Add Student</button>
        </form>
    </div>
    <div class="form-row" id="StudentsForm">
        <form method="post" action="{{ route('students.addFile') }}">
            <fieldset>
                <legend>Add Students</legend>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="file" class="label-control">
                            Upload the Excel File
                        </label>
                        <input type="file" class="form-control" name="file">
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-success" style="margin-top:20px" ><i class="fa fa-upload"></i> Upload Details</button>
                    </div>
                </div>
               
            </fieldset>
        </form>
    </div>
</div>
<script src="{{asset('js/jquery-1.12.1.min.js')}}"></script>
<script>
$(".nav li").on("click",function(){
    $(".nav li").removeClass("active");
    $(this).addClass("active");
});
$(document).ready(function(){
    $("#StudentsForm").hide();
});
$("#bulk").on("click",function(){
    $("#StudentForm").hide();
    $("#StudentsForm").show();
});
$("#Single").on("click",function(){
    $("#StudentsForm").hide();
    $("#StudentForm").show();
});
</script>

@stop
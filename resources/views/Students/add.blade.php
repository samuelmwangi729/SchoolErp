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
        <form method="post" action="{{ route('student.store') }}" enctype="multipart/form-data">
            @csrf
            @include('Students.AddStudentForm')
            <button class="btn btn-success"><i class="fa fa-user-plus"></i>&nbsp;Add Student</button>
        </form>
    </div>
    <div class="form-row" id="StudentsForm">
        <form method="post" action="{{ route('students.addFile') }}" enctype="multipart/form-data">
            @csrf
            <fieldset>
                <legend>Add Students</legend>
                <div class="row">
                    <div class="col-sm-6">
                        <label for="file" class="label-control">
                            Upload the Excel File
                        </label>
                        <input type="file" class="form-control" name="StudentFile">
                    </div>
                    <div class="col-sm-6">
                        <button class="btn btn-success" style="margin-top:20px" ><i class="fa fa-upload"></i> Upload Details</button>
                    </div>
                </div>

            </fieldset>
        </form>
    </div>
</div>
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
$(".chosen-select").chosen({
    no_results_text: "Oops, no matching record found for ",
    allow_single_deselect: true,});
</script>

@stop

@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="col-sm-2">
        <ul class="nav nav-pills nav-stacked" style="background-color:#ededed !important">
            <li class="active"><a href="javascript::void" id="view" class="nav-item"><i class="fa fa-eye"></i>&nbsp;View Syllabi</a></li>
            <li><a href="javascript::void" id="add" class="nav-item"><i class="fa fa-plus-circle"></i>&nbsp;Add Syllabus</a></li>
        </ul>
    </div>
    <div class="col-sm-10" id="tview">
        @if($errors->all())
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <ul style="list-style:bullet">
            @foreach ($errors->all() as $error )
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
        @if(Session::has('success'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <ul style="list-style:none">
                        <li>{{ Session::get('success') }}</li>
                    </ul>
                </a>
            </div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <ul style="list-style:none">
                        <li>{{ Session::get('error') }}</li>
                    </ul>
                </a>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-condensed table-striped table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>By</th>
                        <th>Date Uploaded</th>
                        <th>FIle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                   @if($syllabi->count()==0)
                   <tr >
                       <td colspan="8">
                           <div class="alert alert-danger">
                                No Syllabus Available, Please Check Later
                           </div>
                       </td>
                   </tr>
                   @else
                   @foreach ($syllabi  as $syllabus )
                   <tr>
                       <td>{{ $syllabus->Title }}</td>
                       <td>{{ $syllabus->Description }}</td>
                       <td>{{ $syllabus->Subject }}</td>
                       <td>{{ $syllabus->Class }}</td>
                       <td>{{ $syllabus->UploadedBy }}</td>
                       <td>{{ ($syllabus->created_at)->toFormattedDateString() }}</td>
                       <td><a href="{{ asset($syllabus->File) }}">Download</a></td>
                       <td><a href="{{ route('syllabus.edit',[$syllabus->id]) }}"><i class="fa fa-edit btn btn-xs btn-info"></i></a>&nbsp;<a href="{{ route('syllabus.delete',[$syllabus->id]) }}"><i class="fa fa-trash-alt btn btn-xs btn-danger"></i></a></td>
                   </tr>
               @endforeach
                   @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-10" id="fadd">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h5 class="text-center">Add Academic Syllabus</h5>
            </div>
            <div class="panel-body">
                <div class="form">
                    <form method="POST" action="{{ route('syllabus.post') }}" enctype="multipart/form-data">
                        @csrf
                        @include('Syllabi.form')
                        <div class="col-sm-6 col-sm-offset-5">
                            <button class="btn btn-success" type="submit">
                                Add Syllabus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel-footer">
                <span>&copy;{{ config('app.name') }} @<?php echo date('Y');?></span>
            </div>
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
$("#add").on("click",function(){
    $("#tview").hide();
    $("#fadd").show();
})
$("#view").on("click",function(){
    $("#tview").show();
    $("#fadd").hide();
})
</script>
@stop
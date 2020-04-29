@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <h1>Manage School Staff</h1>
    @if(Session::has('success'))
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <span>{{ Session::get('success') }}</span><br>
    </div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <span>{{ Session::get('error') }}</span><br>
    </div>
    @endif
    @if($errors->all())
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
       <ul>
           @foreach($errors->all() as $error)
           <li>{{$error}}</li>
           @endforeach
       </ul>
    </div>
    @endif
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a href="javascript::void" id="List"><i class="fa fa-list"></i>&nbsp;All Staff</a></li>
            <li><a href="javascript::void" id="Add"><i class="fa fa-typo3"></i>&nbsp;Add Types</a></li>
            <li><a href="javascript::void" id="AddStaff"><i class="fa fa-user-plus"></i>&nbsp;Add Staff</a></li>
        </ul>
    </div><br>
    <div class="col-sm-8 col-sm-offset-2 list">
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-bordered  table-active">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone </th>
                            <th>Employee Number </th>
                            <th>Email</th>
                            <th>Level</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffs as $staff)
                           <tr>
                               <td>{{ $staff->name }}</td>
                               <td>{{ $staff->phone }}</td>
                               <td>{{ $staff->tsc }}</td>
                               <td>{{ $staff->email }}</td>
                               <td>{{ $staff->level }}</td>
                           </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="errorModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <a href="#" class="close" data-toggle="modal" id="modalClose">&times;</a>
              <h2 class="modal-title text-center"><i class="fa fa-exclamation-triangle" style="color:red"></i> &nbsp;Error</h2>
            </div>
            <div class="modal-body">
              <span style="color:red;text-align:center">Value Cant be Empty or Lass than 4 Characters</span>
            </div>
            <div class="modal-footer">
              &copy;{{ config('app.name') }} @<?php echo date('Y');?>
            </div>
          </div>
        </div>
    </div>
    <div id="form">
        <div class="container-fluid col-sm-6 col-sm-offset-2">
            <div class="table-responsive">
                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($types as$type )
                            <tr>
                                <td>{{ $type->Type }}</td>
                                <td><a href="{{ route('type.delete',[$type->id]) }}"><i class="fa fa-trash-alt btn btn-danger btn-xs"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <form method="POST" id="form" action="{{route('type.save')}}">
                <div class="form-group">
                    @csrf
                    <label class="label-control" for="Staff Type">Staff Type</label>
                    <input type="text" name="Type" class="form-control" minlength="4"  placeholder="Eg. Electician">
                </div>
                <button class="btn btn-success" id="submit"><i class="fa fa-plus-circle"></i>Save Type</button>
            </form>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="AddStafff">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <a href="#" class="close" data-toggle="modal" id="addStaff">&times;</a>
              <h2 class="modal-title text-center"><i class="fa fa-exclamation-triangle" style="color:red"></i> &nbsp;Add Staff</h2>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('staff.register') }}" id="contactForm" method="post" class="contact-form-aqua">
                    @csrf                
              @include('Staff.form')
              <div class="col-sm-6 col-sm-offset-5">
                  <button class="btn btn-success btn-xs" type="submit"><i class="fa fa-user-plus"></i>&nbsp;Add Staff</button>
              </div>
            </div>
            <div class="modal-footer">
              &copy;{{ config('app.name') }} @<?php echo date('Y');?>
            </div>
          </div>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery-1.12.1.min.js')}}"></script>
<script>
    $("#AddStaff").on("click",function(){
        $("#AddStafff").show('back-to-top');
    })
    $("#addStaff").on("click",function(){
        $("#AddStafff").hide();
    })
$(".nav li").on("click",function(){
    $(".nav li").removeClass("active");
    $(this).addClass("active");
});
$(document).ready(function(){
    $("#form").hide();
});
$("#Add").on("click",function(){
    $(".list").hide();
    $("#form").show('fade');
});
$("#List").on("click",function(){
    $(".list").show('fadeInRightBig');
    $("#form").hide();
});
$("#modalClose").on("click",function(){
    $("#errorModal").hide('fadeOutDown');
})
$(".chosen-select").chosen({
    no_results_text: "Oops, no matching record found for ",
    allow_single_deselect: true,});
</script>
@endsection
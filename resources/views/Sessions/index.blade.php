@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <h1>Manage Sessions</h1>
    @if(Session::has('success'))
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <span>{{ Session::get('success') }}</span><br>
    </div>
    @endif
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a href="javascript::void" id="List"><i class="fa fa-list"></i>&nbsp;Session List</a></li>
            <li><a href="javascript::void" id="Add"><i class="fa fa-plus-circle"></i>&nbsp;Add Session</a></li>
        </ul>
    </div><br>
    <div class="col-sm-8 col-sm-offset-2 list">
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-bordered  table-active">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Session</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sessions as $session )
                        <tr>
                            <td>{{ $session->id }}</td>
                            <td>{{ $session->Session }}</td>
                            <td><a href="#" class="btn btn-primary btn-xs fa fa-edit">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-xs fa fa-trash-alt">Delete</a>&nbsp;<a href="#" class="btn btn-warning btn-xs fa fa-times-circle">Suspend</a></td>
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
            <form method="POST" id="form" action="{{route('session.save')}}">
                <div class="form-group">
                    @csrf
                    <label class="label-control" for="Session Year">Session Year</label>
                    <input type="number" id="session" name="Session" class="form-control" minlength="4" placeholder="<?php echo date('Y');?>">
                </div>
                <button class="btn btn-success" id="submit"><i class="fa fa-save"></i>Save Session</button>
            </form>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery-1.12.1.min.js')}}"></script>
<script>
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
$("#submit").on("click",function(){
    var val=$("#session").val();
    if(val==='' || val.length < 4){
       $("#errorModal").show();
       return false;
    }
});
$("#modalClose").on("click",function(){
    $("#errorModal").hide('fadeOutDown');
})
</script>
@endsection

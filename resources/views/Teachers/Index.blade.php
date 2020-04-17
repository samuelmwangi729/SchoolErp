@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <a href="javascript::void" id="AddTeacher"  class="btn btn-primary"><i class="fa fa-user-plus"></i>&nbsp;Add Teacher</a> <br><br>
<div class="table-responsive">
    @if($errors->all())
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert"><u>&times;</u></a>
        <ul style="list-style:none">
           @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
           @endforeach
        </ul>
    </div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert"><u>&times;</u></a>
        <span>{{ Session::get('error')}}</span>
    </div>
    @endif
    @if(Session::has('success'))
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert"><u>&times;</u></a>
        <span>{{Session::get('success')}}</span>
    </div>
    @endif
    <table class="table table-striped  table-bordered table-hover table-condensed">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>TSC NUMBER</th>
                <th>Subject 1</th>
                <th>Subject 2</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->id }}</td>
                    <td>{{ $teacher->name }}</td>
                    <td>{{ $teacher->phone }}</td>
                    <td>{{ $teacher->tsc }}</td>
                    <td>{{ $teacher->subject1 }}</td>
                    <td>{{ $teacher->subject2 }}</td>
                    <td><a href="{{ route('teacher.edit',['id'=>$teacher->id]) }}" class="btn btn-primary btn-xs fa fa-edit"></a>&nbsp;
                        {{-- <a href="{{ route('teacher.show',['id'=>$teacher->id]) }}" class="btn btn-success btn-xs fa fa-eye"></a>&nbsp; --}}
                        <a href="{{ route('teacher.delete',['id'=>$teacher->id]) }}" class="btn btn-danger btn-xs fa fa-trash-alt"></a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal" tabindex="-1" id="Teacher">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <a href="#" class="close" data-toggle="modal" id="modalClose">&times;</a>
          <h2 class="modal-title text-center"><i class="fa fa-user-plus" style="color:red"></i> &nbsp;Add A new Teacher</h2>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('teacher.register') }}" id="contactForm" method="post" class="contact-form-aqua">
                @csrf
            
          @include('Teachers.form')
                <div class="form-group row mb-0">
                    <div class="col-md-12 offset-md-0">
                        <button type="submit" class="btn btn-success btn-block btn-sm">
                            {{ __('Add Teacher') }}
                        </button>
                    </div>
                </div>
            </form>
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
    $("#AddTeacher").on("click",function(){
        $("#Teacher").show("fadeInDown");
    })
    $("#modalClose").on("click",function(){
        $("#Teacher").hide("fadeOutDown");
    })
</script>
@endsection
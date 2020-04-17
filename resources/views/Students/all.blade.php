@extends('layouts.main')
@section('content')
<div class="container-fluid">
    @if(Session::has('success'))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            {{ Session::get('success') }}
        </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            {{ Session::get('error') }}
        </div>
        @endif
        @if(Session::has("data"))
        @foreach (Session::get("data") as $student )
        <input type="hidden" id="hidden" value="true">     
        <div class="modal" tabindex="-1" id="studentModal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header bg-light">
                  <h5 class="modal-title text-center"><i class="fa fa-user-graduate"></i> &nbsp;{{ $student->StudentName }}</h5>
                </div>
                <div class="modal-body">
                 <div class="row">
                     <div class="col-sm-3" style="width:100px;height:100px;border:1px solid black" >
                         <img src="{{ asset($student->Passport) }}" class="img-responsive" width="100px" height="100px" id="image">
                     </div>
                     <div class="col-sm-4">
                        <label class="label-control">
                           <i class="fa fa-id-badge">&nbsp;Admission Number</i>
                        </label>
                        <input type="text" class="form-control input-sm" readonly value="{{ $student->AdmissionNumber }} ">
                    </div>
                     <div class="col-sm-4">
                         <label class="label-control">
                            <i class="fa fa-baby-carriage">&nbsp;Parent</i>
                         </label>
                         <input type="text" class="form-control input-sm" readonly value="{{ $student->parent }} ">
                     </div>
                     <div class="col-sm-4">
                        <label for="Nemis" class="label-control">
                            <i class="fa fa-calendar">&nbsp;Nemis Number</i>
                        </label>
                        <input type="text" class="form-control input-sm" readonly value="{{ $student->Nemis }}">
                    </div>
                    <div class="col-sm-4">
                        <label for="Class" class="label-control">
                            <i class="fa fa-university">&nbsp;Class</i>
                        </label>
                        <input type="text" class="form-control input-sm" readonly value="{{ $student->class }} {{ $student->Stream }}">
                    </div>
                    <div class="col-sm-2">
                        <label for="Status" class="label-control">
                            <i class="fa fa-user-lock">&nbsp;Status</i>
                        </label>
                        <input type="text" class="form-control input-sm" readonly value="@if($student->status==0) Active @endif @if($student->status==1) Suspended @endif @if($student->status==2) Transferred @endif @if($student->status==3) Expelled @endif">
                    </div>
                    <div class="col-sm-4">
                        <label for="BirthDate" class="label-control">
                            <i class="fa fa-baby">&nbsp;birthDate</i>
                        </label>
                        <input type="text" class="form-control input-sm"   readonly value="{{ $student->birthDate }}">
                    </div>
                    <div class="col-sm-4">
                        <label for="Date Registered" class="label-control">
                            <i class="fa fa-user-plus">&nbsp;Date Registered</i>
                        </label>
                        <input type="text" class="form-control input-sm"  readonly value="{{ ($student->created_at)->toFormattedDateString() }}">
                    </div>
                 </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="pull-left" data-toggle="modal" id="modalClose"><button class="btn btn-danger" style="border:2px solid red;background-color:red">Close</button></a> &copy;{{ config('app.name') }} @<?php echo date('Y');?>
                </div>
              </div>
            </div>
          </div>   
        @endforeach
        @endif
        @if(Session::has("datae"))
        @foreach (Session::get("datae") as $student )
        <input type="hidden" id="hiddene" value="true">     
        <div class="modal" tabindex="-1" id="studentModale">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header" style="background-color:#f9f9f9">
                  <h5 class="modal-title text-center"><i class="fa fa-user-graduate"></i> &nbsp;{{ $student->StudentName }}</h5>
                </div>
                <div class="modal-body">
                 <div class="row">
                     <div class="col-sm-3" style="width:100px;height:100px;border:1px solid black" >
                         <img src="{{ asset($student->Passport) }}" class="img-responsive" width="100px" height="100px" id="image">
                     </div>
                     <form method="POST" id="stdUpdate" action="{{ route('student.update',[$student->id]) }}" enctype="multipart/form-data">
                         @csrf
                         @include('Students.AddStudentForm')
                        <div class="col-sm-4 col-sm-offset-5">
                            <button type="submit"  class="btn btn-success" id="update"><i class="fa fa-recycle"></i>&nbsp;Update Student</button>
                        </div>
                     </form>
                 </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="pull-left" data-toggle="modal" id="modalClosee"><button class="btn btn-danger" style="border:2px solid red;background-color:red">Close</button></a> &copy;{{ config('app.name') }} @<?php echo date('Y');?>
                </div>
              </div>
            </div>
          </div>   
        @endforeach
        @endif
   @if(is_null($students) || count($students)==0)
   <div class="alert alert-danger">
       No Students Available. Please Check later
   </div>
   @else
   <div class="table-responsive">
    <table class="table table-bordered table-condensed table-sm table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Passport</th>
                <th>Admission Number</th>
                <th>Student Name</th>
                <th>Parent Name</th>
                <th>Class</th>
                <th>Stream</th>
                <th>KCPE MARKS</th>
                <th>NEMIS</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student )
                <tr>
                    <td>{{ $student->id }}</td>
                    <td><img src="{{ asset($student->Passport) }}" alt="{{ $student->StudentName }}" width="40px" height="40px" style="border: none;border-radius:50px"></td>
                    <td>{{ $student->AdmissionNumber}}</td>
                    <td>{{ $student->StudentName}}</td>
                    <td>{{ $student->parent }}</td>
                    <td>Form {{ $student->class }}</td>
                    <td>{{ $student->Stream}}</td>
                    <td>{{ $student->Kcpe }}</td>
                    <td>{{ $student->Nemis }}</td>
                    @if($student->Status ==0)
                    <td><button class="btn btn-success btn-xs">Active</button></td>
                    @endif
                    @if($student->Status ==1)
                    <td><button class="btn btn-danger btn-xs">Suspended</button></td>
                    @endif
                    @if($student->Status ==2)
                    <td><button class="btn btn-warning btn-xs">Transferred</button></td>
                    @endif
                    @if($student->Status ==3)
                    <td><button class="btn btn-danger btn-xs">Expelled</button></td>
                    @endif
                    <td><a href="{{ route('student.edit',[$student->id]) }}" value="{{ $student->id }}"  id="edit" class="btn btn-primary btn-xs fa fa-edit"></a>
                     <a  href="{{ route('student.view',[$student->id]) }}"   class="btn btn-success btn-xs fa fa-eye"></a>
                     </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
   @endif

</div>
<script src="{{asset('js/jquery-1.12.1.min.js')}}"></script>
<script>
$("#edit").on("click",function(){
    var value=$("#edit").attr("value");
    console.log(value);
});
var value=$("#hidden").attr("value");
if(value){
    $("#studentModal").show();
}
var value=$("#hiddene").attr("value");
if(value){
    $("#studentModale").show();
}
$("#modalClose").click(function(){
    $("#studentModal").hide()
})
$("#modalClosee").click(function(){
    $("#studentModale").hide()
})
</script>
@stop
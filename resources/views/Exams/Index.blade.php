@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <h1>View &amp; Manage exams</h1>
    <ul class="nav nav-tabs">
        <li class="active" id="viewExam"><a href="#"><i class="fa fa-list"></i>&nbsp;View Exams</a></li>
        <li id="addExam"><a href="#"><i class="fa fa-plus-circle"></i> Add Exams</a></li>
    </ul>
    <div class="container-fluid" id="Exams">
        <div class="table-responsive">
            <h1 class="text-center">View Exams History</h1>
            <table class="table table-bordered table-condensed table-hover table-striped">
                <thead>
                    <th>Exam</th>
                    <th>Term</th>
                    <th>Done By</th>
                    <th>Year</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($exams as $exam)
                    <tr>
                        <td>{{ $exam->Exam }}</td>
                        <td> @if($exam->Term==1)
                            I
                            @endif
                            @if($exam->Term==2)
                            II
                            @endif
                            @if($exam->Term==3)
                            III
                            @endif</td>
                        <td>@if($exam->Class==5)All Classes @else Form {{ $exam->Class }} @endif</td>
                        <td>{{ $exam->Year }}</td>
                        <td><a href="#" class="btn btn-primary btn-sm fa fa-edit"></a>&nbsp;<a href="#" class="btn btn-danger btn-sm fa fa-trash-alt"></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="container-fluid" id="AddExams">
        <h1 class="text-center">Add An Exam</h1>
       <form class="form" id="form" method="POST" action="{{ route('exam.save') }}">
        @csrf
           <div class="row">
               <!--Start Col-->
                <div class="col-sm-3">
                    <div class="form-group">
                    <label class="label-control" for="Exam"><i class="fa fa-tags"></i>Exam Name</label>
                    <input type="text" class="form-control input-sm is-invalid" name="Exam" placeholder="E.g End Term ">
                    </div>
                </div>
               <!--End Col-->
                <!--Start Col-->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="label-control" for="Term">Select Term</label>
                        <select  name="Term" class="form-control input-sm">
                            <option value="1">I</option>
                            <option value="2">II</option>
                            <option value="3">III</option>
                        </select>
                    </div>
                </div>
                <!--End Col-->
                <!--Start Col-->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="label-control" for="Term">Select Class</label>
                        <select  name="Class" class="form-control input-sm">
                            @foreach ($classes as $class)
                            <option value="{{ $class->Class }}">Form {{ $class->Class }}</option>
                            <option value="5">All Classes</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--End Col-->
                <!--Start Col-->
                <button class="btn btn-success" style="margin-top:20px" id="submit"><i class="fa fa-plus-circle"></i>Add Exam</button>
           <!--End Col-->
           </div>
        </form>
    </div>
</div>
<script>
    $("#addExam").on("click",()=>{
        $("#AddExams").show('fade-top');
        $("#Exams").hide();
    })
    $("#viewExam").on("click",()=>{
        $("#AddExams").hide();
        $("#Exams").show();
    })
    $(document).ready(
        ()=>{
            let exam=document.getElementById("Exams");
            let addexam=document.getElementById("AddExams");
            $(exam).show('fade-top')
            $(addexam).hide()
        }
    );
    $(".nav li").on("click",function(){
        $(".nav li").removeClass('active');
        $(this).addClass("active");
    })

</script>
@stop

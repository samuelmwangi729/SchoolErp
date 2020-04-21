@extends('layouts.main')
@section('content')
<div class="container-fluid">
   <div class="container-fluid">
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
       <ul class="nav nav-tabs">
           <li class="active">
               <a href="#" id="Fees"><i class="fa fa-list-alt"></i>&nbsp; Fees</a>
           </li>
           <li>
            <a href="javascript::void" id="Set"><i class="fa fa-cogs"></i>&nbsp; Set Fees</a>
        </li>
        <li>
            <a href="javascript::void" id="Current" style="color:red"><i class="fa fa-dice-three" style="color:blue !important"></i>&nbsp; Set Current Term</a>
        </li>
        <li>
            <a href="javascript::void" id="Next" style="color:red"><i class="fa fa-dice-three" style="color:blue !important"></i>&nbsp; Set Next Term</a>
        </li>
       </ul>
   </div><br>
   <div class="container  pull-left" style="font-family:'Times New Roman', Times, serif">
       <form class="form-horizontal" method="post" action="{{ route('filter.post') }}">
        @csrf
           <div class="form-group col-sm-3">
               <label for="Filter" class="fa fa-tags label-control">&nbsp;Filter By:</label>
               <select name="Filter" class="form-control input-sm">
                   <option value="1">Current Term</option>
                   <option value="2">Next Term</option>
                   <option value="3">Whole Year</option>
               </select>
           </div>
           <div class="col-sm-3">

            <button class="btn btn-primary btn-xs" style="margin-top:23px"><i class="fa fa-eye"></i>View Fees</button>
           </div>
       </form>
   </div>
   <div class="row"><br>
@if(Session::has('Data'))
@foreach ($classes as $class)
<!--Start Col-->
<div class="col-sm-6">
    <div class="panel" style="margin-top:20px !important">
        <div class="panel-heading bg-black text-center">
            Form {{ $class->Class }} Fees
            <div class="pull-right">
              <button class="btn btn-success btn-xs"><a href="{{ route('fees.view',[$class->Class]) }}" style="color:white;font-weight:bold;">View Fees Structure</a></button>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-codensed table-bordered">
                    <thead>
                        <tr>
                            <th>VoteHead</th>
                            <th>Term</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                       @if( count(App\Fee::where([
                           'Class'=>$class->Class,
                           'Term'=>Session::get('Data')
                       ])->get())>0)
                        @foreach (App\Fee::where([
                              'Class'=>$class->Class,
                              'Term'=>Session::get('Data')
                        ])->get() as $fee )
                        <tr>
                            <td>{{ $fee->VoteHead }}</td>
                            <td>
                                @if($fee->Term==1)
                                I
                                @endif
                                @if($fee->Term==2)
                                II
                                @endif
                                @if($fee->Term==3)
                                III
                                @endif
                            </td>
                            <td>{{ $fee->Amount }}</td>
                            <td><a href="{{ route('fees.edit',[$fee->id]) }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;<a href="{{ route('fees.delete',[$fee->id]) }}" class="btn btn-xs btn-danger"><i class="fa fa-trash-alt"></i></a></td>
                        </tr>
                        @endforeach
                       @else
                       <tr>
                        <td colspan="4">
                            <div class="alert alert-danger">
                                No Fees Set for Form {{ $class->Class }}, Please Check Later
                            </div>
                        </td>
                    </tr>
                       @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-footer" style="background-color:#fec107">
           <b> Total Amount</b>
           <span class="pull-right" style="font-weight:bolder;color:white">
            @if(Session::has('Data'))
            @if( count(App\Fee::where([
                 'Class'=>$class->Class,
                'Term'=>Session::get('Data')
            ])->get())>0)
           <?php  $Amount=[];?>
            @foreach (App\Fee::where([
                 'Class'=>$class->Class,
                'Term'=>Session::get('Data')
            ])->get() as $fee )
           <?php
            array_push($Amount,$fee->Amount);
           ?>
            @endforeach
            <?php
            $sum=0;
            for($i=0;$i<count($Amount);$i++){
                $sum=$sum+$Amount[$i];
            }
            ?>
            {{ "Ksh: ". $sum  }}
            @else
            Ksh: 0.00
            @endif
            @else
            @if( count(App\Fee::where('Class','=',$class->Class)->get())>0)
           <?php  $Amount=[];?>
            @foreach (App\Fee::where('Class','=',$class->Class)->get() as $fee )
           <?php
            array_push($Amount,$fee->Amount);
           ?>
            @endforeach
            <?php
            $sum=0;
            for($i=0;$i<count($Amount);$i++){
                $sum=$sum+$Amount[$i];
            }
            ?>
            {{ "Ksh: ". $sum  }}
            @else
            Ksh: 0.00
            @endif
            @endif
           </span>
        </div>
    </div>
</div>
<!--end Col-->
@endforeach
@else
@foreach ($classes as $class)
<!--Start Col-->
<div class="col-sm-6">
    <div class="panel" style="margin-top:20px !important">
        <div class="panel-heading bg-black text-center">
            Form {{ $class->Class }} Fees
            <div class="pull-right">
              <button class="btn btn-success btn-xs"><a href="{{ route('fees.view',[$class->Class]) }}" style="color:white;font-weight:bold;">View Fees Structure</a></button>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-codensed table-bordered">
                    <thead>
                        <tr>
                            <th>VoteHead</th>
                            <th>Term</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                       @if( count(App\Fee::where('Class',$class->Class)->get())>0)
                        @foreach (App\Fee::where('Class',$class->Class)->get() as $fee )
                        <tr>
                            <td>{{ $fee->VoteHead }}</td>
                            <td>
                                @if($fee->Term==1)
                                I
                                @endif
                                @if($fee->Term==2)
                                II
                                @endif
                                @if($fee->Term==3)
                                III
                                @endif
                            </td>
                            <td>{{ $fee->Amount }}</td>
                            <td><a href="{{ route('fees.edit',[$fee->id]) }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;<a href="{{ route('fees.delete',[$fee->id]) }}" class="btn btn-xs btn-danger"><i class="fa fa-trash-alt"></i></a></td>
                        </tr>
                        @endforeach
                       @else
                       <tr>
                        <td colspan="4">
                            <div class="alert alert-danger">
                                No Fees Set for Form {{ $class->Class }}, Please Check Later
                            </div>
                        </td>
                    </tr>
                       @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-footer" style="background-color:#fec107">
           <b> Total Amount</b>
           <span class="pull-right" style="font-weight:bolder;color:white">
            @if( count(App\Fee::where('Class','=',$class->Class)->get())>0)
           <?php  $Amount=[];?>
            @foreach (App\Fee::where('Class','=',$class->Class)->get() as $fee )
           <?php
            array_push($Amount,$fee->Amount);
           ?>
            @endforeach
            <?php
            $sum=0;
            for($i=0;$i<count($Amount);$i++){
                $sum=$sum+$Amount[$i];
            }
            ?>
            {{ "Ksh: ". $sum  }}
            @else
            Ksh: 0.00
            @endif
           </span>
        </div>
    </div>
</div>
<!--end Col-->
@endforeach
@endif
    <!--set the new classes fees -->
    <!--start modal-->
    <div class="modal" tabindex="-1" id="FeesModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <a href="#" class="close" data-toggle="modal" id="modalClose">&times;</a>
              <h2 class="modal-title text-center"><i class="fa fa-hand-holding-usd" style="color:red"></i> &nbsp;Set Classes Fees</h2>
            </div>
            <div class="modal-body">
              <div class="form">
                  <!--start form-->
                  <form method="post" action="{{ route('fees.post') }}">
                    @csrf
                     <div class="row">
                          <!--start col-->
                      <div class="col-sm-3">
                        <!--start form group-->
                        <div class="form-group">
                          <label for="class" class="label-control"><i class="fa fa-university"></i>&nbsp; Class</label>
                          <select  name="Class" class="form-control input-sm">
                              @foreach ($classes as $class)
                              <option value="{{ $class->Class }}">Form {{ $class->Class }}</option>
                              @endforeach
                          </select>
                        </div>
                        <!--end form group-->
                    </div>
                    <!--end col -->
                     <!--start col-->
                     <div class="col-sm-3">
                        <!--start form group-->
                        <div class="form-group">
                          <label for="VoteHead" class="label-control"><i class="fa fa-tags"></i>&nbsp; Votehead</label>
                          <select  name="VoteHead" class="form-control input-sm">
                              @foreach ($voteheads as $votehead)
                              <option value="{{ $votehead->VoteHead }}">{{ $votehead->VoteHead }}</option>
                              @endforeach
                          </select>
                        </div>
                        <!--end form group-->
                    </div>
                    <!--end col -->
                    <div class="col-sm-3">
                        <!--start form group-->
                        <div class="form-group">
                          <label for="Term" class="label-control"><i class="fa fa-check-plus"></i>&nbsp; Term</label>
                          <select  name="Term" class="form-control input-sm">
                              <option value="1">I</option>
                              <option value="2">II</option>
                              <option value="3">III</option>
                          </select>
                        </div>
                        <!--end form group-->
                    </div>
                    <!--end col -->
                    <!--start col-->
                    <div class="col-sm-3">
                        <!--start form group-->
                        <div class="form-group">
                          <label for="Amount" class="label-control"><i class="fa fa-money"></i>&nbsp;Amount</label>
                          <input type="number" name="Amount"  class="form-control">
                        </div>
                        <!--end form group-->
                    </div>
                    <!--end col -->
                     </div>
                     <div class="col">
                         <button class="btn btn-success btn-block btn-sm" type="submit"><i class="fa fa-plus-circle"></i>&nbsp;Add Fees</button>
                     </div>
                  </form>
                  <!--end form-->
              </div>
            </div>
            <div class="modal-footer">
              &copy;{{ config('app.name') }} @<?php echo date('Y');?>
            </div>
          </div>
        </div>
    </div>
    <!--end modal-->
       <!--start modal-->
       <div class="modal" tabindex="-1" id="CurrentModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <a href="#" class="close" data-toggle="modal" id="modalClose" onclick="$('.modal').hide()">&times;</a>
              <h2 class="modal-title text-center"><i class="fa fa-hand-holding-usd" style="color:red"></i> &nbsp;Set Current Term</h2>
            </div>
            <div class="modal-body">
              <div class="form">
                  <!--start form-->
                  <form method="post" action="{{ route('current.post') }}">
                    @csrf
                    <div class="col-sm-12">
                        <!--start form group-->
                        <div class="form-group">
                          <label for="Term" class="label-control"><i class="fa fa-tags"></i>&nbsp;Current  Term</label>
                          <select  name="CurrentTerm" class="form-control input-sm">
                              <option value="1">I</option>
                              <option value="2">II</option>
                              <option value="3">III</option>
                          </select>
                        </div>
                        <!--end form group-->
                     </div>
                     <div class="col">
                         <button class="btn btn-success btn-block btn-sm" type="submit"><i class="fa fa-plus-circle"></i>&nbsp;Update Current Term</button>
                     </div>
                  </form>
                  <!--end form-->
              </div>
            </div>
            <div class="modal-footer">
              &copy;{{ config('app.name') }} @<?php echo date('Y');?>
            </div>
          </div>
        </div>
    </div>
    <!--end modal-->
      <!--start modal-->
      <div class="modal" tabindex="-1" id="NextModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <a href="#" class="close" data-toggle="modal" id="modalClose" onclick="$('.modal').hide()">&times;</a>
              <h2 class="modal-title text-center"><i class="fa fa-hand-holding-usd" style="color:red"></i> &nbsp;Set Next Term</h2>
            </div>
            <div class="modal-body">
              <div class="form">
                  <!--start form-->
                  <form method="post" action="{{ route('next.post') }}">
                    @csrf
                    <div class="col-sm-12">
                        <!--start form group-->
                        <div class="form-group">
                          <label for="Term" class="label-control"><i class="fa fa-tags"></i>&nbsp;Next  Term</label>
                          <select  name="NextTerm" class="form-control input-sm">
                              <option value="1">I</option>
                              <option value="2">II</option>
                              <option value="3">III</option>
                          </select>
                        </div>
                        <!--end form group-->
                     </div>
                     <div class="col">
                         <button class="btn btn-success btn-block btn-sm" type="submit"><i class="fa fa-plus-circle"></i>&nbsp;Set Next Term</button>
                     </div>
                  </form>
                  <!--end form-->
              </div>
            </div>
            <div class="modal-footer">
              &copy;{{ config('app.name') }} @<?php echo date('Y');?>
            </div>
          </div>
        </div>
    </div>
    <!--end modal-->
</div>
<script src="{{asset('js/jquery-1.12.1.min.js')}}"></script>
<script>
$(".nav li").on("click",function(){
    $(".nav li").removeClass("active");
    $(this).addClass("active");
})
$("#Set").on("click",function(){
    $("#FeesModal").show();
})
$("#modalClose").click(function(){
    $("#FeesModal").hide();
})
$("#Current").click(function(){
    $("#CurrentModal").show();
})
$("#Next").click(function(){
    $("#NextModal").show();
})
</script>
@stop

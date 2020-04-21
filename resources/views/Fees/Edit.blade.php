@extends('layouts.main')
@section('content')
<div class="container-fluid">
<h2>Edit Fees</h2>
<div class="col-sm-8 col-sm-offset-2">
    <div class="form">
        <!--start form-->
        <form method="post" action="{{ route('fees.update',[$fee->id]) }}">
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
                <input type="number" name="Amount"  class="form-control" value="{{ $fee->Amount }}">
              </div>
              <!--end form group-->
          </div>
          <!--end col -->
           </div>
           <div class="col">
               <button class="btn btn-success  btn-sm" type="submit"><i class="fa fa-plus-circle"></i>&nbsp;Update Fees</button>
           </div>
        </form>
        <!--end form-->
    </div>
</div>
</div>
@stop

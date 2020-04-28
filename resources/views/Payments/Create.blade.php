@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <h2  style="color:#eb4e0f;font-weight:bold">
        <i class="fa fa-hand-holding-usd"></i>&nbsp; Make Fees Payments<hr>
    </h2>
    <div class="form-group panel">
        @if($errors->all())
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert">&timesbar;</a>
            @foreach ($errors->all() as  $error)
            <span>{{ $error }}</span><br>
            @endforeach
        </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert">&timesbar;</a>
           {{Session::get('error')}}
        </div>
        @endif
        @if(Session::has('success'))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">&timesbar;</a>
           {{Session::get('success')}}
        </div>
        @endif
        <form method="post" action="{{ route('payments.post') }}">
            @csrf
            <div class="row">
                <!--start col-->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="StudentRegistration" class="label-control">
                           <i class="fa fa-id-badge" style="color:#eb4e0f"></i> Student Registration Number
                        </label>
                        <input type="text" class="form-control input-sm" name="StudentAdmission" placeholder="Student Registration Number">
                    </div>
                </div>
                <!--end Col-->
                <!--start col-->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="AmountPaid" class="label-control">
                           <i class="fa fa-coins" style="color:#eb4e0f"></i> Amount paid
                        </label>
                        <input type="number" class="form-control input-sm" name="Amount" placeholder="Amount Paid">
                    </div>
                </div>
                <!--end Col-->
                <!--start col-->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="PaymentMode" class="label-control">
                           <i class="fa fa-money-bill" style="color:#eb4e0f"></i>Payment Mode
                        </label>
                        <select class="form-control input-sm" name="PaymentMethod">
                            <option>Cheque</option>
                            <option>Cash</option>
                        </select>
                    </div>
                </div>
                <!--end Col-->
                <div class="col-sm-3">
                    <button class="btn btn-success btn-sm" style="margin-top:20px">
                        <i class="fa fa-upload"></i> Submit Payments
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

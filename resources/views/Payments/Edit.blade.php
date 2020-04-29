@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <h1>Edit Payments Transactions</h1>
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
        <form method="post" action="{{ route('payments.update',[$payment->id]) }}" class="form">
            @csrf
            <div class="row">
                <!--start col-->
                <div class="col-sm-3">
                    <div>
                        <label for="StudentRegistration" class="label-control">
                           <i class="fa fa-id-badge" style="color:#eb4e0f"></i> Student Registration Number
                        </label>
                        <select name="StudentAdmission" class="form-control chosen-select">
                            @foreach($students as $student)
                                <option value="{{$student->AdmissionNumber}}" @if($payment->StudentAdmission==$student->AdmissionNumber) selected @endif>{{$student->AdmissionNumber}}::{{$student->StudentName}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!--end Col-->
                <!--start col-->
                <div class="col-sm-3" style="height:300px">
                    <div class="form-group">
                        <label for="PaymentMode" class="label-control">
                           <i class="fa fa-money-bill" style="color:#eb4e0f"></i>Payment Mode
                        </label>
                        <select class="form-control input-sm chosen-select" name="PaymentMethod" style="height:auto">
                            <option @if($payment->PaymentMethod=="Cheque") selected @endif</option>Cheque</option>
                            <option @if($payment->PaymentMethod=="Cash") selected @endif>Cash</option>
                        </select>
                    </div>
                </div>
                <!--end Col-->
                <!--start col-->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="AmountPaid" class="label-control">
                           <i class="fa fa-coins" style="color:#eb4e0f"></i> Amount paid
                        </label>
                        <input type="number" class="form-control input-sm" name="Amount" value="{{ $payment->Amount }}">
                    </div>
                </div>
                <!--end Col-->
                <!--start col-->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="PaidBy" class="label-control">
                           <i class="fa fa-user" style="color:#eb4e0f"></i>Paid By
                        </label>
                        <input type="text" class="form-control input-sm" name="PaidBy" value="{{ $payment->PaidBy }}">
                    </div>
                </div>
                <!--end Col-->
                <div class="col-sm-3 col-sm-offset-3 pull-left">
                    <button class="btn btn-success btn-sm btn-block">
                        <i class="fa fa-arrow-circle-up"></i> Update Payments
                    </button>
                </div>
            </div>
        </form>
</div>
@stop

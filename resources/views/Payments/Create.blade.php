@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <h2  style="color:#eb4e0f;font-weight:bold">
        <i class="fa fa-hand-holding-usd"></i>&nbsp; Make Fees Payments<hr>
    </h2>
    <div>
        <form method="post" action="{{ route('payments.post') }}" class="form">
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
                                <option value="{{$student->AdmissionNumber}}">{{$student->AdmissionNumber}}::{{$student->StudentName}}</option>
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
                            <option>Cheque</option>
                            <option>Cash</option>
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
                        <input type="number" class="form-control input-sm" name="Amount" placeholder="Amount Paid">
                    </div>
                </div>
                <!--end Col-->
                <!--start col-->
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="PaidBy" class="label-control">
                           <i class="fa fa-user" style="color:#eb4e0f"></i>Paid By
                        </label>
                        <input type="text" class="form-control input-sm" name="PaidBy" placeholder="Person Who Paid">
                    </div>
                </div>
                <!--end Col-->
                <div class="col-sm-3 col-sm-offset-3 pull-left">
                    <button class="btn btn-success btn-sm btn-block">
                        <i class="fa fa-upload"></i> Submit Payments
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

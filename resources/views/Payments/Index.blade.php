@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="table-responsive col-sm-7">
        <table class="table table-condensed table-hover table-striped table-bordered">
            <caption><h1>Payments Transactions</h1>
                </caption>
            <thead>
                <th>Payment Id</th>
                <th>Admission</th>
                <th>Paid By</th>
                <th>Amount</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($transactions as  $transaction)
                <tr>
                    <td>{{ $transaction->PaymentCode }}</td>
                    <td>{{ $transaction->StudentAdmission }}</td>
                    <td>{{ $transaction->PaidBy }}</td>
                    <td>{{ $transaction->Amount }}</td>
                    <td><a href="{{ route('transaction.edit',[$transaction->id]) }}" class="fa fa-edit btn btn-primary btn-xs"></a>&nbsp;<a href="{{ route('transaction.print',[$transaction->id]) }}" class="fa fa-eye btn btn-success btn-xs"></a>&nbsp;<a href="#" class="fa fa-trash-alt btn btn-danger btn-xs"></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-sm-5" style="background-color:#ededed !important">
        <form class="container-fluid" style="height:200px !important">
            <h3> <i class="fa fa-check-circle"></i>&nbsp; Verify Transaction</h3><br>
           <div class="row">
               <div class="col-sm-7">
                <select class="form-control form-inline chosen-select">
                    @foreach ($transactions as $transaction )
                        <option value="{{ $transaction->PaymentCode }}">{{ $transaction->PaymentCode }}</option>
                    @endforeach
                </select>
               </div>
               <div class="col-sm-5">
                <button class="btn btn-success"><i class="fa fa-search"></i>&nbsp;Transaction</button>
               </div>
           </div>
        </form>
       <div class="panel" style="background-color:#ffffff !important">
        <div class="panel-heading text-center">
            <u><span style="font-weight:bold;font-family:'Times New Roman'">CHARTS</span></u>
        </div>
          <div class="panel-body">
            <canvas id="myChart1"></canvas>
          </div>
       </div>
    </div>
</div>
<script src="{{asset('js/Chart.min.js')}}" type="text/javascript"></script>
<script>
    let newChart=document.getElementById('myChart1').getContext("2d");
    //set the variable of the new chart
    let cth=new Chart(newChart,{
type:'doughnut',
data:{
    labels:['Cheque','Cash'],
    datasets:[{
        data:[500000,56000],
        backgroundColor:['blue','indigo'],
    }]
},
options:{
            title:{
                text: "Fees Payment By Methods",
                display:"true",
            }
        }
    });
</script>
@endsection

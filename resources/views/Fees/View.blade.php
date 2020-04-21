@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <h2>View Form   Fees</h2>
    <div class="pull-right">
        <a href="#" class="btn btn-xs btn-info"><i class="fa fa-print"></i>&nbsp; Print </a><br><br>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th>VoteHead</th>
                    <th>Term</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($fees as $fee)
               <tr>
                   <td>{{ $fee->VoteHead }}</td>
                   <td>{{ $fee->Term }}</td>
                   <td>{{ $fee->Amount }}</td>
               </tr>
               @endforeach
               <tr>
                   <td colspan=2 style="color:red;font-weight:bolder">
                       Total
                    <?php $sum=0;
                    for($i=0;$i<count($fees);$i++){
                        $sum=$sum+$fees[$i]->Amount;
                    }
                    ?>
                   </td>
                   <td style="color:red;font-weight:bolder">
                       {{ $sum }}
                   </td>
               </tr>
            </tbody>
        </table>
    </div>
    </div>
@stop

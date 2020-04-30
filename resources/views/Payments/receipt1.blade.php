<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name') }} Payment Receipt</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 4 -->
</head>
<body style="overflow:hidden;font-family:'Times New Roman', Times, serif' !important">
<div class="container">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row-fluid" style="background-color:#f2f2f2;font-family:'Times New Roman', Times, serif'">
      <div class="col-12">
        <h2 class="page-header" style="font-family:'Times New Roman';font-weight:bold;font-size:20px">
          <i class="fas fa-globe"></i>&nbsp;<span>Fees Payment Slip</span>
          <small class="float-right" style="font-family:'Courier New', Courier, monospace;font-size:12px;font-weight:bold;">Printed On:  Date: {{ date('d-m-Y') }}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="container">
      <div class="row">
        <div class="col-sm-4">
            Received by:
            <address style="font-style:italic;font-family:'Courier New', Courier, monospace">
              <strong>Sample School High School</strong><br>
              P.O BOX 100-20305,<br>
              Ol Kalou,Kenya<br>
              TEL: 0704922042,<br>
             Paid on {{ ($last->created_at)->toFormattedDateString()}}.
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4" style="font-family:'Times New Roman', Times, serif'">
            Paid to
            <address>
              <strong>{{ App\Student::where('AdmissionNumber','=',$last->StudentAdmission)->get()->first()->StudentName }}</strong><br>
             Form {{ App\Student::where('AdmissionNumber','=',$last->StudentAdmission)->get()->first()->class }} {{ App\Student::where('AdmissionNumber','=',$last->StudentAdmission)->get()->first()->Stream }}<br>
              Admission {{ App\Student::where('AdmissionNumber','=',$last->StudentAdmission)->get()->first()->AdmissionNumber }}<br>
              Paid By: {{ $last->PaidBy }}<br>
              Received By : {{ $last->ReceivedBy }}
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4">
            <b class="pull-right" style="border: 2px solid red">Receipt Number <span>{{ $last->PaymentCode }}</span></b><br>
            <br>
            <b>Payment Mode:</b> {{ $last->PaymentMethod }}<br>
            <b>Paid in:</b> 2/22/2014<br>
            <b>Account:</b> 968-34567
          </div>
          <!-- /.col -->
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <!-- accepted payments column -->
      <div class="col-6">
        <p class="lead">Payment Methods:</p>
        <p  style="margin-top: 10px;">
            All Fees Payments Are to be Made in the following banks Accounts. We Strictly Do Not Allow Cash Payments Not
            Unless Its Necessary
            <div class="row">
                <div class="col-sm-6">
                    <address style="font-weight:bold;font-size:10px;font-family:'Courier New', Courier, monospace">
                        &nbsp;<i class="fa fa-university"></i> Equity Bank<br>
                        &nbsp;<i class="fa fa-tags"></i> Account Number: 6660398780698<br>
                        &nbsp;<i class="fa fa-code-branch"></i> Branch : Any Branch Countywide<br>
                    </address>
                </div>
                <div class="col-sm-6">
                    <address style="font-weight:bold;font-size:10px;font-family:'Courier New', Courier, monospace">
                        &nbsp;<i class="fa fa-university"></i> Cooperative  Bank<br>
                        &nbsp;<i class="fa fa-tags"></i> Account Number: 6660398780698<br>
                        &nbsp;<i class="fa fa-code-branch"></i> Branch : Any Branch Countywide<br>
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <address style="font-weight:bold;font-size:10px;font-family:'Courier New', Courier, monospace">
                        &nbsp;<i class="fa fa-university"></i> Barclays Bank<br>
                        &nbsp;<i class="fa fa-tags"></i> Account Number: 6660398780698<br>
                        &nbsp;<i class="fa fa-code-branch"></i> Branch : Any Branch Countywide<br>
                    </address>
                </div>
                <div class="col-sm-6">
                    <address style="font-weight:bold;font-size:10px;font-family:'Courier New', Courier, monospace">
                        &nbsp;<i class="fa fa-university"></i> National  Bank<br>
                        &nbsp;<i class="fa fa-tags"></i> Account Number: 6660398780698<br>
                        &nbsp;<i class="fa fa-code-branch"></i> Branch : Any Branch Countywide<br>
                    </address>
                </div>
            </div>
        </p>
      </div>
      <!-- /.col -->
      <div class="col-6">
        <p class="lead">This Terms Fees Ksh:{{  App\Student::where('AdmissionNumber','=',$last->StudentAdmission)->get()->first()->SchoolFees }}</p>

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Amount Paid:</th>
              <td> Ksh : {{ $last->Amount }}</td>
            </tr>
            <tr>
              <th>Fees Balance</th>
              <td> Ksh : {{  App\Student::where('AdmissionNumber','=',$last->StudentAdmission)->get()->first()->Balance }}</td>
            </tr>
            <tr>
              <th>Arrears:</th>
              <td>Ksh : {{  App\Student::where('AdmissionNumber','=',$last->StudentAdmission)->get()->first()->SchoolFees - App\Student::where('AdmissionNumber','=',$last->StudentAdmission)->get()->first()->Balance  }}</td>
            </tr>
            <tfoot>
               <tr>
                   <td colspan="4" style="font-size:10px;font-family:'Courier New';font-style:italic">
                    You Were Served by : {{ Auth::user()->name }}
                   </td>
               </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>

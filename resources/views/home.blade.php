@extends('layouts.main')
@section('content')
<div class="row-fluid">
    <section class="content" style="background-color: #f7f7f7 !important">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info" style="background-color:#17a2b8" >
                <div class="inner">
                  <h3>150</h3>

                  <p>Students</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user-graduate"></i>
                </div>
                <a href="#" class="btn btn-warning btn-block btn-sm">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box" style="background-color:#28a745">
                <div class="inner">
                  <h3>53</h3>

                  <p>Teachers</p>
                </div>
                <div class="icon">
                  <i class="fa fa-chalkboard-teacher"></i>
                </div>
                <a href="#" class="btn btn-warning btn-block btn-sm">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning" style="background-color:#ffc107">
                <div class="inner">
                  <h3>44</h3>

                  <p>Users</p>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
                <a href="#" class="btn btn-warning btn-block btn-sm">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box" style="background-color:#0bf341">
                <div class="inner">
                  <h3>65</h3>

                  <p>Librarians</p>
                </div>
                <div class="icon">
                  <i class="fa fa-book-reader"></i>
                </div>
                <a href="#" class="btn btn-warning btn-block btn-sm">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info" style="background-color:#9606f3" >
                <div class="inner">
                  <h5>15000000</h5>

                  <p>Fees Paid</p>
                </div>
                <div class="icon">
                  <i class="fa fa-hand-holding-usd"></i>
                </div>
                <a href="#" class="btn btn-warning btn-block btn-sm">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box" style="background-color:#ef1ad2">
                <div class="inner">
                  <h5>530,000</h5>

                  <p>Expences</p>
                </div>
                <div class="icon">
                  <i class="fa fa-toolbox"></i>
                </div>
                <a href="#" class="btn btn-warning btn-block btn-sm">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning" style="background-color:#e71968">
                <div class="inner">
                  <h5>440,000</h5>

                  <p>Balances</p>
                </div>
                <div class="icon">
                  <i class="fa fa-file-pdf"></i>
                </div>
                <a href="#" class="btn btn-warning btn-block btn-sm">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box" style="background-color:#dc3545">
                <div class="inner">
                  <h5>65</h5>

                  <p>Clubs</p>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
                <a href="#" class="btn btn-warning btn-block btn-sm">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-12 col-6 text-center">
                <div class="panel" style="background-color:#ededed !important">
                    <span>
                        <u><b>Enrollment By Classes</b></u>
                      </span>
                    <div class="panel-body">
                        <canvas id="myChart">
                        </canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-12 col-6 text-center">
                 <div class="panel" style="background-color:#ededed !important">
                    <span>
                        <u><b>School Expenditure vs School's Income</b></u>
                      </span>
                     <div class="panel-body">
                        <canvas id="myChart1">
                        </canvas>
                     </div>
                 </div>
              </div>
            <!-- ./col -->
          </div>
        </div><!-- /.container-fluid -->
      </section>
</div>
<script src="{{asset('js/Chart.min.js')}}" type="text/javascript"></script>
<script>
    var labels1=['Form 1','Form 2','Form 3', 'Form 4'];
    var dataz=[400,400,500,430];
    var colors=['#8bbb6f','#3598db','#f01ad2','#8e75c6'];
    var ctx=document.getElementById("myChart").getContext("2d");
    var chart=new Chart(ctx,{
        type:'doughnut',
        data:{
            labels: labels1,
            datasets:[{
                data:dataz,
                backgroundColor:colors,
            }]
        },
        // options:{
        //     title:{
        //         text: "Enrollment By Classes",
        //         display:"true",
        //         style:'underline'
        //     }
        // }
    });
    //new chart
    //get the canvas element
    let newChart=document.getElementById('myChart1').getContext("2d");
    //set the variable of the new chart
    let cth=new Chart(newChart,{
type:'doughnut',
data:{
    labels:['Expenditure','School\'s Income'],
    datasets:[{
        data:[10000000,56000000],
        backgroundColor:['#dc3546','#0af340'],
    }]
}
    });
</script>
@stop

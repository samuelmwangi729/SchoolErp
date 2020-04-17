@extends('layouts.main')
@section('content')
<div class="container-fluid">
   <div class="container">
       <ul class="nav nav-tabs">
           <li class="active">
               <a href="#" id="Fees"><i class="fa fa-list-alt"></i>&nbsp; Fees</a>
           </li>
           <li>
            <a href="#" id="Set"><i class="fa fa-cogs"></i>&nbsp; Set Fees</a>
        </li>
       </ul>
   </div>
   <div class="row"><br>
    @foreach ($classes as $class)
    <!--Start Col-->
    <div class="col-sm-6">
        <div class="panel">
            <div class="panel-heading bg-black text-center">
                Form {{ $class->Class }} Fees
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
                    </table>
                </div>
            </div>
            <div class="panel-footer" style="background-color:#fec107">
               <b> Total Amount</b>
            </div>
        </div>
    </div>
    <!--end Col-->
    @endforeach
</div>
<script src="{{asset('js/jquery-1.12.1.min.js')}}"></script>
<script>
$(".nav li").on("click",function(){
    $(".nav li").removeClass("active");
    $(this).addClass("active");
})

</script>
@stop
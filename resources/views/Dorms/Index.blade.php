@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="table-responsive">
        @if($errors->all())
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert"><u>&times;</u></a>
        <ul style="list-style:none">
           @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
           @endforeach
        </ul>
    </div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert"><u>&times;</u></a>
        <span>{{ Session::get('error')}}</span>
    </div>
    @endif
    @if(Session::has('success'))
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert"><u>&times;</u></a>
        <span>{{Session::get('success')}}</span>
    </div>
    @endif
        <a href="javascript::void" id="AddDorm" class="btn btn-success btn-xs"><i class="fa fa-building"></i>&nbsp; Add Dormitory</a>
        <br>
        <table class="table table-condensed table-striped table-hover">
            <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Dorm
                    </th>
                    <th>
                        Status
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $count=1;?>
                @foreach ($dorms as $dorm )
                    <tr>
                        <td><?php echo $count;?></td>
                        <td>{{ $dorm->Dorm }}</td>
                        <td><a href="#" class="fa fa-edit btn btn-primary btn-xs"></a>&nbsp;<a href="#" class="fa fa-trash-alt btn btn-danger btn-xs"></a>&nbsp;</td>
                        <?php $count=$count+1;?>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal" tabindex="-1" id="Dorm">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <a href="#" class="close" data-toggle="modal" id="modalClose">&times;</a>
              <h2 class="modal-title text-center"><i class="fa fa-university" style="color:red"></i> &nbsp;Add A new Dorm</h2>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('dorm.add') }}" id="contactForm" method="post" class="contact-form-aqua">
                    @csrf  
                    <div class="form-group">
                        <label class="label-control" for="Dorm"><i class="fa fa-tags"></i>&nbsp; Dorm Name</label>
                        <input type="text" class="form-control input-sm" name="Dorm" placeholder="Enter the Name of The Dorm">
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-12 offset-md-0">
                            <button type="submit" class="btn btn-success btn-block btn-sm">
                                {{ __('Add Dorm') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
              &copy;{{ config('app.name') }} @<?php echo date('Y');?>
            </div>
          </div>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery-1.12.1.min.js')}}"></script>
<script>
$("#AddDorm").on("click",function(){
    $("#Dorm").show();
})
$("#modalClose").on("click",function(){
    $("#Dorm").hide();
})
</script>
@endsection
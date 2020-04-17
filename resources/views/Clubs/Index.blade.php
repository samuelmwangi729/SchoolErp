@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="table-responsive">
        <a href="javascript::void;" id="Club" class="btn btn-sm btn-success pull-right"><i class="fa fa-users-cog"></i> Add Club</a>
        <br><br><br><br>

    <table class="table table-condensed table-bordered table-striped">
        @if($errors->all())
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <ul style="list-style:none">
                    @foreach ($errors->all() as $error )
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(Session::has('success'))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            {{ Session::get('success') }}
        </div>

        @endif
    <thead>
    <tr>
    <th>ID</th>
    <th>Club</th>
    <th>Status</th>
    <th>Action</th>
    </tr>
    </thead>
    <tbody>
        @if(count($clubs)==0)
        <tr>
            <td colspan="4">
                <div class="alert alert-danger">
                    No Clubs Currently Added
                </div>
            </td>
        </tr>
        @else
        @foreach($clubs as $club)
        <tr>
            <td>{{ $club->id }}</td>
            <td>{{ $club->Club }}</td>
            <td>
                @if($club->Status ==0)
                <button class="btn btn-xs btn-danger">Pending</button>
                @else
                <button class="btn btn-xs btn-success">Approved</button>
                @endif
            </td>
            <td><a href="{{ route('club.edit',[$club->id]) }}" class="fa fa-edit btn btn-xs btn-warning"></a>&nbsp;@if($club->Status==1)<a href="{{ route('club.reject',[$club->id]) }}" class="fa fa-times-circle btn btn-xs btn-danger">&nbsp;Reject</a>@endif&nbsp;
                @if($club->Status==0)<a href="{{ route('club.approve',[$club->id]) }}" class="fa fa-check-circle btn btn-xs btn-primary">&nbsp;Approve</a>@endif
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
    </table>
    </div>
    <div class="modal" tabindex="-1" id="ClubForm">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <a href="#" class="close" data-toggle="modal" id="modalClose">&times;</a>
              <h2 class="modal-title text-center"><i class="fa fa-users-cog" style="color:red"></i> &nbsp;Add A new Club</h2>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('club.store') }}" id="contactForm" method="post" class="contact-form-aqua">
                    @csrf
                    <div class="form-group">
                        <label for="club" class="label-control"><i class="fa fa-tags"></i>&nbsp;Club Name</label>
                        <input type="text" name="Club"  class="form-control">
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-12 offset-md-0">
                            <button type="submit" class="btn btn-success btn-block btn-sm">&nbsp;
                                <i class="fa fa-users-cog"></i>
                                {{ __('Add Club ') }}
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
    $("#Club").on("click",function(){
        $("#ClubForm").show('fadeIn');
    })
    $("#modalClose").on("click",function(){
        $("#ClubForm").hide('fadeInUp');
    })
</script>
@stop
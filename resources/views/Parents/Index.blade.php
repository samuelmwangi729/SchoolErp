@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <a href="javascript::void" id="AddTeacher"  class="btn btn-primary"><i class="fa fa-user-plus"></i>&nbsp;Add Parent </a> <br><br>
<div class="table-responsive">
    <table class="table table-striped  table-bordered table-hover table-condensed">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>PhoneNumber</th>
                <th>Nationality</th>
                <th>PostalAddress</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parents as $parent)
                <tr>
                    <td><img src="{{ asset( $parent->Passport) }}" width="30px" height="30px"></td>
                    <td>{{ $parent->Names }}</td>
                    <td>{{ $parent->PhoneNumber }}</td>
                    <td>{{ $parent->Nationality }}</td>
                    <td>{{ $parent->PostalAddress }}</td>
                    <td><a href="{{ route('parent.edit',[$parent->id]) }}" class="fa fa-edit btn btn-sm btn-info"></a>&nbsp;<a href="#" class="fa fa-eye btn btn-sm btn-success"></a>&nbsp;<a href="#" class="fa fa-trash-alt btn btn-sm btn-danger"></a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal" tabindex="-1" id="Teacher">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <a href="#" class="close" data-toggle="modal" id="modalClose">&times;</a>
          <h2 class="modal-title text-center"><i class="fa fa-user-plus" style="color:red"></i> &nbsp;Add A new Parent</h2>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('parents.store') }}" id="contactForm" method="post" class="contact-form-aqua">
                @csrf
          @include('Parents.form')
                <div class="form-group row mb-0">
                    <div class="col-md-12 offset-md-0">
                        <button type="submit" class="btn btn-success btn-block btn-sm fa fa-user">&nbsp;
                            {{ __('Add Parent ') }}
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
    $("#AddTeacher").on("click",function(){
        $("#Teacher").show("fadeInDown");
    })
    $("#modalClose").on("click",function(){
        $("#Teacher").hide("fadeOutDown");
    })
</script>
@endsection

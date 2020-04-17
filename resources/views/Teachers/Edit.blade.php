@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <h3><i class="fa fa-user-cog"></i>&nbsp;Edit Teachers Details</h3>
    <div class="container-fluid">
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
        <span>{{ Se }}ssion::get('error')}}</span>
    </div>
    @endif
    @if(Session::has('success'))
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert"><u>&times;</u></a>
        <span>{{Session::get('success')}}</span>
    </div>
    @endif
        <div class="form">
            <form method="post" action="{{ route('teacher.update',[$teacher->id]) }}">
                @csrf
                <div class="form-group row">
                    <div class="col-md-6">
                        <input type="text" placeholder="Your Names" class="form-control " name="name"  value="{{ $teacher->name  ?? ''}}"   >
                    </div>
                    <div class="col-md-6">
                        <input type="number" placeholder="Your Phone Number" class="form-control"  name="phone"  value="{{ $teacher->phone ?? '' }}"  >
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <input type="text" placeholder="TSC Number" class="form-control "name="tsc"  value="{{$teacher->tsc  ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="UserName" class="form-control" name="username"  value="{{ $teacher->username ?? ''  }}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <input type="text" placeholder="Teaching Subject 1" class="form-control" name="subject1"  value="{{ $teacher->subject1 ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="Teaching Subject 2" class="form-control" name="subject2" value="{{ $teacher->subject2 ?? '' }}">
                    </div>
                </div>
                
                <div class="form-group row">
                    <div class="col-md-6">
                        <input type="email" placeholder="Your Email Address" class="form-control" name="email" value="{{ $teacher->email  ?? ''}}" >
                
                        
                    </div>
                    <div class="col-md-6">
                        <input type="text" placeholder="Employer.eg TSC" class="form-control" name="employer" value="{{ $teacher->employer  ?? '' }}" >
                
                        
                    </div>
                </div>
                </div>
                <div class="col-sm-6 col-sm-offset-5">
                    <button class="btn btn-success">
                        Update Details
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
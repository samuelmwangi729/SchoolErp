@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <h3><i class="fa fa-user-cog"></i>&nbsp;Edit Parents Details</h3>
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
        <span>{{ Session::get('error')}}</span>
    </div>
    @endif
    @if(Session::has('success'))
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert"><u>&times;</u></a>
        <span>{{Session::get('success')}}</span>
    </div>
    @endif
        <div class="form">
            <form method="post" action="{{ route('parent.update',[$parent->id]) }}">
                @csrf
                <!--row start-->
<div class="form-group row">
    <!--start col-->
    <div class="col-sm-4">
        <div class="form-group">
            <label for="names" class="label-control fa fa-tags">&nbsp;Names</label>
            <input type="text" class="form-control input-sm" name="Names" placeholder="Enter Parent Names" value="{{ $parent->Names ?? '' }}">
        </div>
    </div>
    <!--end col-->
     <!--start col-->
     <div class="col-sm-4">
        <div class="form-group">
            <label for="email" class="label-control fa fa-mail-bulk">&nbsp;Email</label>
            <input type="email" class="form-control input-sm" name="Email" placeholder=" Empty if No Address" value="{{ $parent->Email ?? '' }}">
        </div>
    </div>
    <!--end col-->
     <!--start col-->
     <div class="col-sm-4">
        <div class="form-group">
            <label for="Gender" class="label-control fa fa-users">&nbsp;Gender</label>
            <select name="Gender" class="form-control imput-sm">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
<!--row start-->
<div class="form-group row">
    <!--start col-->
    <div class="col-sm-4">
        <div class="form-group">
            <label for="Academic Level" class="label-control fa fa-graduation-cap">&nbsp;Academic Level</label>
            <select name="AcademicLevel" class="form-control input-sm">
                <option value="Masters">Masters</option>
                <option value="Bachelors Degree">Bachelors Degree</option>
                <option value="Diploma">Diploma</option>
                <option value="Others">Others</option>
            </select>
        </div>
    </div>
    <!--end col-->
     <!--start col-->
     <div class="col-sm-4">
        <div class="form-group">
            <label for="Disabled" class="label-control fa fa-user-injured">&nbsp;Disabled</label>
            <select name="Disabled" class="form-control input-sm">
                <option value="No">No</option>
                <option value="Yes">Yes</option>
            </select>
        </div>
    </div>
    <!--end col-->
     <!--start col-->
     <div class="col-sm-4">
        <div class="form-group">
            <label for="Gender" class="label-control fa fa-phone">&nbsp;Phone Number</label>
            <input class="form-control input-sm" type="number" name="PhoneNumber" value="{{ $parent->PhoneNumber ?? '' }}">
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
<!--row start-->
<div class="form-group row">
    <!--start col-->
    <div class="col-sm-4">
        <div class="form-group">
            <label for="Nationality" class="label-control fa fa-id-card">&nbsp;Nationality</label>
            <input type="text" class="form-control input" name="Nationality" placeholder="Eg. Kenyan" value="{{ $parent->Nationality ?? '' }}">
        </div>
    </div>
    <!--end col-->
     <!--start col-->
     <div class="col-sm-4">
        <div class="form-group">
            <label for="Passport" class="label-control fa fa-image">&nbsp;Passport</label>
            <input type="file" name="Passport"  class="form-control inp">
        </div>
    </div>
    <!--end col-->
     <!--start col-->
     <div class="col-sm-4">
        <div class="form-group">
            <label for="Postal Address" class="label-control fa fa-address-book">&nbsp;Postal Address</label>
            <input type="text" name="PostalAddress"  class="form-control input-sm" value="{{ $parent->PostalAddress ?? '' }}">
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
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
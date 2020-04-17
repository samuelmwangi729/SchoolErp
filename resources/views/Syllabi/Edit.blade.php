@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <h3>Edit Syllabus</h3>
    @if(Session::has('error'))
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert"><u>&times;</u></a>
        <strong>{{ Session::get('error') }}</strong>
    </div>
    @endif
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
    <div class="col-sm-12" id="fadd">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h5 class="text-center">Edit Academic Syllabus</h5>
            </div>
            <div class="panel-body">
                <div class="form">
                    <form method="POST" action="{{ route('syllabus.update',[$syllabus->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @include('Syllabi.form')
                        <div class="col-sm-6 col-sm-offset-5">
                            <button class="btn btn-success" type="submit">
                                Update Syllabus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel-footer">
                <span>&copy;{{ config('app.name') }} @<?php echo date('Y');?></span>
            </div>
        </div>
    </div>
</div>
@stop
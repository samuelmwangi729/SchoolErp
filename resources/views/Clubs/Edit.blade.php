@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="table-responsive">
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
        <form method="POST" action="{{ route('club.update',[$club->id]) }}" id="contactForm" method="post" class="contact-form-aqua">
            @csrf
            <div class="form-group">
                <label for="club" class="label-control"><i class="fa fa-tags"></i>&nbsp;Club Name</label>
                <input type="text" name="Club"  class="form-control" value="{{ $club->Club }}">
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-12 offset-md-0">
                    <button type="submit" class="btn btn-success btn-block btn-sm">&nbsp;
                        <i class="fa fa-users-cog"></i>
                        {{ __('Update Club ') }}
                    </button>
                </div>
            </div>
        </form>        
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
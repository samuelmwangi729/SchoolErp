@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <div class="row">
        <i class="fa fa-edit"></i>&nbsp;Edit VoteHead
        <div class="container">
            <br> <br> <br>
            <form method="post" action="{{ route('votehead.update',[$votehead->id]) }}">
                @csrf
                <div class="row">
                    <!--Start col-->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="Class" class="label-control"><i class="fa fa-university"></i>&nbsp;Class</label>
                            <select name="Class" class="form-control">
                                @foreach ($classes as $class )
                                    <option value="{{ $class->Class }}">Form {{ $class->Class }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!--End COl-->
                     <!--Start col-->
                     <div class="col-sm-3">
                        <div class="form-group">
                            <label for="VoteHead" class="label-control"><i class="fa fa-tags"></i>&nbsp;VoteHead</label>
                            <input type="text" name="VoteHead"  class="form-control" value="{{ $votehead->VoteHead }}">
                        </div>
                    </div>
                    <!--End COl-->
                     <!--Start col-->
                     <div class="col-sm-3">
                        <div class="form-group">
                            <button class="btn btn-success btn-sm" type="submit" style="margin-top:23px"><i class="fa fa-upload"></i>&nbsp;Update VoteHead</button>
                        </div>
                    </div>
                    <!--End COl-->
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
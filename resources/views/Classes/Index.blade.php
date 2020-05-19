@extends('layouts.main')
@section('content')
<div class="container-fluid">
    <h1>Manage Classes</h1>
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a href="javascript::void" id="List"><i class="fa fa-university"></i>&nbsp;Classes List</a></li>
            <li><a href="javascript::void" id="Add"><i class="fa fa-plus-circle"></i>&nbsp;Add Streams</a></li>
        </ul>
    </div><br>
    <div id="hidden">
        <div id="form">
            <div class="container-fluid col-sm-8 col-sm-offset-2">
                <div class="table-responsive">
                    <table class="table table-bordered  table-active">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes as $class)
                            <tr>
                                <td>Form {{ $class->Class }}</td>
                                <td><a class="fa fa-trash-alt btn btn-danger btn-xs" href="{{ route('class.delete',[$class->id]) }}"></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="container-fluid col-sm-6 col-sm-offset-2">
                <form method="POST" id="form" action="{{route('class.save')}}">
                    <div class="form-group">
                        @csrf
                        <label class="label-control" for="Session Year">Class</label>
                        <input type="number" id="session" name="Class" class="form-control"  placeholder="eg. 1">
                    </div>
                    <button class="btn btn-success" id="submit"><i class="fa fa-save"></i>Save Class</button>
                </form>
            </div>
        </div>
       </div>
       <div id="Streams">
        <div id="form">
            <div class="container-fluid col-sm-8 col-sm-offset-2">
                <div class="table-responsive">
                    <table class="table table-bordered  table-active">
                        <thead>
                            <tr>
                                <th>Stream</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($streams as $stream)
                            <tr>
                                <td>{{ $stream->Stream }}</td>
                                <td><a class="fa fa-trash-alt btn btn-danger btn-xs" href="{{ route('stream.delete',[$stream->id]) }}"></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="container-fluid col-sm-6 col-sm-offset-2">
                <form method="POST" id="form" action="{{route('streams.save')}}">
                    <div class="form-group">
                        @csrf
                        <label class="label-control" for="Session Year">Stream</label>
                        <input type="text" id="session" name="Stream" class="form-control" minlength="4" placeholder="eg. West">
                    </div>
                    <button class="btn btn-success" id="submit"><i class="fa fa-save"></i>Save Stream</button>
                </form>
            </div>
        </div>
       </div>
</div>
<script src="{{asset('js/jquery-1.12.1.min.js')}}"></script>
<script>
$(".nav li").on("click",function(){
    $(".nav li").removeClass("active");
    $(this).addClass("active");
});
$(document).ready(function(){
    $("#Streams").hide();
})
$("#Add").on("click",function(){
    $("#Streams").show();
    $("#hidden").hide();
})
$("#List").on("click",function(){
    $("#hidden").show();
    $("#Streams").hide();
})
</script>
@endsection

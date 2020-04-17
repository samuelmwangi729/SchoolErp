@extends('layouts.app')

@section('content')
<section class="contact-us-section" id="contact-us-section">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-8 col-xs-12">
            <div class="card contact-form">
                <div class="card-header text-center text-success" style="font-size:20px;background-color:#00ff01;font-family:Arial, Helvetica, sans-serif;font-weight:bold;color:red !important">{{ __('Register') }} For An Account With  {{config('app.name')}}</div>
                <div class="card-body">
                    @include('auth.form');
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

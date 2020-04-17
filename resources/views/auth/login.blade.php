@extends('layouts.app')

@section('content')
<section class="contact-us-section" id="contact-us-section">
<div class="container">
    <div class="row justify-content-center" >
        <div class="col-sm-8 col-xs-12">
            <div class="well">
            <div class="card-header text-center text-success" style="font-size:20px;background-color:#00ff01;font-family:Arial, Helvetica, sans-serif;font-weight:bold;color:red !important">{{ __('Login') }} to Your {{config('app.name')}} account</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}"  style="margin:top:100px" id="contactForm" method="post" class="contact-form-aqua">
                        @csrf

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input id="email" type="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 offset-md-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-0">
                                <button type="submit" class="btn btn-outline-success">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                    <a class="btn btn-link" href="/register">
                                        {{ __('Not A Member? Sign Up Now') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

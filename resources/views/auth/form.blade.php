<form method="POST" action="{{ route('register') }}" id="contactForm" method="post" class="contact-form-aqua">
    @csrf

    <div class="form-group row">
        <div class="col-md-6">
            <input type="text" placeholder="Your Names" class="form-control " name="name"  required  autofocus>
        </div>
        <div class="col-md-6">
            <input type="number" placeholder="Your Phone Number" class="form-control"  name="phone" required  autofocus>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <input type="text" placeholder="TSC Number" class="form-control "name="tsc"  required  autofocus>
        </div>
        <div class="col-md-6">
            <input type="text" placeholder="UserName" class="form-control" name="username"  required  autofocus>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <input type="text" placeholder="Teaching Subject 1" class="form-control" name="subject1"  required  autofocus>
        </div>
        <div class="col-md-6">
            <input type="text" placeholder="Teaching Subject 2" class="form-control" name="subject2" required  autofocus>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <input type="email" placeholder="Your Email Address" class="form-control" name="email"  required >

            
        </div>
        <div class="col-md-6">
            <input type="text" placeholder="Employer.eg TSC" class="form-control" name="employer"  required >

            
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <input id="password" type="password" placeholder="Password" class="form-control active @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

            
        </div>
        <div class="col-md-6">
            <input id="password-confirm" placeholder="Confirm the Password" type="password" class="form-control active" name="password_confirmation" required autocomplete="new-password">
            
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            
        </div>
    </div>

    @if(Auth::check())
    <div class="form-group row mb-0">
        <div class="col-md-12 offset-md-0">
            <button type="submit" class="btn btn-outline-success">
                {{ __('Add Teacher') }}
            </button>
        </div>
    </div>
    @else
    <div class="form-group row mb-0">
        <div class="col-md-12 offset-md-0">
            <button type="submit" class="btn btn-outline-success">
                {{ __('Register') }}
            </button>
            <a class="btn btn-link" href="/login">
                {{ __('Already A Member? Sign In') }}
            </a>
        </div>
    </div>
    @endif
</form>
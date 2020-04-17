    <div class="form-group row">
        <div class="col-md-6">
            <label class="label-control" for="Names"><i class="fa fa-tags"></i>&nbsp;Employee Names</label>
            <input type="text" placeholder="Your Names" class="form-control " name="name"    autofocus>
        </div>
        <div class="col-md-6">
            <label class="label-control fa fa-phone">&nbsp;Phone Number</label>
            <input type="number" placeholder="Your Phone Number" class="form-control"  name="phone"   autofocus>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <label class="fa fa-id-badge label-control">Employee Number </label>
            <input type="text" placeholder="TSC Number" class="form-control "name="tsc"    value="{{ Str::random(5) }}">
        </div>
        <div class="col-md-6">
            <label class="fa fa-id-card label-control" for="Username">&nbsp; Username </label>
            <input type="text" placeholder="UserName" class="form-control" name="username"    autofocus>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <label for="level" class="fa fa-user-cog label-control">&nbsp;Employee Type</label>
        <select class="form-control input-sm" name="level">
            @foreach ($types as $type)
                <option>{{ $type->Type }}</option>
            @endforeach
        </select>
        </div>
        <div class="col-md-6">
        <label class="fa fa-envelope label-control" for="email">&nbsp; Email Adress</label>
            <input type="email" placeholder="Your Email Address" class="form-control" name="email"   >
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label class="fa fa-user-lock label-control" for="password">&nbsp;Password</label>
            <input id="password" type="password" placeholder="Password" class="form-control active @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">

            
        </div>
        <div class="col-md-6">
            <label class="fa fa-user-lock label-control" for="password">&nbsp;Confirm Password</label>
            <input id="password-confirm" placeholder="Confirm the Password" type="password" class="form-control active" name="password_confirmation"  autocomplete="new-password">
            
        </div>
    </div>
@extends('layouts.main.main')

@section('content')
<div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="{{asset('purple/assets/images/logo.svg')}}">
                </div>
                <h4>Hello! let's get started</h4>
                <h6 class="font-weight-light">Sign in to continue.</h6>
                <form method="POST" action="{{ route('login')}}" class="pt-3">
                    @csrf
                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Username">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="exampleInputPassword1" name="password" required autocomplete="current-password" placeholder="Password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                                    SIGN IN
                                </button>
                    {{-- <a class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" href="../../index.html">SIGN IN</a> --}}
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <label class="form-check-label" for="remember">
                        <input type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}> Keep me signed in </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="auth-link text-primary" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                    {{-- <a href="#" class="auth-link text-primary">Forgot password?</a> --}}
                  </div>
                  <div class="mb-2 d-grid gap-2">
                    @if (Route::has('google.login'))
                        <a href="{{ route('google.login') }}" class="btn btn-block btn-google auth-form-btn">
                            <i class="mdi mdi-google me-2"></i>Connect using Google
                        </a>
                    @endif
                    {{-- <button type="button" class="btn btn-block btn-google auth-form-btn">
                      <i class="mdi mdi-google me-2"></i>Connect using Google </button> --}}
                  </div>
                  <div class="text-center mt-4 font-weight-light"> Don't have an account?
                    @if (Route::has('register'))
                        <a class="text-primary" href="{{ route('register') }}">Create</a>
                    @endif
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
    <!-- page-body-wrapper ends -->
</div>
@endsection

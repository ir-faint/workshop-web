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
                <h4>Two-step Verification</h4>
                <h6 class="font-weight-light">We sent an otp code to your email. Enter it here.</h6>
                <form method="POST" action="{{ route('otp.verify.post')}}" class="pt-3">
                    @csrf
                    <div class="form-group">
                    <input type="text" class="form-control form-control-lg text-center @error('email') is-invalid @enderror" id="exampleInputEmail1" name="otp" required autofocus placeholder="Enter 6-digit code" maxlength="6">
                    @error('otp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                    <div class="mt-3 d-grid gap-2">
                        <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">VERIFY</button>
                        {{-- <a class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn" href="../../index.html">SIGN IN</a> --}}
                    </div>
                    <div class="text-center mt-4 font-weight-light">
                        Didn't receive the code? <a href="{{ route('google.login') }}" class="text-primary">Resend</a>
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
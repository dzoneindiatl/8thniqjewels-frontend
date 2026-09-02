@extends('front.layouts.app',['page' => 'login'])
@push('styles')
<link href="{{ asset('assets/front/css/login.css') }}" rel="stylesheet">
@endpush
@section('content')  
<form action="{{route('front-user.postLogin')}}" method="post" autocomplete="off">   
@csrf 
<div class="login-section">
        <div class="container">
            <div class="col-md-4">
                <div class="address-sec-bg">
                    <div class="address-head">
                        <h4>Registered Users</h4>
                        <p class="d-flex justify-content-between">Login Using Email and Password</p>
                    </div>
                    <div class="address-body">
                       <a href="javascript:void(0)" class="registerd-link text-end d-flex justify-content-end" data-bs-toggle="modal" data-bs-target=".login-sign-modal"> Register</a>
                        <div class="form-floating mb-4">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Id" value="{{old('email')}}"/>
                            <label for="floatingInput">Enter your email ID</label>
                             @if ($errors->has('email'))
                                <div class=" invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-floating with-icon mb-4">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" />
                            <label for="floatingInput">Password</label>
                            <span class="eye-icon"><i class="fa-solid fa-eye"></i></span>
                            @if ($errors->has('password'))
                                <div class=" invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                        <div class="address-bottom">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked />
                                <label class="form-check-label" for="flexCheckChecked">
                                    Remember Me
                                </label>
                            </div>
                            <a href="{{route('front-user.forgetPassword')}}" class="text-link">Forget password ?</a>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked />
                            <label class="form-check-label" for="flexCheckChecked"> By continuing. I agree to <a href="{{ Url('/page/terms-service') }}" class="text-link">Terms & Conditions</a> & <a href="{{ Url('/page/privacy-policy') }}" class="text-link">Privacy Policy.</a> </label>
                        </div>
                        <button class="w-100 full-btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
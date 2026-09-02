@extends('front.layouts.app',['page' => 'login'])

<link href="{{ asset('assets/front/8thniqjewells/assets/css/login.css') }}" rel="stylesheet">

@section('content')  
<form action="{{route('front-user.postLogin')}}" method="post" autocomplete="off" id="loginForm">   
@csrf 
<div class="login-section">
        <div class="container">
            <div class="login-box">
                <div class="text-center w-100 mb-5">
                    <img src="{{ asset('assets/front/8thniqjewells/assets/img/logo/logo-black.png') }}" width="150" />
                </div>
                <div class="white-box">
                    <h2 class="mb-4">LOGIN</h2>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active roletab" id="home-tab" data-roleId='4' data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Customer</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link roletab" id="home-tab" data-roleId='5' data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false">Affiliate</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <input type="hidden" name="user_role_id" id="user_role_id" value="4" />
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="email" class="form-control login" placeholder="Enter your email" required/>
                                 @if ($errors->has('email'))
                                <div class=" invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" id="password" class="form-control login" placeholder="Enter your password" required/>
                                @if ($errors->has('password'))
                                <div class=" invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <p>&nbsp;<span style="float:right;"><a href="forgot-password.html" class="forgot-password">Forgot password?</a></span></p>
                            </div>
                            <span class="form-group login-error" style="color:red;fornt-size:16px"> </span>
                            <span class="form-group login-success" style="color:green;fornt-size:16px"> </span>
                            <div class="form-group">
                                <a href="javascript:void('0')" class="login-button" id="loginBtn">
                                    Login <svg class="right" width="30" height="8" viewBox="0 0 30 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z" fill="black" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class=" text-center form-group">
                        <p>Don’t have an account? <a href="{{route('front-user.signup')}}" class="forgot-password">Register</a></p>
                    </div>
                </div>
                <div class="shape text-center">
                    <img src="{{ asset('assets/front/8thniqjewells/assets/img/about/OBJECTS.svg') }}" class="shape-bottom">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
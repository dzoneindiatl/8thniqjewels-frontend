@extends('front.layouts.app',['page' => 'login'])
<link href="{{ asset('assets/front/8thniqjewells/assets/css/login.css') }}" rel="stylesheet">

@section('content')  
<form action="{{route('front-user.postSignup')}}" method="post" autocomplete="off">  
@csrf
<div class="login-section">
        <div class="container">
            <div class="login-box">
                <div class="text-center w-100 mb-5">
                    <img src="{{ asset('assets/front/8thniqjewells/assets/img/logo/logo-black.png') }}" width="150" />
                </div>
                <div class="white-box">
                    <h2 class="mb-4">REGISTER</h2>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Customer</button>
                        </li>
                        <!-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Refferal</button>
                        </li> -->
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Frist name</label>
                                        <input type="text" name="first_name" id="first_name" class="form-control login" placeholder="Enter your first name" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last name</label>
                                        <input type="text" name="last_name" id="last_name" class="form-control login" placeholder="Enter your last name" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" id="email" class="form-control login" placeholder="Enter your email" />
                            </div>
                            <div class="form-group">
                                <label>Phone number</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control login" placeholder="Enter your phone number" />
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" id="password" class="form-control login" placeholder="Enter your password" />
                            </div>
                            <span class="form-group login-error" style="color:red;fornt-size:16px"> </span>
                            <span class="form-group login-success" style="color:green;fornt-size:16px"> </span>
                            <div class="form-group">
                                <button type="button" class="login-button" id="signupBtn">
                                    Register <svg class="right" width="30" height="8" viewBox="0 0 30 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z" fill="black" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <!-- Referal Form -->
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control login" placeholder="Enter Your Name" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control login" placeholder="Enter Your Name" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control login" placeholder="Enter your Mobile No" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mobile No.</label>
                                        <input type="text" class="form-control login" placeholder="Enter your Mobile No" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pan No.</label>
                                        <input type="text" class="form-control login" placeholder="Enter your Pan No" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Gst No</label>
                                        <input type="text" class="form-control login" placeholder="Enter your Gst No" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control login" placeholder="Enter Address" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" class="form-control login" placeholder="Enter Your City" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Youtube</label>
                                        <input type="text" class="form-control login" placeholder="Enter Youtube Link" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Instagram</label>
                                        <input type="text" class="form-control login" placeholder="Enter Instagram Link" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Facebook</label>
                                        <input type="text" class="form-control login" placeholder="Enter Facebook Link" />
                                    </div>
                                </div>
                            </div>
                            <span class="form-group login-error" style="color:red;fornt-size:16px"> </span>
                            <span class="form-group login-success" style="color:green;fornt-size:16px"> </span>
                            <div class="form-group">
                                <button type="button" class="login-button" id="signupBtnReferal">
                                    Register <svg class="right" width="30" height="8" viewBox="0 0 30 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z" fill="black" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <!-- Referal Form -->
                    </div>

                    <div class=" text-center form-group">
                        <p>Already have an account? <a href="{{route('front-user.login')}}" class="forgot-password">Login</a></p>
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
@extends('front.layouts.app')
@section('content')
    <div class="login-section" id="change-password-div">
        <div class="container">
            <div class="login-box">
                <div class="text-center w-100 mb-5">
                    <img src="{{ asset('assets/front/8thniqjewells/assets/img/logo/logo-black.png') }}" width="150" />
                </div>
                <form id="ChangePasswordForm">
                    @csrf
                    <div class="white-box">
                        <h2 class="mb-4">Change Password</h2>
                        <div class="form-group">
                            <label>Create password</label>
                            <input type="password" name="current_password" id="current_password" class="form-control login" placeholder="Current Password" />
                        </div>
                        <div class="form-group">
                            <label>Create password</label>
                            <input type="password" name="new_password" id="new_password" class="form-control login" placeholder="Create a new password" />
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password"  name="confirm_password" id="confirm_password" class="form-control login" placeholder="Re-enter your new Password" />
                        </div>
                        <span class="change-pass-error" style="color:red;font-size:16px"></span>
                        <span class="change-pass-success" style="color:green;font-size:16px"></span>
                        <div class="form-group">
                            <a href="javascript:void('0')" class="login-button" id="changePasswordBtn">
                                Change password <svg class="right" width="30" height="8" viewBox="0 0 30 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z" fill="black" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </form>
                <div class="shape text-center">
                    <img src="{{ asset('assets/front/8thniqjewells/assets/img/about/OBJECTS.svg') }}" class="shape-bottom">
                </div>
            </div>
        </div>
    </div>

    <div class="login-section" id="success-password-msg" style="display:none">
        <div class="container">
            <div class="login-box">
                <div class="text-center w-100 mb-5">
                    <img src="{{ asset('assets/front/8thniqjewells/assets/img/logo/logo-black.png') }}" width="150" />
                </div>
                <div class="white-box">
                    <div class="text-center">
                        <img src="{{ asset('assets/front/8thniqjewells/assets/img/about/success.gif') }}" width="150" />
                        <p class="mt-5 mb-5">
                            Your password has been changed successfully!
                        </p>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('user.dashboard') }}" class="login-button">
                            Go to dashboard <svg class="right" width="30" height="8" viewBox="0 0 30 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z" fill="black" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="shape text-center">
                    <img src="{{ asset('assets/front/8thniqjewells/assets/img/about/OBJECTS.svg') }}" class="shape-bottom">
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('front.layouts.app',['page' => 'login'])
<link href="{{ asset('assets/front/8thniqjewells/assets/css/login.css') }}" rel="stylesheet">

@section('content')  
<div class="login-section">
        <div class="container">
            <div class="login-box" style="width:100%">
                <div class="text-center w-100 mb-5">
                    <img src="{{ asset('assets/front/8thniqjewells/assets/img/logo/logo-black.png') }}" width="150" />
                </div>
                <div class="white-box">
                    <h2 class="mb-4">Affiliates REGISTER</h2>
                    <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Affiliates</button>
                        </li>
                    </ul> -->
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/yqBnIxi7AEw"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>
                    </div>

                     <div class="process">
                        <h2>PROCESS</h2>
                        <div class="button-row">
                            <div class="pro_item">First Signup, If you dont have an account <a href="{{ route('front-user.affiliates-signup') }}">Signup</a></div>
                            <div class="pro_item">Log In with this link <a href="{{ route('front-user.login') }}">Login</a></div>
                            <div class="pro_item">Get Referal Code from your dashboard</div>
                            <div class="pro_item">Share your code to your referance for buying product</div>
                            <div class="pro_item">Get your commission on purchasing by your reference as per order amount percentage</div>
                        </div>
                    </div>

                    <div class="Progress-Summary pt-50 pb-50 pt-md-114 pt-sm-54 pb-sm-0">
                                <!-- From Uiverse.io by AatreyuShau -->
                        <div class="ProgressSummaryBtn" onclick="toggleContent()">
                            <h2>PROCESS SUMMARY</h2>
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" data-iconid="318387"
                                data-svgname="Arrow   down 2">
                                <g id="Iconly/Curved/Arrow - Down 2">
                                    <g id="Arrow - Down 2">
                                        <path id="Stroke 1"
                                            d="M19 8.5C19 8.5 14.856 15.5 12 15.5C9.145 15.5 5 8.5 5 8.5"
                                            stroke="#130F26" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </g>
                                </g>
                            </svg>
                        </div>

                        <div id="content" style="display:none; margin-top:10px;">
                            <div class="step-process-content">
                                <p>
                                <h3>1. Start with the "Quick Start" Summary </h3><br>
                                Give them the "Too Long; Didn't Read" version first.<br>
                                Step 1: Get your unique link from the dashboard.<br>
                                Step 2: Share that link on your blog, social media, or email.<br>
                                Step 3: When someone buys through your link, you earn [X]%.<br>
                                <br>
                                <h3> 2. The Detailed Process Flow (The "How-To") </h3><br>
                                Use simple, action-oriented language to guide them through their first
                                week:<br>
                                Accessing Assets: "Log in to your dashboard to find pre-made banners,
                                product images, and your 'Deep Link' generator. Use these to make your posts
                                look professional."<br>
                                The 'Cookie' Window: "Explain that even if a customer doesn't buy instantly,
                                if they return within [30/60/90] days, the sale still counts toward your
                                commission."<br>
                                Tracking Performance: "Check your 'Reports' tab daily. You’ll see real-time
                                data on how many people clicked your link versus how many actually
                                bought."<br>
                                <br>
                                <h3>3. Clear Payment Rules </h3><br>
                                Nothing frustrates affiliates more than "mystery" paydays. Be explicit:<br>
                                Threshold: "You get paid once your balance hits [Amount]."<br>
                                Timing: "Payments are sent on the [e.g., 15th] of every month via
                                [PayPal/Bank Transfer]."<br>
                                Validation: "There is a [30-day] waiting period to account for any customer
                                returns or refunds."<br>
                                <br>
                                <h3>4. Provide a "First Sale" Checklist </h3> <br>
                                Give them a specific task to build momentum: <br>
                                Log in and update your Payment Profile. <br>
                                Generate a link for our [Best Selling Product]. <br>
                                Post one "Review" or "Recommendation" using that link. <br>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="StartYourJourneyBtn pt-50 pb-50 pt-md-114 pt-sm-54 pb-sm-0" >
                        <div class="button">
                        <svg class="button-cosm" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"
                            width="128" height="128" viewBox="0 0 256 256" id="Flat"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M243.07324,157.43945c-1.2334-1.47949-23.18847-27.34619-60.46972-41.05859-1.67579-17.97412-8.25293-34.36328-18.93653-46.87158C149.41309,52.8208,128.78027,44,104,44,54.51074,44,22.10059,88.57715,20.74512,90.4751a3.99987,3.99987,0,0,0,6.50781,4.65234C27.5625,94.6958,58.68359,52,104,52c22.36816,0,40.89648,7.85107,53.584,22.70508,8.915,10.437,14.65625,23.9541,16.65528,38.894A133.54185,133.54185,0,0,0,136,108c-25.10742,0-46.09473,6.48486-60.69434,18.75391-12.65234,10.63379-19.91015,25.39355-19.91015,40.49463a43.61545,43.61545,0,0,0,12.69336,31.21923C76.98438,207.3208,89.40234,212,104,212c23.98047,0,44.37305-9.4668,58.97461-27.37744,12.74512-15.6333,20.05566-37.145,20.05566-59.01953,0-.1128-.001-.22559-.001-.33838,33.62988,13.48486,53.62207,36.96631,53.89746,37.2959a4.00015,4.00015,0,0,0,6.14648-5.1211ZM104,204c-27.89746,0-40.60449-19.05078-40.60449-36.75146C63.39551,142.56592,86.11621,116,136,116a124.37834,124.37834,0,0,1,38.97266,6.32617q.05712,1.63038.05761,3.27686C175.03027,177.07129,139.29785,204,104,204Z">
                            </path>
                        </svg>
                        <svg class="highlight" viewBox="0 0 144.75738 77.18431" preserveAspectRatio="none">
                            <g transform="translate(-171.52826,-126.11624)">
                                <g fill="none" stroke-width="17" stroke-linecap="round"
                                    stroke-miterlimit="10">
                                    <path
                                        d="M180.02826,169.45123c0,0 12.65228,-25.55115 24.2441,-25.66863c6.39271,-0.06479 -5.89143,46.12943 4.90937,50.63857c10.22345,4.2681 24.14292,-52.38336 37.86455,-59.80493c3.31715,-1.79413 -5.35094,45.88889 -0.78872,58.34589c5.19371,14.18125 33.36934,-58.38221 36.43049,-56.91633c4.67078,2.23667 -0.06338,44.42744 5.22574,47.53647c6.04041,3.55065 19.87185,-20.77286 19.87185,-20.77286">
                                    </path>
                                </g>
                            </g>
                        </svg>
                        <h2>START YOUr  JOURNEY</h2>
                    </div>
                    
                    <div class="tab-content" id="myTabContent" style="width: 70%;text-align: center;padding: 50px;margin: auto;">
                        <!-- Referal Form -->
                        <form action="{{route('front-user.affiliatesPostSignup')}}" method="post" autocomplete="off">  
                        @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Whoops!</strong> There were some problems with your input.
                                    <ul class="mt-2 mb-0" style="height:auto">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <label>First Name</label> -->
                                            <input type="text" name="name" class="form-control login" placeholder="Enter Your Name" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <label>Email</label> -->
                                            <input type="email" name="email" class="form-control login" placeholder="Enter your Email" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <label>Mobile No.</label> -->
                                            <input type="number" name="phone_number" class="form-control login" placeholder="Enter your Mobile No" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <label>Mobile No.</label> -->
                                            <input type="password" name="password" class="form-control login" placeholder="Enter your Password" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <!-- <label>Address</label> -->
                                            <input type="text" name="address" class="form-control login" placeholder="Enter Address" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <label>Pan No.</label> -->
                                            <input type="text" name="pan" class="form-control login" placeholder="Enter your Pan No" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <label>Gst No</label> -->
                                            <input type="text" name="gst" class="form-control login" placeholder="Enter your Gst No" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <label>City</label> -->
                                            <input type="text" name="city" class="form-control login" placeholder="Enter Your City" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <label>Youtube</label> -->
                                            <input type="text" name="youtube" class="form-control login" placeholder="Enter Youtube channel Link" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <label>Instagram</label> -->
                                            <input type="text" name="instagram" class="form-control login" placeholder="Enter Instagram Link" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <!-- <label>Facebook</label> -->
                                            <input type="text" name="facebook" class="form-control login" placeholder="Enter Facebook page Link" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <span class="form-group login-error" style="color:red;font-size:16px"> </span>
                                <span class="form-group login-success" style="color:green;font-size:16px"> </span>
                                <div class="form-group">
                                    <button type="submit" class="login-button" id="signupBtnReferal">
                                        Register <svg class="right" width="30" height="8" viewBox="0 0 30 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z" fill="black" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
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


<script>
    function toggleContent() {
        const content = document.getElementById("content");
        if (content.style.display === "none") {
            content.style.display = "block";
        } else {
            content.style.display = "none";
        }
    }
</script>
@endsection
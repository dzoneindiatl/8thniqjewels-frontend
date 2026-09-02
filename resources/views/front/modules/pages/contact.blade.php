@extends('front.layouts.app')
@section('content')
<main class="main-bg pt-100">
        <!-- cart main wrapper start -->
        <div class="cart-main-wrapper pt-100 pb-100 pt-sm-58 pb-sm-58">
            <div class="container">
                <div class="contact-us">
                    <div class="heading-title mt-20 mb-30">
                        <h3>KEEP IN TOUCH</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="contact-detail">
                                <img src="{{ asset('assets/front/8thniqjewells/assets/img/destination.png') }}" width="50" height="50" />
                                <div class="contact-text">
                                    <h4>Address</h4>
                                    <p>100 S Congress Ave, STE 2000 Austin, TX</p>
                                </div>
                            </div>
                            <div class="contact-detail">
                                <img src="{{ asset('assets/front/8thniqjewells/assets/img/support.png') }}" width="50" height="50" />
                                <div class="contact-text">
                                    <h4>Phone</h4>
                                    <p>+1(858)568-1132</p>
                                </div>
                            </div>
                            <div class="contact-detail">
                                <img src="{{ asset('assets/front/8thniqjewells/assets/img/email.png') }}" width="50"  height="50"/>
                                <div class="contact-text">
                                    <h4>Email</h4>
                                    <p>support@trueview.health</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <form id="contactForm" action="{{ route('contact') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Whoops!</strong> There were some problems with your input.
                                    <ul class="mt-2 mb-0">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control login" placeholder="" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" name="email" class="form-control login" placeholder="" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="number" name="phone" class="form-control login" placeholder="" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Subject</label>
                                        <input type="text" name="subject" class="form-control login" placeholder=""  required />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Massage</label>
                                        <textarea class="form-control login" name="message"  rows="5" required ></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="sqr-btn mt-3" type="submit">
                                            Send Message
                                            <svg width="29" height="8" viewBox="0 0 29 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0.5 3.5C0.223858 3.5 0 3.72386 0 4C0 4.27614 0.223858 4.5 0.5 4.5V3.5ZM28.8536 4.35355C29.0488 4.15829 29.0488 3.84171 28.8536 3.64645L25.6716 0.464466C25.4763 0.269204 25.1597 0.269204 24.9645 0.464466C24.7692 0.659728 24.7692 0.976311 24.9645 1.17157L27.7929 4L24.9645 6.82843C24.7692 7.02369 24.7692 7.34027 24.9645 7.53553C25.1597 7.7308 25.4763 7.7308 25.6716 7.53553L28.8536 4.35355ZM0.5 4.5H28.5V3.5H0.5V4.5Z" fill="black"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart main wrapper end -->
    </main>
    <!-- page main wrapper end -->
    <!-- map area start -->
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d56978.75623519551!2d75.825641!3d26.802643!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396dc98e1f33788b%3A0x9a2730f2d96e4e45!2sPratap%20Nagar%2C%20Jaipur%2C%20Rajasthan!5e0!3m2!1sen!2sin!4v1691234498643!5m2!1sen!2sin" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> 
@endsection
      
@push("scripts")
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    $('#contact').on('submit', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('contact') }}",
            type: "POST",
            data: formData,
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
        window.location.href = response.redirect_url; // back ho jayega
    });

            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let firstError = Object.values(errors)[0][0];

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: firstError,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Something went wrong. Please try again later.',
                    });
                }
            }
        });
    });
});
</script>
@endpush
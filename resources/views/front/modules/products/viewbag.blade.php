@extends('front.layouts.app')
@section('content')

    <!-- CSS Files -->
    <link rel="shortcut icon" href="{{ asset('assets/front/cartdesign/img/favicon.png') }}" type="image/x-icon" />
    <link href="{{ asset('assets/front/cartdesign/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/cartdesign/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/cartdesign/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/cartdesign/css/helper.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/cartdesign/css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/cartdesign/css/style.css') }}" rel="stylesheet">

    <style>
        .main-menu ul li a {
            color: #000;
        }

        .header-main.transparent-menu.sticky {
            background: rgb(218 189 164 / 48%);
        }

            .header-main.transparent-menu.sticky.is-sticky {
                background: #000000cc;
            }

        .sticky.is-sticky .main-menu ul li a {
            color: #fff;
        }

        .header-main.transparent-menu.sticky img.sticky-logo {
            display: none;
        }

        .header-main.transparent-menu.sticky.is-sticky img.sticky-logo {
            display: block;
        }

        .header-main.transparent-menu.sticky.is-sticky img.simple-logo {
            display: none;
        }
    </style>

    <!-- Banner -->
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area mt-100 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <h2 class="text-center">Cart</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- page main wrapper start -->
    <main class="main-bg">
        <!-- cart main wrapper start -->
        <div class="cart-main-wrapper  pb-100 pt-sm-58 pb-sm-58">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 productListContainer" id="productListContainer">
                        <!--  goes to cart itemms dynamic -->
                    </div>
                    
                    <div class="col-lg-4 view-cart-calculation-div">
                        <div class="cart-amount">
                            <div class="cart-calculator-wrapper">
                                <div class="cart-calculate-items">
                                    <h3 class="mb-20">Summary</h3>
                                    <hr />
                                    <div class="table-responsive">
                                        <table width="100%">
                                            <tr>
                                                <td>Sub-Total</td>
                                                <td style="text-align:right;font-weight:bold;" id="totalMrp">₹0</td>
                                            </tr>
                                            <!-- <tr>
                                                <td>Shipping</td>
                                                <td style="text-align: right; font-weight: bold;" id="delivery">₹0</td>
                                            </tr> -->
                                            <tr class="total">
                                                <td>Discount</td>
                                                <td style="text-align: right; font-weight: bold; color: #ffb932; " class="total-amount" id="totalDiscount">₹0</td>
                                            </tr>
                                            <tr class="total">
                                                <td>Coupon Discount</td>
                                                <td style="text-align: right; font-weight: bold; color: #ffb932; " class="total-amount" id="couponDiscount">₹0</td>
                                            </tr>
                                            <!-- <tr class="total">
                                                <td>Taxable Amount</td>
                                                <td style="text-align: right; font-weight: bold; color: #ffb932; " class="total-amount" id="taxableAmount">₹0</td>
                                            </tr>
                                            <tr class="total">
                                                <td>Tax</td>
                                                <td style="text-align: right; font-weight: bold; color: #ffb932; " class="total-amount" id="taxPrice">₹0</td>
                                            </tr> -->
                                            <tr class="total">
                                                <td>Cart total</td>
                                                <td style="text-align: right; font-weight: bold;" class="finalAmount">₹0</td>
                                            </tr>
                                        </table>
                                        <p id="made-to-order-payment-note" class="alert alert-info mt-2 mb-0" style="display:none;" aria-live="polite"></p>
                                    </div>
                                </div>

                            </div>
                            <!-- Cart Update Option -->
                            <div class="cart-update-option d-block d-md-flex justify-content-between">
                                <div class="apply-coupon-wrapper">
                                    <!-- <form action="#" method="post" class=""> -->
                                        <div class="row">
                                            <div class="col-xxl-10 col-lg-12 col-md-9">
                                                <input type="text" id="coupon_code_input" placeholder="Enter Your Coupon or Referal code" class="form-control" required />
                                                <span class="coupon_error" style="color:red;font-size:14px"></span>
                                                <span class="coupon_success" style="color:green;font-size:14px"></span>
                                            </div>
                                            <div class="col-xxl-2 col-lg-12 col-md-3">
                                                <button class="sqr-btn field-btn" id="apply-coupon-btn">Apply</button>
                                            </div>
                                        </div>
                                    <!-- </form> -->
                                </div>
                            </div>
                            <p class="mb-3"><a href="#" data-bs-toggle="modal" data-bs-target="#edit-profile" style="border-bottom:2px dotted #ffb932;">Check coupons</a></p>
                            <a href="{{ route('front-product.checkoutBag') }}" class="sqr-btn d-block">
                                Continue to checkout
                                <svg width="29" height="8" viewBox="0 0 29 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.5 3.5C0.223858 3.5 0 3.72386 0 4C0 4.27614 0.223858 4.5 0.5 4.5V3.5ZM28.8536 4.35355C29.0488 4.15829 29.0488 3.84171 28.8536 3.64645L25.6716 0.464466C25.4763 0.269204 25.1597 0.269204 24.9645 0.464466C24.7692 0.659728 24.7692 0.976311 24.9645 1.17157L27.7929 4L24.9645 6.82843C24.7692 7.02369 24.7692 7.34027 24.9645 7.53553C25.1597 7.7308 25.4763 7.7308 25.6716 7.53553L28.8536 4.35355ZM0.5 4.5H28.5V3.5H0.5V4.5Z" fill="black" />
                                </svg>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart main wrapper end -->
    </main>
    <!-- page main wrapper end -->
@endsection

@push('scripts')
    <script>
        console.log('sixth');
        var notRequiredQtyAjaxClickonQtyBtn = true;
        displayCartItems(notRequiredQtyAjaxClickonQtyBtn);
        $('#apply-coupon-btn').click(function() {
            var couponCode = $('#coupon_code_input').val();
            applyCoupon(couponCode);
        });

        $(document).on('click', '.coupon-apply', function() {
            var couponCode = $(this).data('code');
            applyCoupon(couponCode);
        });

        $(document).on('click', '.checkoutButton', function() {
            if (isLoggedIn) {
                window.location.href = "{{ route('front-product.checkoutBag') }}";
            } else {
                $('.login-sign-modal').modal('show'); // Bootstrap modal
            }
        });

        localStorage.removeItem('coupon_id');
        localStorage.removeItem('coupon_discount');
        getCoupon();

        function applyCoupon(couponCode) {
            if(couponCode==''){
                $(".coupon_error").html('Please enter a valid coupon code');
                setTimeout(() => {
                    $(".coupon_error").html("")
                }, 3000);
            }
            const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
            let subTotal = 0;
            cartItems.forEach(function(item) {
                subTotal += item.price * item.quantity;
            });

            $.post("{{ route('apply.coupon') }}", {
                coupon_code: couponCode,
                cart_total: subTotal,
                cart_items: cartItems,
                _token: $('meta[name="csrf-token"]').attr('content'),
            }, function(response) {
                if (response.status) {
                    $(".coupon_success").html(response.message)
                    setTimeout(() => {
                        $(".coupon_success").html("")
                    }, 3000);
                //    let couponHTML = `<figure>
                //     <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                //     xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="30" x="0" y="0"
                //     viewBox="0 0 512.035 512.035" style="enable-background: new 0 0 512 512;"
                //     xml:space="preserve" class="">
                //     <g>
                //         <path
                //             d="m488.502 256.035 22.464-58.592c2.464-6.464.544-13.792-4.864-18.176l-48.704-39.488-9.856-61.984c-1.088-6.848-6.464-12.192-13.312-13.28l-61.984-9.856L332.79 5.923c-4.352-5.408-11.84-7.328-18.144-4.864l-58.624 22.496L197.43 1.091c-6.496-2.496-13.76-.512-18.144 4.864l-39.488 48.736-61.984 9.856a16.033 16.033 0 0 0-13.28 13.28l-9.856 61.984-48.736 39.488c-5.376 4.352-7.328 11.68-4.864 18.144l22.464 58.592-22.464 58.592c-2.496 6.464-.512 13.792 4.864 18.144l48.736 39.456 9.856 61.984c1.088 6.848 6.432 12.224 13.28 13.312l61.984 9.856 39.488 48.704a15.923 15.923 0 0 0 18.176 4.864l58.56-22.432 58.592 22.464a16.066 16.066 0 0 0 5.728 1.056c4.704 0 9.344-2.08 12.448-5.952l39.456-48.704 61.984-9.856a16.03 16.03 0 0 0 13.312-13.312l9.856-61.984 48.704-39.456c5.408-4.384 7.328-11.68 4.864-18.144l-22.464-58.592z"
                //             style="" fill="#fc2424" data-original="#f44336" class="" opacity="1"></path>
                //         <path
                //             d="M208.022 224.035c-26.464 0-48-21.536-48-48s21.536-48 48-48 48 21.536 48 48-21.536 48-48 48zm0-64c-8.832 0-16 7.168-16 16s7.168 16 16 16 16-7.168 16-16-7.168-16-16-16zM304.022 384.035c-26.464 0-48-21.536-48-48s21.536-48 48-48 48 21.536 48 48-21.536 48-48 48zm0-64c-8.8 0-16 7.2-16 16s7.2 16 16 16 16-7.2 16-16-7.2-16-16-16zM176.022 384.035c-3.232 0-6.464-.96-9.28-2.976-7.2-5.152-8.864-15.136-3.712-22.336l160-224c5.152-7.2 15.136-8.864 22.336-3.712 7.2 5.12 8.832 15.136 3.712 22.304l-160 224c-3.168 4.384-8.064 6.72-13.056 6.72z"
                //             style="" fill="#fafafa" data-original="#fafafa" class=""></path>
                //     </g>
                //     </svg>
                // </figure>
                // <figcaption>
                //     <h4>${response.coupon.coupon_code}<span>Best Offer For You Only</span></h4>
                //     <p>Save ${response.discount} on this order</p>
                // </figcaption>`;
                //         $('.flate-off-l').html(couponHTML);
                        localStorage.setItem('coupon_id', response.coupon.id);
                        localStorage.setItem('coupon_discount', response.discount);
                        localStorage.setItem('discountType', response.discountType);
                        $('#view-coupon').modal('hide');
                        priceCalculation();
                } else {
                    $(".coupon_error").html(response.message)
                    setTimeout(() => {
                        $(".coupon_error").html("")
                    }, 3000);
                }
            });
        }

        // document.getElementById('pincodeInput').addEventListener('input', function() {
        //     // Allow only numbers
        //     this.value = this.value.replace(/\D/g, '');
        //     if (this.value.length === 6) {
        //         calculateDelivery();
        //     }
        // });


        function calculateDelivery() {
            const pincode = document.getElementById('pincodeInput').value.trim();
            const deliveryTimeEl = document.getElementById('delivery_time');

            if (!pincode) {
                deliveryTimeEl.innerHTML = "<span style='color:red;'>Please enter a valid pincode.</span>";
                return;
            }

            $.ajax({
                url: '/check-delevery',
                method: 'POST',
                data: {
                    pincode: pincode
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        deliveryTimeEl.innerHTML = `<span>${data.message}</span>`;
                    } else {
                        deliveryTimeEl.innerHTML = `<span style="color:red;">${response.message}</span>`;
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    deliveryTimeEl.innerHTML =
                        `<span style="color:red;">Invalid Pincode.</span>`;
                }
            });
        }

        // const options = {
        //     weekday: 'short',
        //     day: 'numeric',
        //     month: 'short'
        // };
        // const formattedDate = today.toLocaleDateString('en-US', options);

        //     const svgImage = `<svg
    //     class="me-2"
    //     xmlns="http://www.w3.org/2000/svg"
    //     width="20"
    //     height="20"
    //     viewBox="0 0 512 512"
    //     style="enable-background: new 0 0 512 512;"
    //     xml:space="preserve">
    //     <g>
    //         <path d="M386.689 304.403c-35.587 0-64.538 28.951-64.538 64.538s28.951 64.538 64.538 64.538c35.593 0 64.538-28.951 64.538-64.538s-28.951-64.538-64.538-64.538zm0 96.807c-17.796 0-32.269-14.473-32.269-32.269s14.473-32.269 32.269-32.269 32.269 14.473 32.269 32.269c0 17.797-14.473 32.269-32.269 32.269zM166.185 304.403c-35.587 0-64.538 28.951-64.538 64.538s28.951 64.538 64.538 64.538 64.538-28.951 64.538-64.538-28.951-64.538-64.538-64.538zm0 96.807c-17.796 0-32.269-14.473-32.269-32.269s14.473-32.269 32.269-32.269c17.791 0 32.269 14.473 32.269 32.269 0 17.797-14.473 32.269-32.269 32.269zM430.15 119.675a16.143 16.143 0 0 0-14.419-8.885h-84.975v32.269h75.025l43.934 87.384 28.838-14.5-48.403-96.268z"
    //             fill="#fc2424"></path>
    //         <path d="M216.202 353.345h122.084v32.269H216.202zM117.781 353.345H61.849c-8.912 0-16.134 7.223-16.134 16.134 0 8.912 7.223 16.134 16.134 16.134h55.933c8.912 0 16.134-7.223 16.134-16.134 0-8.912-7.223-16.134-16.135-16.134zM508.612 254.709l-31.736-40.874a16.112 16.112 0 0 0-12.741-6.239H346.891V94.655c0-8.912-7.223-16.134-16.134-16.134H61.849c-8.912 0-16.134 7.223-16.134 16.134s7.223 16.134 16.134 16.134h252.773V223.73c0 8.912 7.223 16.134 16.134 16.134h125.478l23.497 30.268v83.211h-44.639c-8.912 0-16.134 7.223-16.134 16.134 0 8.912 7.223 16.134 16.134 16.134h60.773c8.912 0 16.134-7.223 16.135-16.134V264.605c0-3.582-1.194-7.067-3.388-9.896zM116.706 271.597H42.487c-8.912 0-16.134 7.223-16.134 16.134 0 8.912 7.223 16.134 16.134 16.134h74.218c8.912 0 16.134-7.223 16.134-16.134.001-8.911-7.222-16.134-16.133-16.134zM153.815 208.134H16.134C7.223 208.134 0 215.357 0 224.269s7.223 16.134 16.134 16.134h137.681c8.912 0 16.134-7.223 16.134-16.134s-7.222-16.135-16.134-16.135z"
    //             fill="#fc2424"></path>
    //         <path d="M180.168 144.672H42.487c-8.912 0-16.134 7.223-16.134 16.134 0 8.912 7.223 16.134 16.134 16.134h137.681c8.912 0 16.134-7.223 16.134-16.134.001-8.911-7.222-16.134-16.134-16.134z"
    //             fill="#fc2424"></path>
    //     </g>
    // </svg>`;

        //     // Set the content
        //     deliveryTimeEl.innerHTML = `${svgImage} Get it by <b>9:00 PM on ${formattedDate}</b>`;
        // }


        $(function() { // Best Sellers Products
            const $s = $("#best-seller-slider"),
                c = $s.find(".item").length > 4;
            if ($s.find(".item").length > 4) {
                $('#best-seller').removeClass('custom-seller-slider');
            }

            $s.owlCarousel({
                loop: c,
                nav: c,
                margin: 10,
                autoplay: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: c ? 4 : $s.find(".item").length
                    }
                }
            });
        });
    </script>
@endpush

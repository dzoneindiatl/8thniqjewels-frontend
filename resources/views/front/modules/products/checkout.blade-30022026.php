@extends('front.layouts.app')
@section('content')

@php 
    $minSellingQty = 1;
    $maxSellingQty = 10;
    if(!empty($cartItems[0]['product'])){
        $getMinMaxOrderQty = getMinMaxOrderQty($cartItems[0]['product']->id);
        if(!empty($getMinMaxOrderQty)){
            $minSellingQty = $getMinMaxOrderQty['minSellQty'];
            $maxSellingQty = $getMinMaxOrderQty['maxSellQty'];
        }
    }
@endphp
<script>
    var minSellingQty = '<?php echo $minSellingQty; ?>';
    var maxSellingQty = '<?php echo $maxSellingQty; ?>';
    var getVarientReaminingQty = "{{ route('get-variant-remaining-qty') }}";
</script>

@php
    use App\Models\InvoiceSetting;
   
    $codMaxLimit = 5000;
    $invoiceSetting = InvoiceSetting::where('id', 1)->first();
    if(!empty($invoiceSetting)){
        $codMaxLimit = $invoiceSetting->cash_on_limit;
    }
@endphp
<script>
    var codMaxLimit = '<?php echo $codMaxLimit; ?>';
</script>
<!-- Banner -->
    <section class="banner-section">
        <div class="banner-inner">
            <div class="shape1"><img src="{{ asset('assets/front/img/breadcumb-shape1_1.png') }}" alt="shape" /></div>
            <div class="shape2"><img src="{{ asset('assets/front/img/breadcumb-shape1_2.png') }}" alt="shape" /></div>
            <div class="shape3"><img src="{{ asset('assets/front/img/breadcumb-shape1_3.png') }}" alt="shape" /></div>
            <div class="shape4"><img src="{{ asset('assets/front/img/breadcumb-shape1_4.png') }}" alt="shape" /></div>
            <div class="container">
                <div class="banner-text">
                    <h1>My Address</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">My Address</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <div class="checkout-page">
        <div class="container">

            <div class="row Delivery-sec">
                <div class="col-md-6">
                    <div class="checkout-left">
                        <div id="checkout-cart-container">

                        </div>
                        <!-- <div class="apply-field mt-4 mb-4">
                            <input type="text" name="" placeholder="Discount code or gift card" class="form-control" />
                            <button class="field-btn">Apply</button>
                        </div> -->
                        <div class="total-bill-sec">
                            <ul class="total-list">
                                <li>
                                    <span>Total MRP</span>
                                    <p id="totalMrp"> ₹0</p>
                                </li>
                                <li>
                                    <span>Discount </span>
                                    <p class="text-green" id="totalDiscount"><del>₹0.00</del></p>
                                </li>
                                <li>
                                    <span>Subtotal • <b id="total-items"></b> items</span>
                                    <p id="subTotal">₹0.00</p>
                                </li>
                                <li>
                                    <span>Coupon Discount </span>
                                    <p class="text-success" id="couponDiscount">₹0</p>
                                </li>
                                <li>
                                    <span>Grand Total </span>
                                    <p class="text-green" id="grandTotal">₹0.00</p>
                                </li>
                                <li>
                                    <span>Taxable Amount </span>
                                    <p class="text-green" id="taxableAmount">₹0.00</p>
                                </li>
                                <li>
                                    <span>Total GST(Tax) </span>
                                    <p class="text-success" id="taxPrice">₹0.00</p>
                                </li>
                                <li>
                                    <span>Shipping Charge </span>
                                    <p class="text-success" id="totalShippingCharge">₹0.00</p>
                                </li>
                                <li>
                                    <hr />
                                </li>
                                <li>
                                    <span>
                                        <b class="text-uppercase">Total Payable</b>(Tax Included)<br />
                                    </span>
                                    <p><b class="finalAmount">₹0</b></p>
                                </li>
                            </ul>
                        </div>
                        <!--<button class="w-100 full-btn">Pay Now</button>-->
                        <button class="w-100 full-btn" id="pay_now">Pay Now</button>
                        <button class="w-100 full-btn" id="shoopping_continue" style="display:none"><a href="{{ url('/') }}" style="color:#fff">Add to Cart Any Item</a></button>
                        <span class="pat_now_error_msg" style="color: red;fint-size:14px"></span>
                        <!--<button type="button" class="btn btn-primary py-3 btn-lg w-100" name="checkout_place_order" id="place_order">Place your order</button>-->
                    </div>
                </div>
                @php 
                //prx($userBillingAddress);
                @endphp
                <div class="col-md-6">
                    <div class="checkout-right">
                        <div class="checksection-box">
                            <div id="main_billing" {!! (!empty($userBillingAddress[0])) ? 'style="display: none"':''; !!} >
                                <div class="checksection-box-head">
                                    <h4>Billing Address</h4>
                                </div>

                                @php
                                    $fullname = trim(Auth::guard('customer')->user()->name);
                                    $parts = explode(' ', trim($fullname));
                                    $firstName = $parts[0];
                                    $lastName = end($parts);
                                @endphp

                                <form method="post" id="addressForm">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="address_type" value="billing">
                                    <div class="row address-form">
                                        <div class="col-md-12 mb-3">
                                            <select class="form-select selectcommon" name="country" id="country"
                                                aria-label="Default select example">
                                                <option selected>Country/Region</option>
                                                @if (isset($countries))
                                                    @foreach ($countries as $key => $country)
                                                        <option value="{{ $key }}">{{ $country }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="firstname"
                                                    placeholder="First name" value="{{ $firstName ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="lastname"
                                                    placeholder="Last name" value="{{ $lastName ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="address" class="form-control"
                                                    placeholder="Addess" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="addressSecond" class="form-control"
                                                    placeholder="Apartment, suite, etc. (optional)" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <select class="form-select selectcommon" id="state" name="state"
                                                aria-label="Default select example">
                                                <option selected>State</option>

                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <select class="form-select selectcommon" id="city" name="city"
                                                aria-label="Default select example">
                                                <option selected>City</option>

                                            </select>
                                            <!--<div class="form-group">-->
                                            <!--    <input type="text" name="city" class="form-control" placeholder="City" />-->
                                            <!--</div>-->
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="pinCode" class="form-control"
                                                    placeholder="PIN code" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" name="phone" class="form-control"
                                                    placeholder="Phone"
                                                    value="{{ Auth::guard('customer')->user()->phone_number }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="inner_check_box">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="address_place_type" id="home" value="1"
                                                        checked />
                                                    <label class="form-check-label" for="home">
                                                        <div class="sp-content">
                                                            <h6>Home</h6>
                                                        </div>
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="address_place_type" id="office" value="2" />
                                                    <label class="form-check-label" for="office">
                                                        <div class="sp-content">
                                                            <h6>Office</h6>
                                                        </div>
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="address_place_type" id="Others" value="3" />
                                                    <label class="form-check-label" for="Others">
                                                        <div class="sp-content">
                                                            <h6>Others</h6>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-button" style="margin-top: 15px;">
                                                <button type="button" id="save_billing_address"
                                                    class="btn btn-primary">Save</button>
                                                <button type="button"
                                                    class="btn btn-secondary btn_cancel_txt billing_cancel">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="checksection-box col-md-12 mt-4">
                                <div class="select-payment-mode-sec">
                                    <h4>Select Payment Mode</h4>
                                    <ul class="payment-mode-list">

                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input wallet-or-online" type="checkbox"
                                                    name="wallet_online" id="flexRadioDefault11" value="wallet"
                                                    {{ ($userwallet->wallet_avl_balance ?? 0) <= 0 ? 'disabled' : '' }} />

                                                <label class="form-check-label" for="flexRadioDefault11"
                                                    style="{{ ($userwallet->wallet_avl_balance ?? 0) <= 0 ? 'opacity:0.6; cursor:not-allowed;' : '' }}">
                                                    <div class="sp-content">
                                                        <h6>Use Vasvi Wallet</h6>
                                                        <p>Available Wallet Balanace</p>
                                                    </div>
                                                </label>

                                                <span class="tag-label" id="wallet_amount">
                                                    ₹{{ number_format($userwallet->wallet_avl_balance ?? 0, 2) }}
                                                </span>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="form-check">
                                                <input class="form-check-input wallet-or-online" type="radio"
                                                    name="pay_online" value="razorpay" id="flexRadioDefault12" />
                                                <label class="form-check-label" for="flexRadioDefault12">Pay
                                                    Online</label>
                                                <span class="tag-label">Free</span>
                                            </div>
                                        </li>
                                        <li>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="pay_online"
                                                    value="cod" id="flexRadioDefault13" />
                                                <label class="form-check-label" for="flexRadioDefault13">Cash on
                                                    Delivery ( Not available for this order)
                                                </label>
                                                <!-- <span class="tag-label cod_value">₹{{ $invoiceSetting->cash_on_limit }}</span> -->
                                                <!--<span class="tag-label cod_value">₹{{ $invoiceSetting->cash_on_limit }}</span>-->

                                                <p class="limit">  <i class="fa fa-info-circle" aria-hidden="true"></i>   Cash on Delivery available for orders up to
                                                    ₹{{ $invoiceSetting->cash_on_limit }}</p>
                                                <input type="hidden"id="cash_on"
                                                    value="{{ $invoiceSetting->cash_on_limit }}">
                                            </div>
                                        </li>
                                        <li>
                                            <span class="text-danger" id="paymentError" style="display:none">Please select payment method</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="flate-off">
                                <div class="apply-field mb-3">
                                    <input type="text" id="coupon_code_input" placeholder="Enter your coupon code"
                                        class="form-control">
                                    <button class="field-btn" id="apply-coupon-btn">Apply</button>
                                </div>
                            </div>

                            <div class="col-md-12 select-delivery-box mt-4 mb-2">
                                <div class="select-delivery-box-inner">
                                    @if (isset($userBillingAddress[0]))
                                        <h5>Select Billing Address</h5>
                                        @foreach ($userBillingAddress as $key => $userAdd)
                                            <div class="form-check">
                                                <input class="form-check-input select_billing_address" type="radio"
                                                    name="address"
                                                    value="{{ $userAdd->id }}"{{ $key == 0 ? 'checked' : '' }} />
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    <div class="select-content">
                                                        <span class="tagcheck">
                                                            @if ($userAdd->address_type == 1)
                                                                Home
                                                            @elseif($userAdd->address_type == 2)
                                                                Office
                                                            @else
                                                                Others
                                                            @endif
                                                        </span>
                                                        <h6>{{ $userAdd->name }}</h6>
                                                        <p>{{ $userAdd->address }} {{ $userAdd->landmark }},
                                                            {{ $userAdd->city->name ?? '' }}, {{ $userAdd->state->name }},
                                                            {{ $userAdd->country->name }} - {{ $userAdd->postal_code }}
                                                        </p>
                                                        <p>Phone: +91{{ $userAdd->phone_number }}</p>
                                                    </div>
                                                </label>
                                                <a href="javascript:void(0)" data-id="{{ $userAdd->id }}"
                                                    data-bs-toggle="modal" data-bs-target="#edit-address"
                                                    class="form-link edit-address-btn">Edit</a>
                                            </div>
                                        @endforeach
                                    @endif
                                    <div id="message_for_billing_address"></div>
                                    <a class="btn btn-primary mt-2" {!! (empty($userBillingAddress[0])) ? 'style="display: none"':''; !!} id="add_new_billing_address">Add New Billing
                                        Address</a>
                                </div>
                            </div>


                            <div id="main_shipping" style="display:none;">
                                <div class="checksection-box-head">
                                    <h4>Shipping Addrress</h4>
                                </div>

                                <form method="post" id="shippingAddressForm">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="address_type" value="shipping">
                                    <div class="row address-form">
                                        <div class="col-md-12 mb-3">
                                            <select class="form-select selectcommon" name="country" id="shipping_country"
                                                aria-label="Default select example">
                                                <option selected>Country/Region</option>
                                                @if (isset($countries))
                                                    @foreach ($countries as $key => $country)
                                                        <option value="{{ $key }}">{{ $country }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="firstname"
                                                    placeholder="First name" value="{{ $firstName ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="lastname"
                                                    placeholder="Last name" value="{{ $lastName ?? '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="address" class="form-control"
                                                    placeholder="Addess" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="addressSecond" class="form-control"
                                                    placeholder="Apartment, suite, etc. (optional)" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <select class="form-select selectcommon" id="shipping_state" name="state"
                                                aria-label="Default select example">
                                                <option selected>State</option>

                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <select class="form-select selectcommon" id="shipping_city" name="city"
                                                aria-label="Default select example">
                                                <option selected>City</option>

                                            </select>

                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <input type="text" name="pinCode" class="form-control"
                                                    placeholder="PIN code" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" name="phone" class="form-control"
                                                    placeholder="Phone"
                                                    value="{{ Auth::guard('customer')->user()->phone_number }}" />
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="inner_check_box">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="address_place_type" id="home" value="1"
                                                        checked />
                                                    <label class="form-check-label" for="home">
                                                        <div class="sp-content">
                                                            <h6>Home</h6>
                                                        </div>
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="address_place_type" id="office" value="2" />
                                                    <label class="form-check-label" for="office">
                                                        <div class="sp-content">
                                                            <h6>Office</h6>
                                                        </div>
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="address_place_type" id="Others" value="3" />
                                                    <label class="form-check-label" for="Others">
                                                        <div class="sp-content">
                                                            <h6>Others</h6>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-button">
                                                <button type="button" id="save_shipping_address"
                                                    class="btn btn-primary">Save</button>
                                                <button type="button"
                                                    class="btn btn-secondary btn_cancel_txt shipping_cancel">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-12 select-delivery-box mt-4 mb-2">
                                <div class="select-delivery-box-inner">
                                    @if (isset($usershippingAddress[0]))
                                        <h5>Select Shipping Addrress</h5>
                                        @foreach ($usershippingAddress as $userShipAdd)
                                            <div class="form-check">
                                                <input class="form-check-input select_shipping_address" type="radio"
                                                    name="shipaddress" value="{{ $userShipAdd->id }}" />
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    <div class="select-content">
                                                        <span class="tagcheck">
                                                            @if ($userShipAdd->address_type == 1)
                                                                Home
                                                            @elseif($userShipAdd->address_type == 2)
                                                                Office
                                                            @else
                                                                Others
                                                            @endif
                                                        </span>
                                                        <h6>{{ $userShipAdd->name }}</h6>
                                                        <p>{{ $userShipAdd->address }} {{ $userShipAdd->landmark }},
                                                            {{ $userShipAdd->city->name ?? '' }},
                                                            {{ $userShipAdd->state->name }},
                                                            {{ $userShipAdd->country->name }} -
                                                            {{ $userShipAdd->postal_code }}</p>
                                                        <p>Phone: +91{{ $userShipAdd->phone_number }}</p>
                                                    </div>
                                                </label>
                                                <!--<span class="pencil-icon" onclick="openPopup(32)"> -->
                                                <!--    <i class="fa fa-pencil"></i>-->
                                                <!--</span>-->
                                                <a href="javascript:void(0)" data-id="{{ $userShipAdd->id }}"
                                                    data-bs-toggle="modal" data-bs-target="#edit-address"
                                                    class="form-link edit-address-btn">Edit</a>
                                            </div>
                                        @endforeach
                                    @endif

                                    <div class="form-group mb-3 col-sm-12 col-12 has-value">
                                        <input class="form-check-input" type="checkbox" value="0"
                                            id="same_as_billing" checked name="same_as_billing"
                                            onclick="toggleShippingAddressForm()">
                                        <label class="form-check-label" for="same_as_billing">
                                            Same as billing address
                                        </label>
                                    </div>
                                    <!-- <a class="btn btn-primary mt-2 shipping-address" id="add_new_shipping_address" style="none">Add New
                                        Shipping Addrress</a> -->
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked"
                                        checked="" />
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Save this information for next time
                                    </label>
                                </div>
                            </div>
                            <div class="toggle-box-check">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" value="" id="news-offer"
                                        checked="" />
                                    <label class="form-check-label" for="news-offer">
                                        Text me with news and offers
                                    </label>
                                </div>
                                <div class="show-toggle-check-news pt-2" style="display: none;">
                                    <div class="form-group">
                                        <input type="" name="" class="form-control"
                                            placeholder="Mobile phone number" />
                                    </div>
                                    <p>
                                        By signing up via text, you agree to receive recurring automated marketing messages,
                                        including cart reminders, at the phone number provided. Consent is not a condition
                                        of purchase. Reply STOP
                                        to unsubscribe. Reply HELP for help. Message frequency varies. Msg & data rates may
                                        apply. View our Privacy policy and Terms of service.
                                    </p>
                                </div>
                            </div>
                            <div class="toggle-box-check">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" value="" id="Gstin-detail"
                                        checked="" />
                                    <label class="form-check-label" for="Gstin-detail">
                                        Use GSTIN details for this order
                                    </label>
                                </div>
                                <div class="show-toggle-check pt-3" style="display: none;">
                                    <div class="form-group GST-group">
                                        <input type="text" name="" class="form-control mb-3"
                                            placeholder="GST Business Name" />
                                        <input type="text" name="" class="form-control"
                                            placeholder="GST Number" />
                                    </div>
                                </div>
                            </div>

                            

                            <div class="checksection-box col-md-12 mt-4">
                                <div class="payment-mode-sec">
                                    <div class="payment-mode-head mb-3">
                                        <h4>Payment</h4>
                                        <span>All transactions are secure and encrypted.</span>
                                    </div>
                                    <ul class="Payment-mode-list">
                                        <li>
                                            <h4>Razorpay Secure (UPI, Cards, Wallets, NetBanking)</h4>
                                            <ul class="payment-info">
                                                <li>
                                                    <a><img src="{{ asset('assets/front/img/upi-img-1.svg') }}" /></a>
                                                </li>
                                                <li>
                                                    <a><img src="{{ asset('assets/front/img/upi-img-2.svg') }}" /></a>
                                                </li>
                                                <li>
                                                    <a><img src="{{ asset('assets/front/img/upi-img-3.svg') }}" /></a>
                                                </li>
                                                <li>
                                                    <a><img src="{{ asset('assets/front/img/upi-img-4.svg') }}" /></a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <h4>Phone Pay Secure (UPI, Cards, Wallets, NetBanking)</h4>
                                            <ul class="payment-info">
                                                <li>
                                                    <a><img src="{{ asset('assets/front/img/upi-img-1.svg') }}" /></a>
                                                </li>
                                                <li>
                                                    <a><img src="{{ asset('assets/front/img/upi-img-2.svg') }}" /></a>
                                                </li>
                                                <li>
                                                    <a><img src="{{ asset('assets/front/img/upi-img-3.svg') }}" /></a>
                                                </li>
                                                <li>
                                                    <a><img src="{{ asset('assets/front/img/upi-img-4.svg') }}" /></a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <h4>Paypal Secure (UPI, Cards, Wallets, NetBanking)</h4>
                                            <ul class="payment-info">
                                                <li>
                                                    <a><img src="{{ asset('assets/front/img/upi-img-1.svg') }}" /></a>
                                                </li>
                                                <li>
                                                    <a><img src="{{ asset('assets/front/img/upi-img-2.svg') }}" /></a>
                                                </li>
                                                <li>
                                                    <a><img src="{{ asset('assets/front/img/upi-img-3.svg') }}" /></a>
                                                </li>
                                                <li>
                                                    <a><img src="{{ asset('assets/front/img/upi-img-4.svg') }}" /></a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Model for Edit address-->
    <div class="modal fade common-modal" id="edit-address" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 id="staticBackdropLabel">Edit Address</h1>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
                <form method="post" id="editAddressForm">
                    <div class="modal-body">
                        <div class="row address-form">
                            <div class="col-md-12 mb-3">
                                <select class="form-select selectcommon" name="country" id="country"
                                    aria-label="Default select example">
                                    <option>Country/Region</option>
                                    <option value="101" selected="">India</option>
                                </select>
                            </div>
                            <input type="hidden" name="addressId" class="addressId" value="">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="firstname"
                                        placeholder="First name" />
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="lastname"
                                        placeholder="Last name" />
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <input type="text" name="address" class="form-control" placeholder="Addess" />
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <input type="text" name="addressSecond" class="form-control"
                                        placeholder="Apartment, suite, etc. (optional)" />
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <!--<select class="form-select selectcommon editState" name="state" aria-label="Default select example">-->
                                <select class="form-select selectcommon editState" id="state" name="state">
                                    <option>State</option>
                                    @if (isset($states))
                                        @foreach ($states as $key => $state)
                                            <option value="{{ $key }}">{{ $state }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <select class="form-select selectcommon editCity" name="city">
                                        <option>City</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <input type="text" name="pinCode" class="form-control" placeholder="PIN code" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control" placeholder="Phone"
                                        value="{{ Auth::guard('customer')->user()->phone_number }}" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="inner_check_box">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="address_place_type"
                                            id="home" value="1">
                                        <label class="form-check-label" for="home">
                                            <div class="sp-content">
                                                <h6>Home</h6>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="address_place_type"
                                            id="office" value="2">
                                        <label class="form-check-label" for="office">
                                            <div class="sp-content">
                                                <h6>Office</h6>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="address_place_type"
                                            id="Others" value="3">
                                        <label class="form-check-label" for="Others">
                                            <div class="sp-content">
                                                <h6>Others</h6>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4 text-center">
                                <button type="submit" class="btn btn-primary" id="updateAddressBtn">Save</button>
                                <button type="button" class="btn btn-secondary ms-2"
                                    id="cancelAddressBtn">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Confirmation for remove Out of Stock product -->
    <a href="javascript:void(0)"  id="outOfStockAlert" data-bs-toggle="modal" data-bs-target="#out-of-stock-product" class="form-link">outOfStockAlert</a>
    <div class="modal fade common-modal" id="out-of-stock-product" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 id="staticBackdropLabel">Confiramtion for remove "Out Of Stock" product from order</h1>
                 </div>
                <div class="modal-body">
                    <div class="row address-form">
                        <div class="col-md-12 mb-3">
                            We are soory for now, You have some out of stock product in cart. You can buy these product when will be in stock.
                        </div>
                        <div class="col-md-12 mt-4 text-center">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"> Ok, Continue</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var RAZORPAYKEY = "{{ env('RAZORPAY_MODE') == 'test' ? env('RAZORPAY_TEST_KEY') : env('RAZORPAY_LIVE_KEY') }}";
    </script>
    <script src="{{ asset('assets/front/js/checkouts.js') }}"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        var USERID = "{{ Auth::guard('customer')->check() ? Auth::guard('customer')->user()->id : '' }}";
        var USERNAME = "{{ Auth::guard('customer')->check() ? Auth::guard('customer')->user()->name : '' }}";
        var USEREMAIL = "{{ Auth::guard('customer')->check() ? Auth::guard('customer')->user()->email : '' }}";
        var USERPHONE =
            "{{ Auth::guard('customer')->check() ? Auth::guard('customer')->user()->phone_number : '9876543210' }}";

        localStorage.setItem('uw_amount', '<?php  echo number_format($userwallet->wallet_avl_balance ?? 0, 2);  ?>');  // user wallet amount
    </script>

<script>
    $( document ).ready(function() {
        var couponDiscount =  $('#couponDiscount').text().replace("-₹", "");
        if(parseFloat(couponDiscount) > 0){
            $('.flate-off').hide();
        }
    });

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

    // localStorage.removeItem('coupon_id');
    // localStorage.removeItem('coupon_discount');
    getCoupon();

    function applyCoupon(couponCode) {
        var couponDiscount =  $('#couponDiscount').text().replace("-₹", "");
        console.log(' discoutn  : ', couponDiscount);
        if(parseFloat(couponDiscount) > 0){
            showFlashMessage("You have already applied", 'error');
            return false;
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
                showFlashMessage(response.message);
                let couponHTML = `<figure>
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="30" x="0" y="0"
                viewBox="0 0 512.035 512.035" style="enable-background: new 0 0 512 512;"
                xml:space="preserve" class="">
                <g>
                    <path
                        d="m488.502 256.035 22.464-58.592c2.464-6.464.544-13.792-4.864-18.176l-48.704-39.488-9.856-61.984c-1.088-6.848-6.464-12.192-13.312-13.28l-61.984-9.856L332.79 5.923c-4.352-5.408-11.84-7.328-18.144-4.864l-58.624 22.496L197.43 1.091c-6.496-2.496-13.76-.512-18.144 4.864l-39.488 48.736-61.984 9.856a16.033 16.033 0 0 0-13.28 13.28l-9.856 61.984-48.736 39.488c-5.376 4.352-7.328 11.68-4.864 18.144l22.464 58.592-22.464 58.592c-2.496 6.464-.512 13.792 4.864 18.144l48.736 39.456 9.856 61.984c1.088 6.848 6.432 12.224 13.28 13.312l61.984 9.856 39.488 48.704a15.923 15.923 0 0 0 18.176 4.864l58.56-22.432 58.592 22.464a16.066 16.066 0 0 0 5.728 1.056c4.704 0 9.344-2.08 12.448-5.952l39.456-48.704 61.984-9.856a16.03 16.03 0 0 0 13.312-13.312l9.856-61.984 48.704-39.456c5.408-4.384 7.328-11.68 4.864-18.144l-22.464-58.592z"
                        style="" fill="#fc2424" data-original="#f44336" class="" opacity="1"></path>
                    <path
                        d="M208.022 224.035c-26.464 0-48-21.536-48-48s21.536-48 48-48 48 21.536 48 48-21.536 48-48 48zm0-64c-8.832 0-16 7.168-16 16s7.168 16 16 16 16-7.168 16-16-7.168-16-16-16zM304.022 384.035c-26.464 0-48-21.536-48-48s21.536-48 48-48 48 21.536 48 48-21.536 48-48 48zm0-64c-8.8 0-16 7.2-16 16s7.2 16 16 16 16-7.2 16-16-7.2-16-16-16zM176.022 384.035c-3.232 0-6.464-.96-9.28-2.976-7.2-5.152-8.864-15.136-3.712-22.336l160-224c5.152-7.2 15.136-8.864 22.336-3.712 7.2 5.12 8.832 15.136 3.712 22.304l-160 224c-3.168 4.384-8.064 6.72-13.056 6.72z"
                        style="" fill="#fafafa" data-original="#fafafa" class=""></path>
                        </g>
                    </svg>
                </figure>
                <figcaption>
                    <h4>${response.coupon.coupon_code}<span>Best Offer For You Only</span></h4>
                    <p>Save ${response.discount} on this order</p>
                </figcaption>`;
                $('.flate-off-l').html(couponHTML);
                localStorage.setItem('coupon_id', response.coupon.id);
                localStorage.setItem('coupon_discount', response.discount);
                $('#view-coupon').modal('hide');
                priceCalculation();
            } else {
                showFlashMessage(response.message, 'error');
                $(".coupon_error").html(response.message)
                setTimeout(() => {
                    $(".coupon_error").html("")
                }, 3000);
            }
        });
    }

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
</script>
@endpush

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
    $invoiceSetting = InvoiceSetting::where('prefix', 'site')->first();
    if(!empty($invoiceSetting)){
        $codMaxLimit = $invoiceSetting->cash_on_limit;
    }   
@endphp
<script>
    var codMaxLimit = '<?php echo $codMaxLimit; ?>';
</script>

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

    <!-- breadcrumb area start -->
    <div class="breadcrumb-area mt-100 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <h2 class="text-center">Checkout</h2>
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
                    <div class="col-lg-8">
                        <div class="checkout-details">
                            <div class="accordion" id="general-question">
                                <div class="card mb-3">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <button class="accordio-heading" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Shipping & Billing Address Details
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-bs-parent="#general-question" style="">
                                        <div class="card-body">
                                            @if(!empty($userBillingAddress))
                                            <div class="row">
                                                <h5>Select Billing Address</h5>
                                                @foreach($userBillingAddress as $address)
                                                <div class="col-md-4">
                                                    <p>
                                                    <b>Name</b> : {{ @$address->name }}  &nbsp;&nbsp; 
                                                    <!-- <input class="form-check-input billing_address" type="radio" name="billing_address" id="address_{{ $address->id }}" value="{{ $address->id }}" {{ $address->is_primary == 1 ? 'checked=checked' : '' }}> -->
                                                    <input class="form-check-input billing_address" type="radio" name="billing_address" id="address_{{ $address->id }}" value="{{ $address->id }}" >
                                                    </br>
                                                    <b>Email</b> : {{ @$address->email }} </br>
                                                    <b>Phone</b> : {{ @$address->phone_number }} </br>
                                                    <b>Address</b> : {{ @$address->address }} , {{ @$address->landmark }} , {{ @$address->city->name }} ,{{ @$address->state->name }} ,{{ @$address->country->name }},{{  @$address->postal_code }}.
                                                    </p>
                                                </div> 
                                                @endforeach   
                                            </div>
                                            @endif
                                            <hr>

                                            <div class="form-group col-md-12" >
                                                <input class="form-check-input" type="checkbox" value="1" id="same_as_billing" name="same_as_billing" onclick="toggleSamasBilling()" checked="checked">
                                                <label class="form-check-label" for="same_as_billing">Shipping Same as billing address</label>
                                            </div>
                                            <hr>
                                            @if(!empty($usershippingAddress))
                                            <div class="row" id="main_shipping" style="display:none">
                                                <h5>Select Shipping Address</h5>
                                                @foreach($usershippingAddress as $address)
                                                <div class="col-md-4">
                                                    <p>
                                                    <b>Name</b> : {{ @$address->name }}  &nbsp;&nbsp; <input class="form-check-input shipping_address" type="radio" name="shipping_address" value="{{ $address->id }}" > </br>
                                                    <b>Email</b> : {{ @$address->email }} </br>
                                                    <b>Phone</b> : {{ @$address->phone_number }} </br>
                                                    <b>Address</b> : {{ @$address->address }} , {{ @$address->landmark }} , {{ @$address->city->name }} ,{{ @$address->state->name }} ,{{ @$address->country->name }},{{  @$address->postal_code }}.
                                                    </p>
                                                </div> 
                                                @endforeach 
                                                <hr>   
                                            </div>
                                            @endif
                                            
                                            <div class="col-md-12">
                                                <div class="form-group" style="text-align:left;">
                                                    <a href="javascript:void('0')" class="sqr-btn mt-3" id="AddNewAddresFromBtn" onclick="OpenAddressFrom()">
                                                        Add New Address
                                                        <svg width="29" height="8" viewBox="0 0 29 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M0.5 3.5C0.223858 3.5 0 3.72386 0 4C0 4.27614 0.223858 4.5 0.5 4.5V3.5ZM28.8536 4.35355C29.0488 4.15829 29.0488 3.84171 28.8536 3.64645L25.6716 0.464466C25.4763 0.269204 25.1597 0.269204 24.9645 0.464466C24.7692 0.659728 24.7692 0.976311 24.9645 1.17157L27.7929 4L24.9645 6.82843C24.7692 7.02369 24.7692 7.34027 24.9645 7.53553C25.1597 7.7308 25.4763 7.7308 25.6716 7.53553L28.8536 4.35355ZM0.5 4.5H28.5V3.5H0.5V4.5Z" fill="black"></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- <div class="address-details" id="addAddressFrom" style="display:none">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Full Name</label>
                                                            <input type="text" class="form-control login" id="full-name" 
                                                            value="{{ @$userPrimaryAddress->name }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Phone number</label>
                                                            <input type="text" class="form-control login" id="full-name" value="{{ @$userPrimaryAddress->phone_number }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Address line 1</label>
                                                            <input type="text" class="form-control login" id="full-name" value="{{ @$userPrimaryAddress->address }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Landmark</label>
                                                            <input type="text" class="form-control login" id="full-name" value="{{ @$userPrimaryAddress->landmark }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Postal code</label>
                                                            <input type="text" class="form-control login" id="full-name" value="{{ @$userPrimaryAddress->postal_code }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>City</label>
                                                            <input type="text" class="form-control login" id="full-name" value="{{ @$userPrimaryAddress->city->name }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>State</label>
                                                            <input type="text" class="form-control login" id="full-name" value="{{ @$userPrimaryAddress->state->name }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Country</label>
                                                            <input type="text" class="form-control login" id="full-name" value="{{ @$userPrimaryAddress->country->name }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group" style="text-align:right;">
                                                            <a href="#" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-controls="collapseTwo" aria-expanded="false" class="sqr-btn mt-3">
                                                                Continue
                                                                <svg width="29" height="8" viewBox="0 0 29 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M0.5 3.5C0.223858 3.5 0 3.72386 0 4C0 4.27614 0.223858 4.5 0.5 4.5V3.5ZM28.8536 4.35355C29.0488 4.15829 29.0488 3.84171 28.8536 3.64645L25.6716 0.464466C25.4763 0.269204 25.1597 0.269204 24.9645 0.464466C24.7692 0.659728 24.7692 0.976311 24.9645 1.17157L27.7929 4L24.9645 6.82843C24.7692 7.02369 24.7692 7.34027 24.9645 7.53553C25.1597 7.7308 25.4763 7.7308 25.6716 7.53553L28.8536 4.35355ZM0.5 4.5H28.5V3.5H0.5V4.5Z" fill="black"></path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->

                                            <div class="address-details" id="addAddressFromDiv" style="display:none">
                                                <form id="addAddressFrom" autocomplete="off">
                                                @csrf
                                                    <div class="edit-account">
                                                        <div class="row mt-30">
                                                            <div class="col-lg-12 col-md-6">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="address_id" id="address_id" value=''/>
                                                                    <label>Address</label>
                                                                    <input type="text" name="address" id="address" class="form-control login" autocomplete="off" required/>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-6">
                                                                <div class="form-group">
                                                                    <label>Landmark</label>
                                                                    <input type="text" name="landmark" id="landmark" class="form-control login" placeorder="Apartment, Suite,Temple etc. (optional)"  autocomplete="off"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Name</label>
                                                                    <input type="text" name="name" id="name" class="form-control login edit_name" autocomplete="off" required/>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="form-group">
                                                                    <label>Phone</label>
                                                                    <input type="text" name="phone_number" id="phone_number" class="form-control login  edit_phone_number" autocomplete="off" />
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="">
                                                                    <label>Country</label>
                                                                    <select class="" name="country_id" id="country" autocomplete="off">
                                                                        <option value="" selected>Country/Region</option>
                                                                        <option value="101">India</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>State</label>
                                                                    <select class="city_dropdown" name="state_id" id="state" autocomplete="off">
                                                                        <option value="">Select State</option>
                                                                        @if(!empty($states))
                                                                            @foreach($states as $id => $state)
                                                                                <option value="{{ @$id }}">{{ @$state }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>City</label>
                                                                    <select class="city" name="city_id" id="city" autocomplete="off">
                                                                        <option value="">Select city</option>
                                                                        <option value="21">Jaipur</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Postal Code</label>
                                                                    <input type="text" name="postal_code" id="postal_code" class="form-control login" autocomplete="off" required/>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <label>Address Type</label>
                                                                    <select class="" name="type" id="type" autocomplete="off">
                                                                        <option value="">Select Address Type</option>
                                                                        <option value="shipping">Shipping Addrress</option>
                                                                        <option value="billing">Billing Address</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-12">
                                                                <div class="form-group">
                                                                    <div class="inner_check_box">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input address_type_home" type="radio" name="address_type" id="home" value="1" >
                                                                            <label class="form-check-label" for="home">
                                                                                <div class="sp-content">
                                                                                    <h6>Home</h6>
                                                                                </div>
                                                                            </label>
                                                                        </div>

                                                                        <div class="form-check">
                                                                            <input class="form-check-input address_type_office" type="radio" name="address_type" id="office" value="2">
                                                                            <label class="form-check-label" for="office">
                                                                                <div class="sp-content">
                                                                                    <h6>Office</h6>
                                                                                </div>
                                                                            </label>
                                                                        </div>

                                                                        <div class="form-check">
                                                                            <input class="form-check-input address_type_other" type="radio" name="address_type" id="Others" value="3">
                                                                            <label class="form-check-label" for="Others">
                                                                                <div class="sp-content">
                                                                                    <h6>Others</h6>
                                                                                </div>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <span class="add-adddress-error" style="color:red;font-size:16px"></span>
                                                            <span class="add-adddress-success" style="color:green;font-size:16px"></span>
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="form-group">
                                                                    <a href="javascript:void('0')" class="sqr-btn mt-3 d-block" id="addAddressBtn">
                                                                        Save
                                                                        <svg width="30" height="8" viewBox="0 0 30 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <path d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z" fill="black" />
                                                                        </svg>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                <div class="card mb-3">
                                    <div class="card-header" id="headingTwo">
                                        <h5 class="mb-0">
                                            <button class="accordio-heading collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-controls="collapseTwo" aria-expanded="false">
                                                Payment 
                                            </button>
                                        </h5>
                                    </div>

                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#general-question">
                                        <div class="card-body">
                                            <div class="address-details">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="order-payment-method">
                                                            <div class="single-payment-method show codPaymentDiv">
                                                                <div class="payment-method-name">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="cash" name="paymentmethod1" value="cod" class="custom-control-input cash payment_type" >
                                                                        <label class="custom-control-label" for="cash">Cash On Delivery</label>
                                                                    </div>
                                                                </div>
                                                                <div class="payment-method-details" data-method="cash" style="display: block;">
                                                                    <p>Pay with cash upon delivery.</p>
                                                                </div>
                                                            </div>

                                                            <div class="single-payment-method show">
                                                                <div class="payment-method-name">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="wallet" name="paymentmethod1" value="wallet" class="custom-control-input wallet walletPayment">
                                                                        <label class="custom-control-label" for="wallet">Wallet</label>
                                                                    </div>
                                                                </div>
                                                                <div class="payment-method-details" data-method="wallet" style="display: block;">
                                                                    <p>You can use your wallet amount</p>
                                                                </div>
                                                            </div>

                                                            <div class="single-payment-method">
                                                                <div class="payment-method-name">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="phonepay" name="paymentmethod2" value="phonepay" class="custom-control-input phonepay payment_type">
                                                                        <label class="custom-control-label" for="phonepay">Phone Pay</label>
                                                                    </div>
                                                                </div>
                                                                <div class="payment-method-details" data-method="phonepay" style="display: none;">
                                                                    <p>you can pay with Phone Pay App.</p>
                                                                </div>
                                                            </div>

                                                            <div class="single-payment-method">
                                                                <div class="payment-method-name">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="razorpay" name="paymentmethod2" value="razorpay" class="custom-control-input razorpay payment_type">
                                                                        <label class="custom-control-label" for="razorpay">Razor Pay</label>
                                                                    </div>
                                                                </div>
                                                                <div class="payment-method-details" data-method="razorpay" style="display: none;">
                                                                    <p>you can pay with Razor Pay.</p>
                                                                </div>
                                                            </div>

                                                            <!-- <div class="single-payment-method">
                                                                <div class="payment-method-name">
                                                                    <div class="custom-control custom-radio">
                                                                        <input type="radio" id="directbank" name="paymentmethod" value="bank" class="custom-control-input">
                                                                        <label class="custom-control-label" for="directbank">UPI</label>
                                                                    </div>
                                                                </div>
                                                                <div class="payment-method-details" data-method="bank" style="display: none;">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>UPI ID</label>
                                                                                <input type="text" class="form-control login" id="full-name" placeholder="Enter your UPI ID" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> -->
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6"></div>
                                                    <div class="col-md-12">
                                                        <div class="form-group" style="text-align:right;">
                                                            <a href="#" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-controls="collapseTwo" aria-expanded="false" class="sqr-btn mt-3">
                                                                Continue
                                                                <svg width="29" height="8" viewBox="0 0 29 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M0.5 3.5C0.223858 3.5 0 3.72386 0 4C0 4.27614 0.223858 4.5 0.5 4.5V3.5ZM28.8536 4.35355C29.0488 4.15829 29.0488 3.84171 28.8536 3.64645L25.6716 0.464466C25.4763 0.269204 25.1597 0.269204 24.9645 0.464466C24.7692 0.659728 24.7692 0.976311 24.9645 1.17157L27.7929 4L24.9645 6.82843C24.7692 7.02369 24.7692 7.34027 24.9645 7.53553C25.1597 7.7308 25.4763 7.7308 25.6716 7.53553L28.8536 4.35355ZM0.5 4.5H28.5V3.5H0.5V4.5Z" fill="black"></path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-header" id="headingThree">
                                        <h5 class="mb-0">
                                            <button class="accordio-heading collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-controls="collapseThree" aria-expanded="false">
                                                Review Product
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-bs-parent="#general-question">
                                        <div id="checkout-cart-container">
                                            <!--  Product content -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
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
                                            <tr>
                                                <td>Shipping</td>
                                                <td style="text-align: right; font-weight: bold;" id="totalShippingCharge">₹0</td>
                                            </tr>
                                            <tr class="total">
                                                <td>Discount</td>
                                                <td style="text-align: right; font-weight: bold; color: #ffb932; " class="total-amount" id="totalDiscount">₹0</td>
                                            </tr>
                                            <tr class="total">
                                                <td>Coupon Discount</td>
                                                <td style="text-align: right; font-weight: bold; color: #ffb932; " class="total-amount" id="couponDiscount">₹0</td>
                                            </tr>
                                            <tr class="total">
                                                <td>Taxable Amount</td>
                                                <td style="text-align: right; font-weight: bold; color: #ffb932; " class="total-amount" id="taxableAmount">₹0</td>
                                            </tr>
                                            <tr class="total">
                                                <td>Total GST(Tax)</td>
                                                <td style="text-align: right; font-weight: bold; color: #ffb932; " class="total-amount" id="taxPrice">₹0</td>
                                            </tr>
                                            <tr class="total">
                                                <td>Cart total</td>
                                                <td style="text-align: right; font-weight: bold;" class="finalAmount">₹0</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="summary-footer-area mt-5 mb-5">
                                <div class="custom-control custom-checkbox mb-14">
                                    <input type="checkbox" class="custom-control-input" id="terms" required="">
                                    <label class="custom-control-label" for="terms">I have read and agree to <a href="<?php echo env('WEBSITE_URL').'page/terms-of-service'; ?>" style="color:green" target="_blank">terms and conditions.</a></label>
                                </div>
                            </div>
                            <span class="pay_error" style="color:red;font-weight:bold;font-size:16px"></span>
                            <span class="pay_success" style="color:green;font-weight:bold;font-size:16px"></span>
                            <a href="javascript:void('0')" class="sqr-btn d-block mt-3" id="pay_now"> Place the order
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
                    <h1 id="staticBackdropLabel">Confirmation</h1>
                </div>
                <div class="modal-body">
                    <div class="row address-form">
                        <div class="col-md-12 mb-3">
                           Are You comfertable with out of stock product without COD payment?
                        </div>
                        <div class="col-md-12 mt-4 text-center">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal"> Ok, Continue</button>
                        </div>
                        <div class="col-md-12 mt-4 text-center">
                            <a href="{{ route('product.viewBag') }}" class="sqr-btn"> View Cart </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('out-of-stock-product')?.addEventListener('hidden.bs.modal', () => {
            if (document.querySelector('.modal.show')) {
                return;
            }

            document.querySelectorAll('.modal-backdrop').forEach((backdrop) => backdrop.remove());
            document.body.classList.remove('modal-open');
            document.body.style.removeProperty('overflow');
            document.body.style.removeProperty('padding-right');
        });
    </script>
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
        var USERPHONE = "{{ Auth::guard('customer')->check() ? Auth::guard('customer')->user()->phone_number : '9876543210' }}";

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
        if(couponCode==''){
            alert('please enter valid coupon code');
        }
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

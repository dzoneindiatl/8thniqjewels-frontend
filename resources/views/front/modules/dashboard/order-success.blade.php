@extends('front.layouts.app')
@section('content')
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

    <main class="main-bg">
        <!-- cart main wrapper start -->
        <div class="cart-main-wrapper pb-100 pt-sm-58 pb-sm-58">
            <div class="container">
                <div class="order-success pt-200">
                    <img src="{{ asset('uploads/success.gif') }}" width="150" />
                    <h2 class="mt-30 mb-30">Order placed!</h2>
                    <p class="mt-30 mb-30">
                        We've got your order! We'll keep you updated once your order ships. Please find your order details below.
                        Visit the My Orders section to get further updates about your order.
                        <br/><b>Thank you for shopping with us!</b>
                    </p>
                    <div class="buy-button">
                        <a class="learn-more" href="{{ route('user.dashboard') }}">
                            Go to account
                            <svg width="29" height="8" viewBox="0 0 29 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.5 3.5C0.223858 3.5 0 3.72386 0 4C0 4.27614 0.223858 4.5 0.5 4.5V3.5ZM28.8536 4.35355C29.0488 4.15829 29.0488 3.84171 28.8536 3.64645L25.6716 0.464466C25.4763 0.269204 25.1597 0.269204 24.9645 0.464466C24.7692 0.659728 24.7692 0.976311 24.9645 1.17157L27.7929 4L24.9645 6.82843C24.7692 7.02369 24.7692 7.34027 24.9645 7.53553C25.1597 7.7308 25.4763 7.7308 25.6716 7.53553L28.8536 4.35355ZM0.5 4.5H28.5V3.5H0.5V4.5Z" fill="black" />
                            </svg>
                        </a>
                        <a href="{{ config('app.url') }}" class="sqr-btn">
                            Continue buying
                            <svg width="29" height="8" viewBox="0 0 29 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.5 3.5C0.223858 3.5 0 3.72386 0 4C0 4.27614 0.223858 4.5 0.5 4.5V3.5ZM28.8536 4.35355C29.0488 4.15829 29.0488 3.84171 28.8536 3.64645L25.6716 0.464466C25.4763 0.269204 25.1597 0.269204 24.9645 0.464466C24.7692 0.659728 24.7692 0.976311 24.9645 1.17157L27.7929 4L24.9645 6.82843C24.7692 7.02369 24.7692 7.34027 24.9645 7.53553C25.1597 7.7308 25.4763 7.7308 25.6716 7.53553L28.8536 4.35355ZM0.5 4.5H28.5V3.5H0.5V4.5Z" fill="black" />
                            </svg>
                        </a>
                    </div>
                </div>
                <!-- <div class="order-success pt-200"">
                    <div class="col-md-8">
                        <div class="border-box order-detail-sec mb-4">
                            <h4 class="box-title">Order Detail</h4>
                            <ul class="order-detail-list d-flex justify-content-between">
                                <li>
                                    <b>Order ID#</b>
                                    <p>{{ $order->order_number }}</p>
                                </li>
                                <li>
                                    <b>Order Placed</b>
                                    <p>{{ $order->created_at->format('jS M, Y') }}</p>
                                </li>
                                <li>
                                    <b>Order status: <span>Success</span></b>
                                    <p>Order will Be Delivered In 3-5 Days.</p>
                                </li>
                            </ul>
                        </div>
                        <div class="border-box delivery-mode mb-4">
                            <h4 class="box-title">Delivery Mode & Address</h4>
                            <ul class="delivery-mode-list">
                                <li>
                                    <i class="fa-solid fa-gift"></i>
                                    <div class="delivery-mode-content"><span>Standard Delivery</span></div>
                                </li>
                                @php
                                    $billing = json_decode($order->billing_address);
                                @endphp
                                <li>
                                    <i class="fa-solid fa-location-dot"></i>
                                    <div class="delivery-mode-content">
                                        <span>{{ $billing->billing_customer_name }} {{ $billing->billing_last_name }}</span>
                                        <p>{{ $billing->billing_address }}, {{ $billing->billing_city }},
                                            {{ $billing->billing_state }}, {{ $billing->billing_country }},
                                            {{ $billing->billing_pincode }}</p>
                                        <p>Phone: +{{ $billing->billing_phone }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="border-box mb-4 product-info">
                            @foreach ($order->items as $orderItems)
                                @php
                                    $combination = json_decode($orderItems->combination);
                                    $variantId = \App\Models\VariantValue::where(
                                        'name',
                                        'like',
                                        '%' . reset($combination) . '%',
                                    )->value('id');
                                    $img =
                                        \App\Models\ProductGraphics::where('product_id', $orderItems->product_id)
                                            ->where('variant_id', $variantId)
                                            ->value('graphic') ??
                                        \App\Models\ProductGraphics::where('product_id', $orderItems->product_id)->value(
                                            'graphic',
                                        );
                                    $combinationData = '';
                                    foreach ($combination as $key => $data) {
                                        $key = ucfirst($key);
                                        $combinationData .= "<p class='c-color'>$key: $data</p>";
                                    }
                                    $price = $orderItems->selling_price * $orderItems->qty;
                                    $product_price = $orderItems->mrp * $orderItems->qty;
                                    $product_varient_discount = getProductVariantSku(
                                        $orderItems->product_variant_combination_id,
                                    );

                                @endphp
                                <div class="product-detail-content mb-3">
                                    <a
                                        href="#>
                                        <figure><img src="{{ url('uploads/products/' . $img) }}" /></figure>
                                    </a>
                                    <figcaption>
                                        <a
                                            href="#">

                                            <h4>{{ $orderItems->product->name ?? 'N/A' }}</h4>
                                        </a>
                                        <div class="product-cs">{!! $combinationData !!}</div>
                                        <p class="QTY">QTY: {{ $orderItems->qty }}</p>
                                        <div class="price-tag">
                                            @if (!empty($product_varient_discount->discount) && $product_varient_discount->discount > 0)
                                                <span> <del>₹{{ $product_price }}</del></span>
                                            @endif
                                            <span> ₹{{ $price }}</span>
                                            @if (!empty($product_varient_discount->discount) && $product_varient_discount->discount > 0)
                                                <span> {{ round($product_varient_discount->discount) }}% off</span>
                                            @endif
                                        </div>
                                    </figcaption>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border-box ">
                            <h4 class="box-title d-flex justify-content-between align-items-center">Price Detail <span
                                    class="product-item">{{ count($order->items) }} Item</span></h4>
                                    <div class="total-bill-sec">
                                        <ul class="total-list">
                                            @php
                                                $totalMrp = 0;
                                                $totalSellingPrice = 0;
                                                $total = 0;
                                                $subTotal = 0;
                                                $taxAmount = 0;
                                                $shippingcharge = 0;
                                            @endphp
                                            @foreach ($order->items as $orderItems)
                                                @php
                                                    //prx($orderItems);
                                                    //$totalMrp += $product_price;
                                                    $totalMrp += $orderItems->mrp * $orderItems->qty;
                                                    $totalSellingPrice += $orderItems->selling_price * $orderItems->qty;
                                                    $total += $orderItems->total * $orderItems->qty;
                                                    $taxAmount += $orderItems->tax_amount;
                                                    $subTotal += $orderItems->sub_total * $orderItems->qty;
                                                    if ($walletamount) {
                                                        $walletamt = $walletamount->amount;
                                                    }

                                                @endphp
                                            @endforeach
                                            @php
                                                $taxableAmt = $totalSellingPrice - $order->coupon_discount - $taxAmount;
                                                $grandTotal = $totalSellingPrice - $order->coupon_discount;
                                                $shippingcharge = $order->shippingcharge;
                                            @endphp
                                            <li>
                                                <span>Total MRP</span>
                                                <p> ₹{{ $totalMrp }}</p>
                                            </li>
                                            <li>
                                                <span>Discount </span>
                                                <p class="text-green">-₹{{ $totalMrp - $totalSellingPrice }}</p>
                                            </li>
                                            <li>
                                                <span>Sub Total</span>
                                                <p> ₹{{ $totalSellingPrice }}</p>
                                            </li>
                                            <li>
                                                <span>Coupon Discount </span>
                                                <p class="text-green">-₹{{ $order->coupon_discount }}</p>
                                            </li>
                                            <li>
                                                <span>Grand Total </span>
                                                <p class="text-green">₹{{ $grandTotal }}</p>
                                            </li>
                                            <li>
                                                <span>Taxable Amount </span>
                                                <p class="text-green">₹{{ $taxableAmt }}</p>
                                            </li>
                                            <li>
                                                <span>Total GST(Tax) </span>
                                                <p class="text-green">₹{{ $taxAmount }}</p>
                                            </li>
                                            <li>
                                                <span>Delivery Charges</span>
                                                <p class="text-green">₹{{ $shippingcharge }}</p>
                                            </li>
                                            <li>
                                                <hr />
                                            </li>
                                            @if (@$walletamt)
                                                <li>
                                                    <span>Total Paid Wallet Amount</span>
                                                    <p><b>₹{{ @$walletamt }}</b></p>
                                                </li>
                                                <li>
                                                    <span>Total Paid Online Amount</span>
                                                    <p><b>₹{{ $taxableAmt + $taxAmount + $shippingcharge - $walletamt }}</b></p>
                                                </li>
                                            @endif
                                            <li>
                                                <span><b>Total Payable</b> (Tax Included)</span>
                                                <p><b>₹{{ $taxableAmt + $taxAmount + $shippingcharge }}</b></p>
                                            </li>
                                            <li class="mb-0">
                                                @php
                                                    $paymentMode = match ($order->payment_method) {
                                                        'cod' => 'Cash On Delivery',
                                                        'paypal', 'razorpay' => 'Pay Online',
                                                        default => 'Use Vasvi Wallet',
                                                    };
                                                @endphp
                                                @if (empty($walletamount))
                                                    <span>Mode of Payment</span>
                                                    <p>{{ $paymentMode }}</p>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            <div>
        </div>
        <!-- cart main wrapper end -->
    </main>
    <!-- page main wrapper end -->    
@endsection

<script>
   var oldCartItems = localStorage.getItem('oldCartItems');
    localStorage.setItem('cartItems', oldCartItems);
    localStorage.setItem('oldCartItems', JSON.stringify([]));
    console.log('cart : ', localStorage.getItem('cartItems'));
</script>

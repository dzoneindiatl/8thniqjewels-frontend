<div class="edit-account">
    <div class="row" id="OrderDetailPopupContent">
        <div class="col-lg-12 col-md-6">
            @if($orderItems)
                @foreach($orderItems as $item)
                <div class="order-list">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="product-img">
                                <img src="{{ url('uploads/products/' . @$item->productGraphics->graphic ) }}" width="100%" />
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="active-order-list">
                                <h5>{{  @$item->product->name }}</h5>
                                <p class="order-date mt-2">Ordered on: <?php  echo date("d-m-Y H:i",strtotime($item->order->created_at));  ?></p>
                                <h4 class="rate-order mt-2">Rs. {{  @$item->order->total }} </h4>
                                <span class="delevery-status">{{  @$item->status }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

        </div>
        <div class="col-lg-12 col-md-6">
            <div class="cart-amount track-popup mt-3 mb-3">
                <div class="cart-calculator-wrapper">
                    <div class="cart-calculate-items">
                        <h3 class="mb-10">Order summary</h3>
                        
                        <div class="table-responsive">
                            <table width="100%">
                                <tr>
                                    <td>Sub-Total</td>
                                    <td style="text-align:right;font-weight:bold;">Rs. {{  @$orderDetails->sub_total }}</td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td style="text-align: right; font-weight: bold;">Rs. {{  @$orderDetails->shippingcharge }}</td>
                                </tr>
                                <tr class="total">
                                    <td>Coupon Discount</td>
                                    <td style="text-align: right; font-weight: bold; color: #ffb932; " class="total-amount">- Rs. {{  @$orderDetails->coupon_discount }}</td>
                                </tr>
                                <tr class="total">
                                    <td>Total</td>
                                    <td style="text-align: right; font-weight: bold;">Rs. {{  @$orderDetails->total }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            <h5>Order Journey</h5>
            <div class="wrapper mb-3">
                <ul class="StepProgress">
                    <li class="StepProgress-item is-done"><strong>Order Placed on <?php  echo date("d-m-Y H:i",strtotime($orderDetails->created_at));  ?></strong></li>
                    @if($OrderStatusHistory)
                        @foreach($OrderStatusHistory as $statusHistory)
                            <li class="StepProgress-item is-done">
                                <strong><?php echo strtoupper($statusHistory->order_status); ?></strong> on <?php  echo date("d-m-Y H:i",strtotime($statusHistory->created_at));  ?>
                                </br><span>Remark : {{  @$statusHistory->remark  }}</span>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            @if($orderDetails->shipping_address)
                @php $shipping_address = json_decode($orderDetails->shipping_address, true); @endphp
                <div class="cart-amount track-popup mt-3 mb-3">
                    <div class="cart-calculator-wrapper">
                        <div class="cart-calculate-items">
                            <h3 class="mb-10">Shipping address</h3>
                            <p>Name : {{ $shipping_address['shipping_customer_name'] }}</br>
                            Phone : {{ $shipping_address['shipping_phone'] }}</br>
                            {{ $shipping_address['shipping_address'] }} {{ $shipping_address['shipping_city'] }} {{ $shipping_address['shipping_state'] }} {{ $shipping_address['shipping_country'] }} {{ $shipping_address['shipping_pincode'] }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($orderDetails->billing_address)
                @php $billing_address = json_decode($orderDetails->billing_address, true); @endphp
                <div class="cart-amount track-popup mt-3 mb-3">
                    <div class="cart-calculator-wrapper">
                        <div class="cart-calculate-items">
                            <h3 class="mb-10">Billing address</h3>
                            <p>Name : {{ $billing_address['billing_customer_name'] }}</br>
                            Phone : {{ $billing_address['billing_phone'] }}</br>
                            {{ $billing_address['billing_address'] }} {{ $billing_address['billing_city'] }} {{ $billing_address['billing_state'] }} {{ $billing_address['billing_country'] }} {{ $billing_address['billing_pincode'] }}</p>
                        </div>
                    </div>
                </div>
            @endif


        </div>
        
        <div class="col-lg-12 col-md-12">
            <div class="form-group mb-0">
                <a href="#" class="sqr-btn d-block bg-danger text-white">
                    Cancel order
                    <svg width="30" height="8" viewBox="0 0 30 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z" fill="white" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
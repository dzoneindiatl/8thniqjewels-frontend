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
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area mt-100 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <h2 class="text-center">My Account</h2>

                        @if ($errors->any())
                            <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                                <li>Error :</li>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success text-center alert-dismissible fade show" role="alert" >
                                Success : {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                         @endif
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
                    <div class="col-lg-12">
                        <div class="my-profile mb-20">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="prof">
                                        <?php $defaultImgUrl = asset('uploads/users/OCT2025/1759757747-image.webp'); ?>
                                        <img src="{{ $user->image ? $user->image : $defaultImgUrl }}" class="profile-img" alt="userimg" />
                                        <div class="profile-details">
                                            <h4>
                                                {{ $user->name }}
                                                <span style="float:right;">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#edit-profile" class="edit-profile">
                                                        <svg class="edit-profiless" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.0504 3.00002L4.20878 10.2417C3.95045 10.5167 3.70045 11.0584 3.65045 11.4334L3.34211 14.1334C3.23378 15.1084 3.93378 15.775 4.90045 15.6084L7.58378 15.15C7.95878 15.0834 8.48378 14.8084 8.74211 14.525L15.5838 7.28335C16.7671 6.03335 17.3004 4.60835 15.4588 2.86668C13.6254 1.14168 12.2338 1.75002 11.0504 3.00002Z" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M9.9082 4.2085C10.2665 6.5085 12.1332 8.26683 14.4499 8.50016" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M2.5 18.3335H17.5" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg> Edit
                                                    </a>
                                                    <a href="{{ route('front-user.changePassword') }}" class="edit-profile">
                                                        <svg class="edit-profiless" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M15 8.95817C14.6583 8.95817 14.375 8.67484 14.375 8.33317V6.6665C14.375 4.0415 13.6333 2.2915 10 2.2915C6.36667 2.2915 5.625 4.0415 5.625 6.6665V8.33317C5.625 8.67484 5.34167 8.95817 5 8.95817C4.65833 8.95817 4.375 8.67484 4.375 8.33317V6.6665C4.375 4.24984 4.95833 1.0415 10 1.0415C15.0417 1.0415 15.625 4.24984 15.625 6.6665V8.33317C15.625 8.67484 15.3417 8.95817 15 8.95817Z" fill="#FFB932" />
                                                            <path d="M10.0003 16.0417C8.50866 16.0417 7.29199 14.825 7.29199 13.3333C7.29199 11.8417 8.50866 10.625 10.0003 10.625C11.492 10.625 12.7087 11.8417 12.7087 13.3333C12.7087 14.825 11.492 16.0417 10.0003 16.0417ZM10.0003 11.875C9.20033 11.875 8.54199 12.5333 8.54199 13.3333C8.54199 14.1333 9.20033 14.7917 10.0003 14.7917C10.8003 14.7917 11.4587 14.1333 11.4587 13.3333C11.4587 12.5333 10.8003 11.875 10.0003 11.875Z" fill="#FFB932" />
                                                            <path d="M14.167 18.9585H5.83366C2.15866 18.9585 1.04199 17.8418 1.04199 14.1668V12.5002C1.04199 8.82516 2.15866 7.7085 5.83366 7.7085H14.167C17.842 7.7085 18.9587 8.82516 18.9587 12.5002V14.1668C18.9587 17.8418 17.842 18.9585 14.167 18.9585ZM5.83366 8.9585C2.85033 8.9585 2.29199 9.52516 2.29199 12.5002V14.1668C2.29199 17.1418 2.85033 17.7085 5.83366 17.7085H14.167C17.1503 17.7085 17.7087 17.1418 17.7087 14.1668V12.5002C17.7087 9.52516 17.1503 8.9585 14.167 8.9585H5.83366Z" fill="#FFB932" />
                                                        </svg>
                                                        Change Password
                                                    </a>
                                                </span>
                                            </h4>
                                            <p>
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M14.167 17.7082H5.83366C2.79199 17.7082 1.04199 15.9582 1.04199 12.9165V7.08317C1.04199 4.0415 2.79199 2.2915 5.83366 2.2915H14.167C17.2087 2.2915 18.9587 4.0415 18.9587 7.08317V12.9165C18.9587 15.9582 17.2087 17.7082 14.167 17.7082ZM5.83366 3.5415C3.45033 3.5415 2.29199 4.69984 2.29199 7.08317V12.9165C2.29199 15.2998 3.45033 16.4582 5.83366 16.4582H14.167C16.5503 16.4582 17.7087 15.2998 17.7087 12.9165V7.08317C17.7087 4.69984 16.5503 3.5415 14.167 3.5415H5.83366Z" fill="#FFB932" />
                                                    <path d="M9.99998 10.725C9.29998 10.725 8.59165 10.5083 8.04998 10.0666L5.44164 7.98331C5.17498 7.76664 5.12498 7.37497 5.34165 7.10831C5.55831 6.84164 5.94998 6.79164 6.21665 7.00831L8.82497 9.09164C9.45831 9.59998 10.5333 9.59998 11.1666 9.09164L13.775 7.00831C14.0416 6.79164 14.4416 6.83331 14.65 7.10831C14.8666 7.37497 14.825 7.77498 14.55 7.98331L11.9416 10.0666C11.4083 10.5083 10.7 10.725 9.99998 10.725Z" fill="#FFB932" />
                                                </svg>
                                                {{ $user->email }}
                                            </p>
                                            <p>
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M14.542 18.9582C13.6003 18.9582 12.6087 18.7332 11.5837 18.2998C10.5837 17.8748 9.57533 17.2915 8.59199 16.5832C7.61699 15.8665 6.67533 15.0665 5.78366 14.1915C4.90033 13.2998 4.10033 12.3582 3.39199 11.3915C2.67533 10.3915 2.10033 9.3915 1.69199 8.42484C1.25866 7.3915 1.04199 6.3915 1.04199 5.44984C1.04199 4.79984 1.15866 4.18317 1.38366 3.60817C1.61699 3.0165 1.99199 2.4665 2.50033 1.9915C3.14199 1.35817 3.87533 1.0415 4.65866 1.0415C4.98366 1.0415 5.31699 1.1165 5.60033 1.24984C5.92533 1.39984 6.20033 1.62484 6.40033 1.92484L8.33366 4.64984C8.50866 4.8915 8.64199 5.12484 8.73366 5.35817C8.84199 5.60817 8.90033 5.85817 8.90033 6.09984C8.90033 6.4165 8.80866 6.72484 8.63366 7.0165C8.50866 7.2415 8.31699 7.48317 8.07533 7.72484L7.50866 8.3165C7.51699 8.3415 7.52533 8.35817 7.53366 8.37484C7.63366 8.54984 7.83366 8.84984 8.21699 9.29984C8.62533 9.7665 9.00866 10.1915 9.39199 10.5832C9.88366 11.0665 10.292 11.4498 10.6753 11.7665C11.1503 12.1665 11.4587 12.3665 11.642 12.4582L11.6253 12.4998L12.2337 11.8998C12.492 11.6415 12.742 11.4498 12.9837 11.3248C13.442 11.0415 14.0253 10.9915 14.6087 11.2332C14.8253 11.3248 15.0587 11.4498 15.3087 11.6248L18.0753 13.5915C18.3837 13.7998 18.6087 14.0665 18.742 14.3832C18.867 14.6998 18.9253 14.9915 18.9253 15.2832C18.9253 15.6832 18.8337 16.0832 18.6587 16.4582C18.4837 16.8332 18.267 17.1582 17.992 17.4582C17.517 17.9832 17.0003 18.3582 16.4003 18.5998C15.8253 18.8332 15.2003 18.9582 14.542 18.9582ZM4.65866 2.2915C4.20033 2.2915 3.77533 2.4915 3.36699 2.8915C2.98366 3.24984 2.71699 3.6415 2.55033 4.0665C2.37533 4.49984 2.29199 4.95817 2.29199 5.44984C2.29199 6.22484 2.47533 7.0665 2.84199 7.93317C3.21699 8.8165 3.74199 9.73317 4.40866 10.6498C5.07533 11.5665 5.83366 12.4582 6.66699 13.2998C7.50033 14.1248 8.40033 14.8915 9.32533 15.5665C10.2253 16.2248 11.1503 16.7582 12.067 17.1415C13.492 17.7498 14.8253 17.8915 15.9253 17.4332C16.3503 17.2582 16.7253 16.9915 17.067 16.6082C17.2587 16.3998 17.4087 16.1748 17.5337 15.9082C17.6337 15.6998 17.6837 15.4832 17.6837 15.2665C17.6837 15.1332 17.6587 14.9998 17.592 14.8498C17.567 14.7998 17.517 14.7082 17.3587 14.5998L14.592 12.6332C14.4253 12.5165 14.2753 12.4332 14.1337 12.3748C13.9503 12.2998 13.8753 12.2248 13.592 12.3998C13.4253 12.4832 13.2753 12.6082 13.1087 12.7748L12.4753 13.3998C12.1503 13.7165 11.6503 13.7915 11.267 13.6498L11.042 13.5498C10.7003 13.3665 10.3003 13.0832 9.85866 12.7082C9.45866 12.3665 9.02533 11.9665 8.50033 11.4498C8.09199 11.0332 7.68366 10.5915 7.25866 10.0998C6.86699 9.6415 6.58366 9.24984 6.40866 8.92484L6.30866 8.67484C6.25866 8.48317 6.24199 8.37484 6.24199 8.25817C6.24199 7.95817 6.35033 7.6915 6.55866 7.48317L7.18366 6.83317C7.35033 6.6665 7.47533 6.50817 7.55866 6.3665C7.62533 6.25817 7.65033 6.1665 7.65033 6.08317C7.65033 6.0165 7.62533 5.9165 7.58366 5.8165C7.52533 5.68317 7.43366 5.53317 7.31699 5.37484L5.38366 2.6415C5.30033 2.52484 5.20033 2.4415 5.07533 2.38317C4.94199 2.32484 4.80033 2.2915 4.65866 2.2915ZM11.6253 12.5082L11.492 13.0748L11.717 12.4915C11.6753 12.4832 11.642 12.4915 11.6253 12.5082Z" fill="#FFB932" />
                                                </svg>
                                                +91-{{ $user->phone_number }}
                                            </p>

                                            @if (@$user->user_role_id==5)
                                            <p>User Role : Affiliate </p>
                                            <!-- <p> Referal Code :  <h4>{{ @$user->user_referral_code }} </h4> </p> -->

                                            <!-- Trigger the referal modal with a button -->
                                                    <button type="button" class="btn btn-info btn-lg" data-bs-toggle="modal" data-bs-target="#referalModal" class="referalModal">Referal Code</button>
                                                    <!-- Modal -->
                                                    <div id="referalModal" class="modal fade" role="dialog">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title">Your Referal Code </h4> <h6>Which you can share your connection </h6>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <ul>
                                                                        @for( $i=1; $i <= @$user->referal_max_percentage; $i++ )
                                                                        <li><strong> <?php echo  $i . '  -  '. @$user->user_referral_code.'@'.$i; ?> </strong>  <?php echo   " 
                                                                        &nbsp;&nbsp;&nbsp; ( User Percentage :   " . $i ."% )"; ?></li>
                                                                        @endfor
                                                                    </ul>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="close" data-bs-dismiss="modal">close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <!-- Trigger the referal modal with a button -->
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(@$user->user_role_id == 4)
                    <!--   Dashboard section for customer -->
                    <div class="col-md-6">
                        <div class="card-white mt-3">
                            <h3>My Orders</h3>
                            <div class="order-list-profile mt-20">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Active ({{ count($orderCurentDetails) }})</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Delivered ({{ count($orderDelivedDetails) }})</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Cancelled ({{ count($orderCancelledDetails) }})</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent" style="max-height:710px;overflow-y: auto;  overflow-x: hidden;">
                                    <!-- Active Order -->
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        @if (isset($orderCurentDetails))
                                        @foreach ($orderCurentDetails as $order)
                                            @php
                                                $firstItem = $order->items->first();
                                                $totalQty = $order->items->sum('qty');

                                                if ($firstItem) {
                                                    $combination = json_decode($firstItem->combination);

                                                    $variantId = \App\Models\VariantValue::where(
                                                        'name',
                                                        'like',
                                                        '%' . reset($combination) . '%',
                                                    )->value('id');

                                                    $img =
                                                        \App\Models\ProductGraphics::where('product_id', $firstItem->product_id)
                                                            ->where('variant_id', $variantId)
                                                            ->value('graphic') ??
                                                        \App\Models\ProductGraphics::where(
                                                            'product_id',
                                                            $firstItem->product_id,
                                                        )->value('graphic');
                                                } else {
                                                    $combination = null;
                                                    $variantId = null;
                                                    $img = null;
                                                }
                                            @endphp
                                        <div class="order-list">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="product-img">
                                                        <img src="{{ url('uploads/products/' . $img) }}" style="width: 200px; height: 150px;"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="active-order-list">
                                                        <h5>{{ $firstItem ? @$firstItem->product->name : 'Product Name Not Available' }}
                                                        <span class="delevery-status"><?php if(isset($allStatuses[$order->status]) && !empty($allStatuses[$order->status])) { echo $allStatuses[$order->status]; } else { echo 'Unknown Status'; } ?></span>

                                                        <?php 
                                                            if(in_array($order->status,array('shipped','in-transit','out-for-delivery','delivered','return-requested','return-accepted','refund-pending','refunded','cancelled','cancelled_by_customer'))) { 
                                                                echo '<span><a href="'. Config('constant.ADMIN_WEBSITE_URL') . 'orders/generate-invoice/'.encrypt($order->id).'" class="btn btn-info" target="_blank" title="Generate Invoice">Print</a></span>';
                                                            } 
                                                        ?>
                                                        </h5>
                                                        <p class="order-date mt-10">Ordered on: <?php  echo date("d-m-Y H:i",strtotime($order->created_at));  ?></p>
                                                        <h4 class="rate-order mt-10">₹{{ $order->total }}</h4>
                                                        <p class="delevery-date mt-10"> <a href="javascript:void(0)" class="track-order" id="openModalBtn" data-orderId="{{ $order->id }}"> Track Order </a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                    <!-- Active Order -->

                                     <!-- Delivered Order -->
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        @if (isset($orderDelivedDetails))
                                        @foreach ($orderDelivedDetails as $order)
                                            @php
                                                $firstItem = $order->items->first();
                                                $totalQty = $order->items->sum('qty');

                                                if ($firstItem) {
                                                    $combination = json_decode($firstItem->combination);

                                                    $variantId = \App\Models\VariantValue::where(
                                                        'name',
                                                        'like',
                                                        '%' . reset($combination) . '%',
                                                    )->value('id');

                                                    $img =
                                                        \App\Models\ProductGraphics::where('product_id', $firstItem->product_id)
                                                            ->where('variant_id', $variantId)
                                                            ->value('graphic') ??
                                                        \App\Models\ProductGraphics::where(
                                                            'product_id',
                                                            $firstItem->product_id,
                                                        )->value('graphic');
                                                } else {
                                                    $combination = null;
                                                    $variantId = null;
                                                    $img = null;
                                                }
                                            @endphp
                                        <div class="order-list">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="product-img">
                                                        <img src="{{ url('uploads/products/' . $img) }}" style="width: 200px; height: 150px;"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="active-order-list">
                                                        <h5>{{ $firstItem ? @$firstItem->product->name : 'Product Name Not Available' }}
                                                            <span class="delevery-status">Delivered</span>
                                                            <?php 
                                                                if(in_array($order->status,array('shipped','in-transit','out-for-delivery','delivered','return-requested','return-accepted','refund-pending','refunded','cancelled','cancelled_by_customer'))) { 
                                                                    echo '<span><a href="'. Config('constant.ADMIN_WEBSITE_URL') . 'orders/generate-invoice/'.encrypt($order->id).'" class="btn btn-info" target="_blank" title="Generate Invoice">Print</a></span>';
                                                                } 
                                                            ?>
                                                        </h5>
                                                        <p class="order-date mt-10">Ordered on: <?php  echo date("d-m-Y H:i",strtotime($order->created_at));  ?></p>
                                                        <h4 class="rate-order mt-10">₹{{ $order->total }}</h4>
                                                        <p class="delevery-date mt-10"> <a href="javascript:void(0)" class="track-order" id="openModalBtn" data-orderId="{{ $order->id }}"> Track Order </a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                    <!-- Delivered Order -->

                                     <!-- Cancelled Order -->
                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                        @if (isset($orderCancelledDetails))
                                        @foreach ($orderCancelledDetails as $order)
                                            @php
                                                $firstItem = $order->items->first();
                                                $totalQty = $order->items->sum('qty');

                                                if ($firstItem) {
                                                    $combination = json_decode($firstItem->combination);

                                                    $variantId = \App\Models\VariantValue::where(
                                                        'name',
                                                        'like',
                                                        '%' . reset($combination) . '%',
                                                    )->value('id');

                                                    $img =
                                                        \App\Models\ProductGraphics::where('product_id', $firstItem->product_id)
                                                            ->where('variant_id', $variantId)
                                                            ->value('graphic') ??
                                                        \App\Models\ProductGraphics::where(
                                                            'product_id',
                                                            $firstItem->product_id,
                                                        )->value('graphic');
                                                } else {
                                                    $combination = null;
                                                    $variantId = null;
                                                    $img = null;
                                                }
                                            @endphp
                                        <div class="order-list">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="product-img">
                                                        <img src="{{ url('uploads/products/' . $img) }}" style="width: 200px; height: 150px;"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="active-order-list">
                                                        <h5>{{ $firstItem ? @$firstItem->product->name : 'Product Name Not Available' }}
                                                            <span class="delevery-status">Cancelled</span>
                                                            <?php 
                                                                if(in_array($order->status,array('shipped','in-transit','out-for-delivery','delivered','return-requested','return-accepted','refund-pending','refunded','cancelled','cancelled_by_customer'))) { 
                                                                    echo '<span><a href="'. Config('constant.ADMIN_WEBSITE_URL') . 'orders/generate-invoice/'.encrypt($order->id).'" class="btn btn-info" target="_blank" title="Generate Invoice">Print</a></span>';
                                                                } 
                                                            ?>
                                                        </h5>
                                                        
                                                        <p class="order-date mt-10">Ordered on: <?php  echo date("d-m-Y H:i",strtotime($order->created_at));  ?></p>
                                                        <h4 class="rate-order mt-10">₹{{ $order->total }}</h4>
                                                        <p class="delevery-date mt-10"> <a href="javascript:void(0)" class="track-order" id="openModalBtn" data-orderId="{{ $order->id }}"> Track Order </a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                    <!-- Cancelled Order -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="card-white">
                            <h3>Address</h3>
                            @if(!empty($userAddressDetails))
                                @foreach($userAddressDetails as $address)
                                <div class="address-list">
                                    <table width="100%">
                                        <tr>
                                            <td>
                                                <p><?php echo $address->landmark  .' </br>'. $address->address .' </br>'. $states[$address->state_id] .' &nbsp '. $countries[$address->country_id]  .' &nbsp '.  $address->postal_code; ?>
                                                <?php if($address->is_primary==1) {  echo '<input class="form-check-input primary_address" type="radio" name="primary_address"  value="'.$address->id.'"  checked>';  } else {
                                                    echo '<input class="form-check-input primary_address" type="radio" name="primary_address"  value="'.$address->id.'" >';
                                                } ?></p>
                                            </td>
                                            <td align="right">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#add-address" class="edit-address edit_address" data-adddressId=<?php echo $address->id; ?>>  
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M13.2603 3.60022L5.05034 12.2902C4.74034 12.6202 4.44034 13.2702 4.38034 13.7202L4.01034 16.9602C3.88034 18.1302 4.72034 18.9302 5.88034 18.7302L9.10034 18.1802C9.55034 18.1002 10.1803 17.7702 10.4903 17.4302L18.7003 8.74022C20.1203 7.24022 20.7603 5.53022 18.5503 3.44022C16.3503 1.37022 14.6803 2.10022 13.2603 3.60022Z" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M11.8896 5.0498C12.3196 7.8098 14.5596 9.9198 17.3396 10.1998" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M3 22H21" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </a>
                                                <a href="javascript:void()" class="delete-address" id="removeAddressBtn" data-adddressId=<?php echo $address->id; ?> >
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M20.9997 6.72998C20.9797 6.72998 20.9497 6.72998 20.9197 6.72998C15.6297 6.19998 10.3497 5.99998 5.11967 6.52998L3.07967 6.72998C2.65967 6.76998 2.28967 6.46998 2.24967 6.04998C2.20967 5.62998 2.50967 5.26998 2.91967 5.22998L4.95967 5.02998C10.2797 4.48998 15.6697 4.69998 21.0697 5.22998C21.4797 5.26998 21.7797 5.63998 21.7397 6.04998C21.7097 6.43998 21.3797 6.72998 20.9997 6.72998Z" fill="#FF0505" />
                                                        <path d="M8.49977 5.72C8.45977 5.72 8.41977 5.72 8.36977 5.71C7.96977 5.64 7.68977 5.25 7.75977 4.85L7.97977 3.54C8.13977 2.58 8.35977 1.25 10.6898 1.25H13.3098C15.6498 1.25 15.8698 2.63 16.0198 3.55L16.2398 4.85C16.3098 5.26 16.0298 5.65 15.6298 5.71C15.2198 5.78 14.8298 5.5 14.7698 5.1L14.5498 3.8C14.4098 2.93 14.3798 2.76 13.3198 2.76H10.6998C9.63977 2.76 9.61977 2.9 9.46977 3.79L9.23977 5.09C9.17977 5.46 8.85977 5.72 8.49977 5.72Z" fill="#FF0505" />
                                                        <path d="M15.2104 22.7501H8.79039C5.30039 22.7501 5.16039 20.8201 5.05039 19.2601L4.40039 9.19007C4.37039 8.78007 4.69039 8.42008 5.10039 8.39008C5.52039 8.37008 5.87039 8.68008 5.90039 9.09008L6.55039 19.1601C6.66039 20.6801 6.70039 21.2501 8.79039 21.2501H15.2104C17.3104 21.2501 17.3504 20.6801 17.4504 19.1601L18.1004 9.09008C18.1304 8.68008 18.4904 8.37008 18.9004 8.39008C19.3104 8.42008 19.6304 8.77007 19.6004 9.19007L18.9504 19.2601C18.8404 20.8201 18.7004 22.7501 15.2104 22.7501Z" fill="#FF0505" />
                                                        <path d="M13.6601 17.25H10.3301C9.92008 17.25 9.58008 16.91 9.58008 16.5C9.58008 16.09 9.92008 15.75 10.3301 15.75H13.6601C14.0701 15.75 14.4101 16.09 14.4101 16.5C14.4101 16.91 14.0701 17.25 13.6601 17.25Z" fill="#FF0505" />
                                                        <path d="M14.5 13.25H9.5C9.09 13.25 8.75 12.91 8.75 12.5C8.75 12.09 9.09 11.75 9.5 11.75H14.5C14.91 11.75 15.25 12.09 15.25 12.5C15.25 12.91 14.91 13.25 14.5 13.25Z" fill="#FF0505" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                @endforeach
                            @endif
                            
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-address" class="add-address">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 4.1665V15.8332" stroke="#283EFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M4.16699 10H15.8337" stroke="#283EFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                Add another address
                            </a>
                        </div>
                        <div class="card-white mt-20">
                            <div class="card mb-3">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="accordio-heading collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-controls="collapseThree" aria-expanded="false">
                                            Wishlist
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-bs-parent="#general-question">
                                    <div class="card-body">
                                        @if(!empty($wishlistData))
                                        @foreach($wishlistData as $wishlist)
                                        <?php
                                            $product = $wishlist->getProduct;
                                            
                                            if(@$product->product_type==1){
                                                $getVarientId = @$product?->id;
                                            } else {
                                                $getVarientId = activeVarientByProductId($product?->id);
                                            }
                                            
                                            $front_img = getActiveFrontImg($product?->id,$getVarientId);
                                            $back_img = getActiveBackImg($product?->id,$getVarientId);
                                        ?>
										<div class="wishlist_cart_item cart-item d-flex align-items-center justify-content-between mb-4 p-3 rounded-3 border">
											<div class="d-flex align-items-center gap-3">
											<img src="{{ asset('uploads/products/' . $front_img) }}" alt="{{ $product?->name }}" class="rounded-3" style="width: 150px;height: 150px;object-fit:cover;">
											 
																<div>
											<h3 class="mb-1" style="font-size:16px">{{  @$product?->name }} </h3>
											@if ($product?->discount > 0)
											<span class="text-decoration-line-through">₹{{ floor($product?->buying_price) }}</span>
											@endif
											<div class="fw-bold text-success">₹{{ floor($product?->selling_price) }}</div>
											</div>
											</div>
											 
															<div class="d-flex align-items-center gap-3">
											<button class="cart_btn">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M8.81 2L5.19 5.63" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
											<path d="M15.19 2L18.81 5.63" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
											<path d="M2 7.85001C2 6.00001 2.99 5.85001 4.22 5.85001H19.78C21.01 5.85001 22 6.00001 22 7.85001C22 10 21.01 9.85001 19.78 9.85001H4.22C2.99 9.85001 2 10 2 7.85001Z" stroke="#FFB932" stroke-width="1.5"></path>
											<path d="M3.5 10L4.91 18.64C5.23 20.58 6 22 8.86 22H14.89C18 22 18.46 20.64 18.82 18.76L20.5 10" stroke="#FFB932" stroke-width="1.5" stroke-linecap="round"></path>
											</svg>  
											</button>
											 
											<button class="delete_btn">
												<svg width="24" height="24" viewBox="-5.47 0 35.61 35.61" xmlns="http://www.w3.org/2000/svg" data-iconid="390700" data-svgname="Delete remove trash trashfull" fill="#dc3545">
												<g transform="translate(-420.528 -575.113)">
												<path d="M440.5,610.723H425.218a2.36,2.36,0,0,1-2.357-2.358V587.11a1,1,0,0,1,2,0v21.255a.358.358,0,0,0,.357.358H440.5a.358.358,0,0,0,.358-.358V587.11a1,1,0,0,1,2,0v21.255A2.36,2.36,0,0,1,440.5,610.723Z"></path>
												<path d="M429.444,606.417a1,1,0,0,1-1-1v-14a1,1,0,0,1,2,0v14A1,1,0,0,1,429.444,606.417Z"></path>
												<path d="M436.278,606.417a1,1,0,0,1-1-1v-14a1,1,0,0,1,2,0v14A1,1,0,0,1,436.278,606.417Z"></path>
												<path d="M444.194,588.07h-.008c-8.419-.066-21.217-.127-22.435-.025a1,1,0,0,1-.93-1.682c.4-.4.479-.477,23.381-.293a1,1,0,0,1-.008,2Z"></path>
												<path d="M423.458,585.1h-.051a1,1,0,0,1-.949-1.049,4.77,4.77,0,0,1,3.8-4.593,5.537,5.537,0,0,1,1.413-2.991,4.541,4.541,0,0,1,3.369-1.3c.381,0,.793-.012,1.223-.025,2.532-.075,6-.172,8.213,2.062,1.5,1.514,2.178,3.782,2.063,6.934a1.018,1.018,0,0,1-1.036.963,1,1,0,0,1-.962-1.035c.091-2.534-.408-4.368-1.484-5.453-1.605-1.618-4.449-1.538-6.736-1.472-.45.014-.881.026-1.281.026a2.6,2.6,0,0,0-1.939.7,4.007,4.007,0,0,0-.927,2.512l0,1-1,.005a2.741,2.741,0,0,0-2.718,2.767A1,1,0,0,1,423.458,585.1Z"></path>
												<path d="M431.538,585.1a1,1,0,0,1-.989-.857,5.106,5.106,0,0,1,.851-3.665,3.1,3.1,0,0,1,2.359-1.078h.032a1,1,0,0,1,.029,2,1.093,1.093,0,0,0-.887.362,3.217,3.217,0,0,0-.4,2.1,1,1,0,0,1-.854,1.125A1.081,1.081,0,0,1,431.538,585.1Z"></path>
												<path d="M438.123,609.723" stroke="#FFB932" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2"></path>
												</g>
												</svg>    
											</button>
											</div>
										</div>
										@endforeach
                                        @else 
                                        <div class="cart-list mb-20">
                                            Wishlist Product not found.
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <!--   Dashboard section for customer -->
                    @elseif (@$user->user_role_id==5)
                    <div class="col-md-6">
                        <div class="card-white mt-3">
                            <h3>Referal Orders</h3>
                            <div class="order-list-profile mt-20">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="referal-active-tab" data-bs-toggle="tab" data-bs-target="#referal-active" type="button" role="tab" aria-controls="referal-active-tab" aria-selected="true">Active ({{ count($referalOrderCurentDetails) }})</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="referal-delivered-tab" data-bs-toggle="tab" data-bs-target="#referal-delivered" type="button" role="tab" aria-controls="referal-delivered-tab" aria-selected="false">Delivered ({{ count($referalOrderDelivedDetails) }})</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="referal-cancelled-tab" data-bs-toggle="tab" data-bs-target="#referal-cancelled" type="button" role="tab" aria-controls="referal-cancelled-tab" aria-selected="false">Cancelled ({{ 
                                            count($referalOrderCancelledDetails) }})</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent" style="max-height:710px;overflow-y: auto;  overflow-x: hidden;">
                                    <!-- Active Order -->
                                    <div class="tab-pane fade show active" id="referal-active" role="tabpanel" aria-labelledby="referal-active-tab">
                                        @if (isset($referalOrderCurentDetails))
                                        @foreach ($referalOrderCurentDetails as $order)
                                            @php
                                                $firstItem = $order->items->first();
                                                $totalQty = $order->items->sum('qty');

                                                if ($firstItem) {
                                                    $combination = json_decode($firstItem->combination);

                                                    $variantId = \App\Models\VariantValue::where(
                                                        'name',
                                                        'like',
                                                        '%' . reset($combination) . '%',
                                                    )->value('id');

                                                    $img =
                                                        \App\Models\ProductGraphics::where('product_id', $firstItem->product_id)
                                                            ->where('variant_id', $variantId)
                                                            ->value('graphic') ??
                                                        \App\Models\ProductGraphics::where(
                                                            'product_id',
                                                            $firstItem->product_id,
                                                        )->value('graphic');
                                                } else {
                                                    $combination = null;
                                                    $variantId = null;
                                                    $img = null;
                                                }
                                            @endphp
                                        <div class="order-list">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="product-img">
                                                        <img src="{{ url('uploads/products/' . $img) }}" style="width: 200px; height: 150px;"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="active-order-list">
                                                        <h5>{{ $firstItem ? @$firstItem->product->name : 'Product Name Not Available' }}
                                                        <span class="delevery-status"><?php if(isset($allStatuses[$order->status]) && !empty($allStatuses[$order->status])) { echo $allStatuses[$order->status]; } else { echo 'Unknown Status'; } ?></span></h5>
                                                        <p class="order-date mt-10">Ordered on: <?php  echo date("d-m-Y H:i",strtotime($order->created_at));  ?></p>
                                                        <h4 class="rate-order mt-10">₹{{ $order->total }}</h4>
                                                        <p class="delevery-date mt-10"> <a href="javascript:void(0)" class="track-order" id="openModalBtn" data-orderId="{{ $order->id }}"> Track Order </a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                    <!-- Active Order -->

                                     <!-- Delivered Order -->
                                    <div class="tab-pane fade" id="referal-delivered" role="tabpanel" aria-labelledby="referal-delivered-tab">
                                        @if (isset($referalOrderDelivedDetails))
                                        @foreach ($referalOrderDelivedDetails as $order)
                                            @php
                                                $firstItem = $order->items->first();
                                                $totalQty = $order->items->sum('qty');

                                                if ($firstItem) {
                                                    $combination = json_decode($firstItem->combination);

                                                    $variantId = \App\Models\VariantValue::where(
                                                        'name',
                                                        'like',
                                                        '%' . reset($combination) . '%',
                                                    )->value('id');

                                                    $img =
                                                        \App\Models\ProductGraphics::where('product_id', $firstItem->product_id)
                                                            ->where('variant_id', $variantId)
                                                            ->value('graphic') ??
                                                        \App\Models\ProductGraphics::where(
                                                            'product_id',
                                                            $firstItem->product_id,
                                                        )->value('graphic');
                                                } else {
                                                    $combination = null;
                                                    $variantId = null;
                                                    $img = null;
                                                }
                                            @endphp
                                        <div class="order-list">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="product-img">
                                                        <img src="{{ url('uploads/products/' . $img) }}" style="width: 200px; height: 150px;"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="active-order-list">
                                                        <h5>{{ $firstItem ? @$firstItem->product->name : 'Product Name Not Available' }}
                                                        <span class="delevery-status">Delivered</span></h5>
                                                        <p class="order-date mt-10">Ordered on: <?php  echo date("d-m-Y H:i",strtotime($order->created_at));  ?></p>
                                                        <h4 class="rate-order mt-10">₹{{ $order->total }}</h4>
                                                        <p class="delevery-date mt-10"> <a href="javascript:void(0)" class="track-order" id="openModalBtn" data-orderId="{{ $order->id }}"> Track Order </a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                    <!-- Delivered Order -->

                                     <!-- Cancelled Order -->
                                    <div class="tab-pane fade" id="referal-cancelled" role="tabpanel" aria-labelledby="referal-cancelled-tab">
                                        @if (isset($referalOrderCancelledDetails))
                                        @foreach ($referalOrderCancelledDetails as $order)
                                            @php
                                                $firstItem = $order->items->first();
                                                $totalQty = $order->items->sum('qty');

                                                if ($firstItem) {
                                                    $combination = json_decode($firstItem->combination);

                                                    $variantId = \App\Models\VariantValue::where(
                                                        'name',
                                                        'like',
                                                        '%' . reset($combination) . '%',
                                                    )->value('id');

                                                    $img =
                                                        \App\Models\ProductGraphics::where('product_id', $firstItem->product_id)
                                                            ->where('variant_id', $variantId)
                                                            ->value('graphic') ??
                                                        \App\Models\ProductGraphics::where(
                                                            'product_id',
                                                            $firstItem->product_id,
                                                        )->value('graphic');
                                                } else {
                                                    $combination = null;
                                                    $variantId = null;
                                                    $img = null;
                                                }
                                            @endphp
                                        <div class="order-list">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="product-img">
                                                        <img src="{{ url('uploads/products/' . $img) }}" style="width: 200px; height: 150px;"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="active-order-list">
                                                        <h5>{{ $firstItem ? @$firstItem->product->name : 'Product Name Not Available' }}
                                                        <span class="delevery-status">Cancelled</span></h5>
                                                        <p class="order-date mt-10">Ordered on: <?php  echo date("d-m-Y H:i",strtotime($order->created_at));  ?></p>
                                                        <h4 class="rate-order mt-10">₹{{ $order->total }}</h4>
                                                        <p class="delevery-date mt-10"> <a href="javascript:void(0)" class="track-order" id="openModalBtn" data-orderId="{{ $order->id }}"> Track Order </a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                    <!-- Cancelled Order -->
                                </div>
                            </div>
                        </div>

                        <div class="card-white mt-20">
                            <div class="card mb-3">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="accordio-heading collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#headingThree" aria-controls="headingThree" aria-expanded="false">
                                          Referal Customer List
                                        </button>
                                    </h5>
                                </div>
                                <div id="headingThree" class="collapse" aria-labelledby="headingThree" data-bs-parent="#general-question">
                                    <div class="card-body">
                                        @if($referalCustomerList)
                                        <table style="width:100%;border:var(--bs-border-color-translucent);">
                                            <thead>
                                                <th>Sr. No.</th>
                                                <th>Customer Name</th>
                                                <th>Total order</th>
                                                <th>Used Referal Code</th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @php 
                                                    $i = 1;
                                                    $totalOrdercount = 0;
                                                    @endphp
                                                    @foreach($referalCustomerList as $customerId => $referalCustomer)
                                                    <?php
                                                    $customerDetail = getUserById($customerId);
                                                    $totalOrdercount += $referalCustomer['total_count'];
                                                    ?>
                                                    <tr style="border-bottom:1px solid #d3cccc;margin-bottom:1px">
                                                        <td>{{  $i }}</td>
                                                        <td>{{  @$customerDetail->name }}</td>
                                                        <td>
                                                            <a href="javascript:void('0')" data-bs-toggle="modal" data-bs-target="#CustomerWiseOrder" class="CustomerWiseOrder"  data-customerId="<?php echo $customerId; ?>" data-affiliateId="<?php echo Auth::guard('customer')->user()->id ?>" >
                                                                {{  @$referalCustomer['total_count'] }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            if(isset($referalCustomer['coupon_name'])){
                                                                foreach(@$referalCustomer['coupon_name'] as $coupon){
                                                                    if(isReferalCodeBlocked(Auth::guard('customer')->user()->id,$customerId,$coupon)){
                                                                        echo  $coupon . '&nbsp;&nbsp;&nbsp;&nbsp; <span class="codeBlock" data-affiliateId="'. Auth::guard('customer')->user()->id .'" data-customerId="'. $customerId .'" data-couponId="'. $coupon .'"  data-status="remove" style="color:blue;fornt-size:14px;cursor:pointer">Unblock</span></br>';
                                                                    } else {
                                                                        echo  $coupon . '&nbsp;&nbsp;&nbsp;&nbsp; <span class="codeBlock" data-affiliateId="'. Auth::guard('customer')->user()->id .'" data-customerId="'. $customerId .'" data-couponId="'. $coupon .'" data-status="add" style="color:blue;fornt-size:14px;cursor:pointer">Block</span></br>';
                                                                    }
                                                                } 
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    @php $i++; @endphp
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Total</th>
                                                    <th>{{  $totalOrdercount }}</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @else 
                                            <div class="cart-list mb-20">
                                                Customer not found.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="card-white">
                            <h3>Vender Address</h3>
                            @if(!empty($userAddressDetails))
                                @foreach($userAddressDetails as $address)
                                <div class="address-list">
                                    <table width="100%">
                                        <tr>
                                            <td>
                                                <p><?php echo $address->landmark  .' </br>'. $address->address .' </br>'. $states[$address->state_id] .' &nbsp '. $countries[$address->country_id]  .' &nbsp '.  $address->postal_code; ?>
                                                <?php if($address->is_primary==1) {  echo '<input class="form-check-input primary_address" type="radio" name="primary_address"  value="'.$address->id.'"  checked>';  } else {
                                                    echo '<input class="form-check-input primary_address" type="radio" name="primary_address"  value="'.$address->id.'" >';
                                                } ?></p>
                                            </td>
                                            <td align="right">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#add-address" class="edit-address edit_address" data-adddressId=<?php echo $address->id; ?>>  
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M13.2603 3.60022L5.05034 12.2902C4.74034 12.6202 4.44034 13.2702 4.38034 13.7202L4.01034 16.9602C3.88034 18.1302 4.72034 18.9302 5.88034 18.7302L9.10034 18.1802C9.55034 18.1002 10.1803 17.7702 10.4903 17.4302L18.7003 8.74022C20.1203 7.24022 20.7603 5.53022 18.5503 3.44022C16.3503 1.37022 14.6803 2.10022 13.2603 3.60022Z" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M11.8896 5.0498C12.3196 7.8098 14.5596 9.9198 17.3396 10.1998" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M3 22H21" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </a>
                                                <a href="javascript:void()" class="delete-address" id="removeAddressBtn" data-adddressId=<?php echo $address->id; ?> >
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M20.9997 6.72998C20.9797 6.72998 20.9497 6.72998 20.9197 6.72998C15.6297 6.19998 10.3497 5.99998 5.11967 6.52998L3.07967 6.72998C2.65967 6.76998 2.28967 6.46998 2.24967 6.04998C2.20967 5.62998 2.50967 5.26998 2.91967 5.22998L4.95967 5.02998C10.2797 4.48998 15.6697 4.69998 21.0697 5.22998C21.4797 5.26998 21.7797 5.63998 21.7397 6.04998C21.7097 6.43998 21.3797 6.72998 20.9997 6.72998Z" fill="#FF0505" />
                                                        <path d="M8.49977 5.72C8.45977 5.72 8.41977 5.72 8.36977 5.71C7.96977 5.64 7.68977 5.25 7.75977 4.85L7.97977 3.54C8.13977 2.58 8.35977 1.25 10.6898 1.25H13.3098C15.6498 1.25 15.8698 2.63 16.0198 3.55L16.2398 4.85C16.3098 5.26 16.0298 5.65 15.6298 5.71C15.2198 5.78 14.8298 5.5 14.7698 5.1L14.5498 3.8C14.4098 2.93 14.3798 2.76 13.3198 2.76H10.6998C9.63977 2.76 9.61977 2.9 9.46977 3.79L9.23977 5.09C9.17977 5.46 8.85977 5.72 8.49977 5.72Z" fill="#FF0505" />
                                                        <path d="M15.2104 22.7501H8.79039C5.30039 22.7501 5.16039 20.8201 5.05039 19.2601L4.40039 9.19007C4.37039 8.78007 4.69039 8.42008 5.10039 8.39008C5.52039 8.37008 5.87039 8.68008 5.90039 9.09008L6.55039 19.1601C6.66039 20.6801 6.70039 21.2501 8.79039 21.2501H15.2104C17.3104 21.2501 17.3504 20.6801 17.4504 19.1601L18.1004 9.09008C18.1304 8.68008 18.4904 8.37008 18.9004 8.39008C19.3104 8.42008 19.6304 8.77007 19.6004 9.19007L18.9504 19.2601C18.8404 20.8201 18.7004 22.7501 15.2104 22.7501Z" fill="#FF0505" />
                                                        <path d="M13.6601 17.25H10.3301C9.92008 17.25 9.58008 16.91 9.58008 16.5C9.58008 16.09 9.92008 15.75 10.3301 15.75H13.6601C14.0701 15.75 14.4101 16.09 14.4101 16.5C14.4101 16.91 14.0701 17.25 13.6601 17.25Z" fill="#FF0505" />
                                                        <path d="M14.5 13.25H9.5C9.09 13.25 8.75 12.91 8.75 12.5C8.75 12.09 9.09 11.75 9.5 11.75H14.5C14.91 11.75 15.25 12.09 15.25 12.5C15.25 12.91 14.91 13.25 14.5 13.25Z" fill="#FF0505" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                @endforeach
                            @endif
                            
                            <a href="#" data-bs-toggle="modal" data-bs-target="#add-address" class="add-address">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 4.1665V15.8332" stroke="#283EFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M4.16699 10H15.8337" stroke="#283EFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                Add another address
                            </a>
                        </div>

                        <div class="card-white mt-20">
                            <div class="card mb-3">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="accordio-heading collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#headingOne" aria-controls="headingOne" aria-expanded="false">
                                            Earnings & Commission Section
                                        </button>
                                    </h5>
                                </div>
                                <div id="headingOne" class="collapse" aria-labelledby="headingOne" data-bs-parent="#general-question">
                                    <div class="card-body">
                                        @if($referalOrderDelivedDetails)
                                        <table style="width:100%;border:var(--bs-border-color-translucent);">
                                            <thead>
                                                <th>Sr. No.</th>
                                                <th>Order Number</th>
                                                <th>Customer</th>
                                                <th>Referal Code</th>
                                                <th>Order amount</th>
                                                <th>Referal discount</th>
                                                <th>Referal Commission</th>
                                            </thead>
                                            <tbody>
                                                    @php 
                                                        $i = 1;
                                                        $totalOrderAmount = 0;
                                                        $toalCouponDiscount = 0;
                                                        $totalCommission  = 0;
                                                    @endphp
                                                   @foreach($referalOrderDelivedDetails as $referalOrder)
                                                    <?php
                                                    $userAddress = json_decode($referalOrder->shipping_address);
                                                    $totalOrderAmount += @$referalOrder->sub_total;
                                                    $toalCouponDiscount += @$referalOrder->coupon_discount;
                                                    
                                                    $commission_percentage = explode('@',$referalOrder->coupon_name);
                                                    $commission_percentage = end($commission_percentage);
                                                    $commission_percentage = $referalMaxPercentage - $commission_percentage;
                                                    $commission =  ($referalOrder->sub_total * $commission_percentage) / 100;
                                                    $totalCommission  += @$commission;
                                                    ?>
                                                    <tr style="border-bottom:1px solid #d3cccc;margin-bottom:1px">
                                                        <td>{{  $i }}</td>
                                                        <td>{{  @$referalOrder->order_number }}</td>
                                                        <td>
                                                            {{ $userAddress->shipping_customer_name }}</br>
                                                            {{ $userAddress->shipping_address }} ,
                                                            {{ $userAddress->shipping_city }} ,
                                                            {{ $userAddress->shipping_state }} ,
                                                            {{ $userAddress->shipping_country }} , 
                                                            {{ $userAddress->shipping_pincode }}</br>
                                                            {{ $userAddress->shipping_phone }}
                                                        </td>
                                                        <td>{{  @$referalOrder->coupon_name }}</td>
                                                        <td>{{  @$referalOrder->sub_total }}</td> 
                                                        <td>{{  @$referalOrder->coupon_discount }}</td>
                                                        <td>{{  @$commission }}</td> 
                                                    </tr>
                                                    @php $i++; @endphp
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <th colspan="4">Total</th>
                                                    <th>Rs. {{  $totalOrderAmount }}</th>
                                                    <th>Rs. {{  $toalCouponDiscount }}</th>
                                                    <th>Rs. {{  $totalCommission }}</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @else 
                                            <div class="cart-list mb-20">
                                                Order not found.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-white mt-20">
                            <div class="card mb-3">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="accordio-heading collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#headingTwo" aria-controls="headingTwo" aria-expanded="false">
                                            Payment History
                                        </button>
                                    </h5>
                                </div>
                                
                                <div id="headingTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#general-question">
                                    <div class="card-body">
                                        @if($paymentDetails)
                                        <table style="width:100%;border:var(--bs-border-color-translucent);">
                                            <thead>
                                                <th>Sr. No.</th>
                                                <th>Affiliate</th>
                                                <th>Payable Amount</th>
                                                <th>Paid Amount</th>
                                                <th>Outstanding Amount</th>
                                                <th>Description</th>
                                                <th>Transaction ID</th>
                                                <th>Transaction Type</th>
                                                <th>Date</th>
                                            </thead>
                                            <tbody>
                                                   @php 
                                                    $i = 1;
                                                    $payable_amount_total = 0;
                                                    $paid_amount_total = 0;
                                                    $outstanding_amount_total = 0;
                                                    @endphp
                                                    @foreach($paymentDetails as $payment)
                                                    <?php
                                                    $affiliateDetail = $payment->user;
                                                    if($i==1){
                                                        $outstanding_amount_total += @$payment->outstanding_amount;
                                                    }
                                                    ?>
                                                <tr style="border-bottom:1px solid #d3cccc;margin-bottom:1px">
                                                        <td>{{  $i }}</td>
                                                        <td>{{  @$affiliateDetail->name }}</td>
                                                        <td>{{  @$payment->payable_amount }}</td>
                                                        <td>{{  @$payment->paid_amount }}</td>
                                                        <td>{{  @$payment->outstanding_amount }}</td> 
                                                        <td>{{  @$payment->description }}</td>
                                                        <td>{{  @$payment->transaction_id }}</td>
                                                        <td>{{  @$payment->payment_type }}</td>
                                                        <td><?php  echo date("d-m-Y H:i",strtotime($payment->created_at));  ?></td>
                                                    </tr>
                                                    @php $i++; @endphp
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <th colspan="4">Outstanding Amount</th>
                                                    <th>Rs. {{  $outstanding_amount_total }}</th>
                                                    <th colspan="4"></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @else 
                                            <div class="cart-list mb-20">
                                                Payment Histroy not found.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- cart main wrapper end -->
    </main>
    <!-- page main wrapper end -->


    <!-- Edit profile modal start -->
    <div class="modal" id="edit-profile">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- product details inner end -->
                    <form id="update-dashboard" action="{{ route('front-user.updateProfile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="edit-account">
                            <div class="profile-img-change">
                                <div class="profile-pic-wrapper">
                                    <div class="pic-holder">
                                        <!-- uploaded pic shown here -->
                                        <img id="profilePic" class="pic" src="{{ $user->image }}" />
                                        <Input class="uploadProfileInput" type="file" name="image" id="newProfilePhoto" accept="image/*" style="opacity: 0;" />
                                        <label for="newProfilePhoto" class="upload-file-block">
                                            <div class="text-center">
                                                <div class="mb-2">
                                                    <i class="fa fa-camera fa-2x"></i>
                                                </div>
                                                <div class="text-uppercase">
                                                    Update <br /> Profile Photo
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-30">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" id="name" class="form-control login"  value="{{ $user->name }}"/>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text"  name="email-disabled" id="email-disabled" class="form-control login" value="{{ $user->email }}" disabled/>
                                        <input type="hidden"  name="email" id="email" class="form-control login" value="{{ $user->email }}" />
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>Phone number</label>
                                        <input type="text" name="phone_number" id="phone_number" class="form-control login" value="{{ $user->phone_number }}" />
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>DOB</label>
                                        <input type="date" placeholder="Dob" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ $user->date_of_birth }}" />
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select class="form-control" name="gender" id="gender">
                                            <option value="male" <?php if($user->gender=='male'){ echo "selected"; }  ?> >Male</option>
                                            <option value="female" <?php if($user->gender=='female'){ echo "selected"; }  ?>>Female</option>
                                            <option value="other" <?php if($user->gender=='other'){ echo "selected"; }  ?>>Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="sqr-btn mt-3 d-block">Update
                                            <svg width="30" height="8" viewBox="0 0 30 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z" fill="black" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- product details inner end -->
                </div>
            </div>
        </div>
    </div>
    <!-- Edit profile modal end -->

    <!-- add address modal start -->
    <div class="modal" id="add-address">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add New Address</h5>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- product details inner end -->
                    <form id="addAddressFrom" autocomplete="off">
                    @csrf
                        <div class="edit-account">
                            <div class="row">
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
                                    <div class="form-group">
                                        <label>Country</label>
                                        <select class="form-control login" name="country_id" id="country" autocomplete="off">
                                            <option value="" selected>Country/Region</option>
                                            <option value="101">India</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label>State</label>
                                        <select class="form-control login city_dropdown" name="state_id" id="state" autocomplete="off">
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
                                        <select class="form-control login city" name="city_id" id="city" autocomplete="off">
                                            <option value="">Select city</option>
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
                                        <select class="form-control login" name="type" id="type" autocomplete="off">
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
                                                        Home
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input address_type_office" type="radio" name="address_type" id="office" value="2">
                                                <label class="form-check-label" for="office">
                                                    <div class="sp-content">
                                                        Office
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input address_type_other" type="radio" name="address_type" id="Others" value="3">
                                                <label class="form-check-label" for="Others">
                                                    <div class="sp-content">
                                                        Others
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
                    <!-- product details inner end -->
                </div>
            </div>
        </div>
    </div>
    <!-- add address modal end -->


    <!-- add card modal start -->
    <div class="modal" id="add-card">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!-- product details inner end -->
                    <div class="edit-account">
                        <div class="row mt-30">
                            <div class="col-lg-12 col-md-6">
                                <div class="form-group">
                                    <label>Card Holder Name</label>
                                    <input type="text" class="form-control login" />
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="form-group">
                                    <label>Card number</label>
                                    <input type="number" maxlength="12" class="form-control login" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>Valid Exp. date</label>
                                    <input type="date" class="form-control login" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label>CVV</label>
                                    <input type="number" maxlength="3" class="form-control login" />
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group">
                                    <a href="#" class="sqr-btn mt-3 d-block">
                                        Save
                                        <svg width="30" height="8" viewBox="0 0 30 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z" fill="black" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product details inner end -->
                </div>
            </div>
        </div>
    </div>
    <!-- add address modal end -->


<!-- add track order detail modal start -->
<div class="modal fade" id="orderTrackModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="overflow: scroll;max-height: 800px;">
      <div class="modal-header">
        <h5 class="modal-title">Order details</h5>
        <button type="button" class="close orderTrackModalClose" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="orderDetailContent">
        <!-- dynamic order details will be loaded here -->
        <!-- product details inner end -->
      </div>
    </div>
  </div>
</div>
<!-- add track order detail modal end -->

<!-- order show Customer wise for vendor dashboard -->
<div class="modal fade" id="CustomerWiseOrder" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="overflow: scroll;max-height: 800px;">
      <div class="modal-header">
        <h5 class="modal-title">Order details</h5>
        <button type="button" class="close CustomerWiseOrderCloseBtn" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="CustomerWiseOrderBody">

        <div class="order-list">
            <div class="row">
                <div class="col-md-3">
                    <div class="product-img">
                        <img src="http://127.0.0.1:8000/uploads/products/APR2026/variant_10_69e8935ff0d5c.jpg" style="width: 200px; height: 150px;">
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="active-order-list">
                        <h5>Cotton Block Print Dress
                        <span class="delevery-status">Delivered</span></h5>
                        <p class="order-date mt-10">Ordered on: 23-04-2026 11:13</p>
                        <h4 class="rate-order mt-10">₹2000</h4>
                        <p class="delevery-date mt-10"> <a href="javascript:void(0)" class="track-order" id="openModalBtn" data-orderid="68"> Track Order </a></p>
                    </div>
                </div>
            </div>
        </div>

      </div>
    </div>
  </div>
</div>
<!-- order show Customer wise for vendor dashboard -->


    <!-- Scroll to top start -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- Scroll to Top End -->
@endsection

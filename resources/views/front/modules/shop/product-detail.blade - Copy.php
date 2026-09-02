@extends('front.layouts.app')
@section('content')
<style>
    /* Kill Bootstrap default icons */
    .accordion-button {
        --bs-accordion-btn-icon: none;
        --bs-accordion-btn-active-icon: none;
    }

    /* Custom arrow */
    .accordion-button::after {
        background-image: none !important;
        content: "▼";
        font-size: 14px;
        transition: transform 0.2s ease;
    }

    /* Open state */
    .accordion-button:not(.collapsed)::after {
        content: "▲";
    }
    .disabled-action {
        pointer-events: none;   /* disables click */
        opacity: 0.5;           /* visual disabled */
        cursor: not-allowed;
    }
</style>    
    
    <section class="product-detail-sec space-sec-inner">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    {{-- MOBILE SLIDER --}}
                    <div class="d-block d-md-none">
                        <div id="productImageSlider" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @php
                                    $colorArr = json_decode(request()->query('colorArr'));
                                    $sizeArr = json_decode(request()->query('sizeArr'));
                                    // Pehle order set kar lete hain: front -> back -> rest
                                    $frontImages = $product->product_main_images->where('is_front', 1)->sortBy('updated_at');
                                    $backImages = $product->product_main_images->where('is_back', 1);
                                    $otherImages = $product->product_main_images
                                        ->where('is_front', '!=', 1)
                                        ->where('is_back', '!=', 1);

                                    $orderedImages = $frontImages->merge($backImages)->merge($otherImages);
                                    
                                    $prod = $product->toArray();
                                    $availableVariants = $prod['product_variants'] ?? [];
                                    if(!empty($availableVariants)){
                                        $updateVariantImages = [];
                                        foreach($availableVariants as $vkey => $variant){
                                            $variantValues = !empty($variant['variant_values']) ? $variant['variant_values'] : [];                                        
                                            foreach($variantValues as $vvkey => $variantValue){
                                                if(!empty($variantValue['variant_value_id'])){
                                                    $updateVariantImages[] = $variantValue['variant_value_id'];
                                                }
                                            }
                                        }
                                        if(!empty($updateVariantImages)){
                                            $updateVariantImages = updateDeletedVariantImages($prod['id'], $updateVariantImages);
                                        }
                                    }
                                @endphp

                                @php $i = 0; @endphp

                                @foreach ($orderedImages as $image)
                                    @if (!$colorArr || $image['variant_id'] == @$colorArr[0])
                                        <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                                            @if ($image['graphic_type'] == 'image')
                                                <img src="{{ asset('uploads/products/' . $image['graphic']) }}"
                                                    class="d-block w-100"
                                                    alt="{{ $product->name }}">
                                            @else
                                                <video class="w-100" controls>
                                                    <source src="{{ asset('uploads/products/' . $image['graphic']) }}" type="video/mp4">
                                                </video>
                                            @endif
                                        </div>
                                        @php $i++; @endphp
                                    @endif
                                @endforeach

                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#productImageSlider" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productImageSlider" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    </div>
                    <div class="d-none d-md-block">
                        <div class="detail-grid">
                            <div class="row">

                                @php
                                    $colorArr = json_decode(request()->query('colorArr'));
                                    $sizeArr = json_decode(request()->query('sizeArr'));
                                    // Pehle order set kar lete hain: front -> back -> rest
                                    $frontImages = $product->product_main_images->where('is_front', 1)->sortBy('updated_at');
                                    $backImages = $product->product_main_images->where('is_back', 1);
                                    $otherImages = $product->product_main_images
                                        ->where('is_front', '!=', 1)
                                        ->where('is_back', '!=', 1);

                                    $orderedImages = $frontImages->merge($backImages)->merge($otherImages);
                                    $prod = $product->toArray();
                                    $availableVariants = $prod['product_variants'] ?? [];
                                    if(!empty($availableVariants)){
                                        $updateVariantImages = [];
                                        foreach($availableVariants as $vkey => $variant){
                                            $variantValues = !empty($variant['variant_values']) ? $variant['variant_values'] : [];                                        
                                            foreach($variantValues as $vvkey => $variantValue){
                                                if(!empty($variantValue['variant_value_id'])){
                                                    $updateVariantImages[] = $variantValue['variant_value_id'];
                                                }
                                            }
                                        }
                                        if(!empty($updateVariantImages)){
                                            $updateVariantImages = updateDeletedVariantImages($prod['id'], $updateVariantImages);
                                        }
                                    } 

                                   // detail page first selected varient front, second back then all rest images
                                    $activeVarientId = activeVarientByProductId($product->product_main_images->first()->product_id);
                                    $selectedVarientImages = $product->product_main_images->where('variant_id', $activeVarientId);
                                    $frontImages = $selectedVarientImages->where('is_front', 1);
                                    $backImages = $selectedVarientImages->where('is_back', 1);
                                    $otherImages = $selectedVarientImages->where('is_front', '!=', 1)->where('is_back', '!=', 1);
                                    $orderedImages = $frontImages->merge($backImages)->merge($otherImages);
                                @endphp

                                @foreach ($orderedImages as $image)
                                    <div class="col-md-6 detail-grid-img">
                                        @if ($image['graphic_type'] == 'image')
                                            <a data-bs-toggle="modal" data-bs-target="#modal1">
                                                <div class="pro-nav-thumb">
                                                    <img src="{{ asset('uploads/products/' . $image['graphic']) }}"
                                                        alt="{{ $product->name }}" class="default-image"
                                                        id="main-image" style="order: {{ $loop->index }}">
                                                </div>
                                                <div class="thumbnail-row d-flex mt-2"></div>
                                            </a>
                                        @else
                                            <video width="100%" height="350" controls>
                                                <source src="{{ asset('uploads/products/' . $image['graphic']) }}"
                                                    type="video/mp4">
                                            </video>
                                        @endif
                                    </div>
                                @endforeach

                                <!-- @foreach ($orderedImages as $key => $image)
                                    @if ($colorArr)
                                    
                                        @foreach ($productvariants[0]['variant_values'] as $variantData)
                                            @if ($image['variant_id'] == @$colorArr[0])
                                                <div class="col-md-6 detail-grid-img">
                                                    @if ($image['graphic_type'] == 'image')
                                                        <a data-bs-toggle="modal" data-bs-target="#modal1">
                                                            <div class="pro-nav-thumb">
                                                                <img src="{{ asset('uploads/products/' . $image['graphic']) }}"
                                                                    alt="{{ $product->name }}" class="default-image"
                                                                    id="main-image" style="order: {{ $loop->index }}">
                                                            </div>
                                                            <div class="thumbnail-row d-flex mt-2"></div>
                                                        </a>
                                                    @else
                                                        <video width="100%" height="350" controls>
                                                            <source src="{{ asset('uploads/products/' . $image['graphic']) }}"
                                                                type="video/mp4">
                                                        </video>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach ($productvariants[0]['variant_values'] as $variantData)
                                            @if ($variantData['variant_value_id'] == $image['variant_id'] && $variantData['is_main'] == true)
                                                <div class="col-md-6 detail-grid-img">
                                                    @if ($image['graphic_type'] == 'image')
                                                        <a data-bs-toggle="modal" data-bs-target="#modal1">
                                                            <div class="pro-nav-thumb">                                                           
                                                                <img src="{{ asset('uploads/products/' . $image['graphic']) }}"
                                                                    alt="{{ $product->name }}" class="default-image"
                                                                    id="main-image">
                                                            </div>
                                                            <div class="thumbnail-row d-flex mt-2"></div>
                                                        </a>
                                                    @else
                                                        <video width="100%" height="350" controls>
                                                            <source src="{{ asset('uploads/products/' . $image['graphic']) }}"
                                                                type="video/mp4">
                                                        </video>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach -->
                            </div>
                        </div>
                    </div>    
                    <!-- <div class="faq-inner mt-5">
                        <div class="accordion" id="accordionExample">
                            @if (!empty($product->product_details))
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Product Details
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                                {!! $product->product_details !!}

                                            </p>

                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (!empty($product->specification))
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Product Specification
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                                {!! $product->specification !!}

                                            </p>

                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (!empty($returnexchangeProduct->value))
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            Delivery & Returns
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                                {!! $returnexchangeProduct->value !!}

                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (!empty($product->wash_care))
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                            aria-expanded="false" aria-controls="collapseFour">
                                            Wash & Care
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse"
                                        aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>
                                                {!! $product->wash_care !!}

                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            @if (isset($contactDetails))
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFive">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                            aria-expanded="false" aria-controls="collapseFive">
                                            Need Help
                                        </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse"
                                        aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            @foreach ($contactDetails as $key => $value)
                                                @if ($key == 0)
                                                    <p><i class="fa fa-envelope" aria-hidden="true"></i>
                                                        {{ $value->value }}</p>
                                                @elseif($key == 1)
                                                    <p><i class="fa fa-phone" aria-hidden="true"></i> {{ $value->value }}
                                                    </p>
                                                @else
                                                    <p> <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                                        {{ $value->value }}</p>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div> -->
                </div>
                <div class="col-md-5">
                    <div class="detail-head">
                        <h4 class="title">{{ $product->name ?? '' }}</h4>
                        <p class="title">{{ $product->short_description ?? '' }}</p>
                        {{-- {{ $product->sku }}_<span
                            id="productSku">{{ $productVarientCom[0] ? $productVarientCom[0]->sku : '' }}</span>--}}
                        <div class="price-box">
                            <p class="price-text"><span
                                    id="productPrice">₹{{ $productVarientCom[0] ? floor($productVarientCom[0]->selling_price) : '' }}
                                </span>
                                @if ($product->discount > 0)
                                    <del
                                        id="pdpStrikedMrp">MRP:₹{{ $productVarientCom[0] ? floor($productVarientCom[0]->price) : '' }}</del>
                                @endif
                            </p>
                            @if ($productVarientCom[0]->discount_type === 'flat' && $productVarientCom[0]->discount > 0)
                                <span class="off-tag"
                                    id="pdpDiscountRight">{{ rtrim(rtrim(floor($productVarientCom[0]->discount) ?? 0, '0'), '.') }}
                                    Rs Off</span>
                            @elseif ($productVarientCom[0]->discount_type === 'percentage' && $productVarientCom[0]->discount > 0 )
                                <span class="off-tag"
                                    id="pdpDiscountRight">{{ floor($productVarientCom[0]->discount) ?? 0 }}% Off</span>
                            @endif

                        </div>
                        <small>Inclusive of all taxes</small>
                    </div>
                    @php
                        $coupon = getProductCoupon();
                        $couponEndDate = '';
                    @endphp
                    @if (!empty($coupon))
                        <div class="pro_deal_offer_sec">
                            <h5>{{ $coupon['name'] }}</h5>


                            @if (!empty($coupon['end_date']) && \Carbon\Carbon::parse($coupon['end_date'])->gte(\Carbon\Carbon::today()))
                                @php
                                    $couponEndDate = \Carbon\Carbon::parse($coupon['end_date'])
                                        ->setTimezone('Asia/Kolkata')
                                        ->format('d F Y H:i:s \G\M\TP');
                                @endphp
                                <div id="timer" class="pro_counter">
                                    <div id="days"></div>
                                    <div id="hours"></div>
                                    <div id="minutes"></div>
                                    <div id="seconds"></div>
                                </div>
                            @endif
                            <div class="coupon_code_description d-flex justify-content-center align-items-center gap-2">
                                <button type="button" class="btn_coupon_code m-0" data-code="{{ $coupon['coupon_code'] }}">
                                    <div class="btn_coupon_icon"><svg viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M23.4383 10.644L21.6138 8.81723C21.3017 8.50476 21.0497 7.89184 21.0497 7.45919V4.8633C21.0497 3.80571 20.1855 2.94042 19.1292 2.94042H16.5486C16.1164 2.94042 15.5043 2.68804 15.1922 2.37557L13.3678 0.548828C12.6236 -0.196289 11.3993 -0.196289 10.6551 0.548828L8.80663 2.37557C8.50655 2.68804 7.8944 2.94042 7.45029 2.94042H4.86965C3.81339 2.94042 2.94917 3.80571 2.94917 4.8633V7.44718C2.94917 7.87983 2.69711 8.49274 2.38503 8.80521L0.56058 10.632C-0.183605 11.3771 -0.183605 12.6029 0.56058 13.348L2.38503 15.1748C2.69711 15.4872 2.94917 16.1002 2.94917 16.5328V19.1167C2.94917 20.1743 3.81339 21.0396 4.86965 21.0396H7.45029C7.8824 21.0396 8.49455 21.2919 8.80663 21.6044L10.6311 23.4312C11.3753 24.1763 12.5996 24.1763 13.3438 23.4312L15.1682 21.6044C15.4803 21.2919 16.0924 21.0396 16.5245 21.0396H19.1052C20.1615 21.0396 21.0257 20.1743 21.0257 19.1167V16.5328C21.0257 16.1002 21.2777 15.4872 21.5898 15.1748L23.4143 13.348C24.1945 12.6149 24.1945 11.3891 23.4383 10.644ZM7.19823 8.3966C7.19823 7.73561 7.73836 7.1948 8.39853 7.1948C9.05869 7.1948 9.59883 7.73561 9.59883 8.3966C9.59883 9.05759 9.07069 9.5984 8.39853 9.5984C7.73836 9.5984 7.19823 9.05759 7.19823 8.3966ZM9.03469 16.2444C8.85464 16.4246 8.62659 16.5088 8.39853 16.5088C8.17047 16.5088 7.94241 16.4246 7.76237 16.2444C7.41428 15.8958 7.41428 15.319 7.76237 14.9705L14.9642 7.75964C15.3122 7.41112 15.8884 7.41112 16.2365 7.75964C16.5846 8.10817 16.5846 8.68503 16.2365 9.03356L9.03469 16.2444ZM15.6003 16.8092C14.9282 16.8092 14.388 16.2684 14.388 15.6074C14.388 14.9464 14.9282 14.4056 15.5883 14.4056C16.2485 14.4056 16.7886 14.9464 16.7886 15.6074C16.7886 16.2684 16.2605 16.8092 15.6003 16.8092Z"
                                                fill="currentColor"></path>
                                        </svg></div>
                                    Coupen Code : {{ $coupon['coupon_code'] }}
                                </button>
                                <div class="description_data">
                                    <i class="fa fa-info-circle" data-bs-toggle="tooltip" data-bs-html="true"
                                        title="{{ $coupon['description'] }}"></i>
                                </div>
                            </div>
                        </div>
                    @endif                    
                    <div class="select-box mt-2">

                        <ul class="color-list">
                            @foreach ($productvariants as $variant)
                                @php
                                    $hasMain = collect($variant['variant_values'])->where('is_main', 1)->isNotEmpty();
                                    $activeValue =
                                        collect($variant['variant_values'])->first(fn($val) => $val['is_main'] == 1) ??
                                        ($variant['variant_values'][0] ?? null);
                                @endphp
                                <div class="variant-box my-3">
                                    <h5 class="variant-header">
                                        {{ ucFirst($variant['variant_name']) }}:
                                        <span id="selected-value-{{ $variant['id'] }}">
                                            {{ $activeValue ? $activeValue['name'] : '' }}
                                        </span>

                                        @if ($variant['variant_name'] == 'Size')
                                            <span class="size-chart-link size-chart">SIZE CHART <span
                                                    class="arrow">›</span></span>
                                        @endif
                                    </h5>
                                    @php
                                        //prx($variant,0);
                                    @endphp
                                    <ul class="variant-list d-flex flex-wrap">

                                        @foreach ($variant['variant_values'] as $k => $value)
                                            @php
                                                $type = $variant['variant_type'];
                                                $color = $value['color_code'];
                                                $name = $value['name'];
                                                $image = $value['image']
                                                    ? asset('uploads/products/' . $value['image'])
                                                    : asset('img/no-image.jpg');
                                                $variantName = $variant['variant_name'];
                                                $isActive =
                                                    ($hasMain && $value['is_main'] == 1) || (!$hasMain && $k == 0);
                                                if ($colorArr) {
                                                    $isActive = $value['variant_value_id'] == @$colorArr[0] ? 1 : 0;
                                                }

                                            @endphp

                                            @if (!in_array($type, [1, 2, 4, 5, 7]))
                                                <li data-productId = "{{ $product->id }}"
                                                    data-id="{{ $variant['id'] }}" data-type="{{ $variantName }}"
                                                    data-value="{{ $name }}"
                                                    data-vid="{{ $value['variant_value_id'] }}"
                                                    onclick="selectVariant(this); checkVariantStock(this);"
                                                    class="s-variant 
                                                {{ in_array($type, [3]) ? 's-variant-round' : '' }} 
                                                {{ $isActive ? 'active' : '' }} mx-1"
                                                    style="
                                                    {{ in_array($type, [3, 6]) ? 'background-image:url(' . $image . '); background-size:cover;' : '' }}
                                                    width: 40px; height: 40px; cursor: pointer; border: 2px solid #ccc;
                                                ">
                                                </li>
                                            @endif
                                        @endforeach
                                        @foreach ($variant['variant_values'] as $k => $value)
                                            @php
                                                $productOut = 0;
                                                $type = $variant['variant_type'];
                                                $color = $value['color_code'];
                                                $name = $value['name'];
                                                $image = $value['image']
                                                    ? asset('uploads/products/' . $value['image'])
                                                    : asset('img/no-image.jpg');
                                                $variantName = $variant['variant_name'];
                                                $isActive =
                                                    ($hasMain && $value['is_main'] == 1) || (!$hasMain && $k == 0);
                                                if ($sizeArr) {
                                                    $isActive = $value['variant_value_id'] == @$sizeArr[0] ? 1 : 0;
                                                }
                                                
                                            @endphp

                                            @if (in_array($type, [1, 2, 4, 5, 7]))
                                                <li data-productId = "{{ $product->id }}"
                                                    data-id="{{ $variant['id'] }}" data-type="{{ $variantName }}"
                                                    data-value="{{ $name }}"
                                                    data-vid="{{ $value['variant_value_id'] }}"
                                                    onclick="selectVariant(this)"
                                                    class="s-variant
                                                {{ $type == 7 ? 's-variant-rectangle' : '' }}
                                                {{ $type == 1 ? 's-variant-round' : '' }}
                                                {{ $type == 4 ? 's-variant-round' : '' }} 
                                                {{ $isActive ? 'active' : '' }} mx-1"
                                                    style="
                                                    {{ in_array($type, [4, 5]) ? 'background-color:' . $color . ';' : '' }}
                                                    width: 40px; height: 40px; cursor: pointer; border: 2px solid #ccc;
                                                ">
                                                    {{ $name }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </ul>
                        <span class="varient_less_than_min_qty_notice blink_me" style="color:red;"></span>
                        <style>
                            .blink_me { animation: blinker 1s linear infinite; }
                            @keyframes blinker { 50% { opacity: 0; } }
                        </style>
                    </div>
                    
                    <!-- <div id="variantOutOfStock"
                        class="mt-4 mb-5 add-product-sec shop-d-box {{ $product->in_stock == 1 ? '' : 'd-none' }}"
                        data-product-out="{{ $product->in_stock == 1 ? 1 : 0 }}">
                        <div class="border border-danger rounded p-3 text-center">
                            <span class="badge bg-danger px-3 py-2 fs-6">
                                Out of Stock
                            </span>
                        </div>
                    </div> -->

                    @if($product->in_stock == '0')
                    <div class="mt-4 mb-3 add-product-sec shop-d-box">
                        <button type="button" class="btn_coupon_code m-0"> Out Of Stock </button>
                    </div>
                    @endif

                   
                    <div class="mt-4 mb-3 add-product-sec shop-d-box" style="margin-top:0px !important">
                        <div class="btn-action add-to-cart {{ $product->in_stock == 0 ? 'disabled-action' : '' }}">
                             @if($product->in_stock == '1')
                            <button type="button" name="add" class="detail-cart-btn me-3 addToCartBtn addToCartText"
                                data-id="{{ $product->id }}" 
                                data-name="{{ $product->name }}"
                                data-sku="{{ $product->sku }}"
                                data-price="{{ $productVarientCom[0]->price }}"
                                data-salePrice="{{ $productVarientCom[0]->selling_price }}"
                                data-discountType="{{ $productVarientCom[0]->discount_type }}"
                                data-discount="{{ $productVarientCom[0]->discount }}"
                                data-tax-arr="{{ e(json_encode($categoryTaxes)) }}">
                                Add To Cart
                            </button>
                             @endif
                            <!-- <a id="buy_now_auto_add_to_cart" href="{{ route('front-product.checkoutBag') }}" name="add"
                                class="buy-now-btn me-3">Buy Now</a> -->
                                @if($product->in_stock == '1')
                                <a id="buy_now_auto_add_to_cart" href="javascript:void('0')" name="add"
                                class="buy-now-btn me-3">Buy Now</a>
                                 @endif

                             
                            <span class=" sm-box addtoWishList" data-product-id="{{ $product->id }}">
                                @if (isset($isWishlisted))
                                    <i class="{{ $isWishlisted ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                @else
                                    <i class="fa-regular fa-heart"></i>
                                @endif
                            </span>
                        </div>
                        <!-- <hr />
                        <div class="select-box mt-4">

                            <div class="order-qoutes">
                                <h4>Orders more than 10 Items? <i class="fa-solid fa-boxes-packing"></i></h4>
                                <span>Contact us for dedicated support and special pricing.</span>
                                <a href="" data-bs-toggle="modal" data-bs-target="#get-quote">Get Quote</a>
                            </div>
                        </div> -->
                        <!-- <hr /> -->
                        <!-- <div class="locate-sec select-box">
                            <h5><i class="fa-solid fa-location-dot"></i> &nbsp;Check Delivery Time</h5>
                            <div class="locate-form">
                                <input type="text" id="pincodeInput" maxlength="6" placeholder="302012"
                                    class="form-control" />


                                <button class="btn" onclick="calculateDelivery()">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" x="0"
                                        y="0" viewBox="0 0 469.333 469.333" style="enable-background: new 0 0 512 512;"
                                        xml:space="preserve" class="">
                                        <g>
                                            <path
                                                d="M234.667 149.333c-47.147 0-85.333 38.187-85.333 85.333S187.52 320 234.667 320 320 281.813 320 234.667s-38.187-85.334-85.333-85.334zm190.72 64C415.573 124.373 344.96 53.76 256 43.947V0h-42.667v43.947C124.373 53.76 53.76 124.373 43.947 213.333H0V256h43.947c9.813 88.96 80.427 159.573 169.387 169.387v43.947H256v-43.947C344.96 415.573 415.573 344.96 425.387 256h43.947v-42.667h-43.947zM234.667 384c-82.453 0-149.333-66.88-149.333-149.333s66.88-149.333 149.333-149.333S384 152.213 384 234.667 317.12 384 234.667 384z"
                                                fill="#ffffff" opacity="1" data-original="#000000" class="">
                                            </path>
                                        </g>
                                    </svg>
                                    Locate
                                </button>

                            </div>
                            <p id="delivery_time">

                            </p>
                        </div> -->
                        <div class="delevery-step">
                            <li>
                                <figure>
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="50" x="0"
                                        y="0" viewBox="0 0 512.002 512.002" style="enable-background: new 0 0 512 512;"
                                        xml:space="preserve" class="">
                                        <g>
                                            <circle cx="149.996" cy="346.001" r="50"
                                                style="fill-rule: evenodd; clip-rule: evenodd; stroke-width: 20; stroke-linecap: round; stroke-linejoin: round; stroke-miterlimit: 22.9256;"
                                                transform="rotate(-25.671 149.991 345.99)" fill-rule="evenodd"
                                                clip-rule="evenodd" fill="none" stroke="#fc2424" stroke-width="20"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                stroke-miterlimit="22.9256" data-original="#000000" class=""
                                                opacity="1"></circle>
                                            <path d="M149.993 346.001H150"
                                                style="fill-rule: evenodd; clip-rule: evenodd; stroke-width: 20; stroke-linecap: round; stroke-linejoin: round; stroke-miterlimit: 22.9256;"
                                                fill-rule="evenodd" clip-rule="evenodd" fill="none" stroke="#fc2424"
                                                stroke-width="20" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-miterlimit="22.9256" data-original="#000000" class=""
                                                opacity="1"></path>
                                            <circle cx="402.006" cy="346.001" r="50"
                                                style="fill-rule: evenodd; clip-rule: evenodd; stroke-width: 20; stroke-linecap: round; stroke-linejoin: round; stroke-miterlimit: 22.9256;"
                                                transform="rotate(-19.898 402.064 346.003)" fill-rule="evenodd"
                                                clip-rule="evenodd" fill="none" stroke="#fc2424" stroke-width="20"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                stroke-miterlimit="22.9256" data-original="#000000" class=""
                                                opacity="1"></circle>
                                            <path
                                                d="M402.002 346.001h.007M397.014 151.001v75h84.987c11.792 0 20 8.458 20 20v110h-49.496m18.361-131.407-33.855-78.593h-79.999m-5.005 160v-190H70.003l-20 240h49.496m339.082-45h58.421m-145.496 45H200.499m-145.497-45h58.172m73.65 0h178.607M79.089 262.251H10M149.089 213.501H40M104.089 164.751H25M186.133 164.751h-37.044M212.611 213.501h-18.522"
                                                style="fill-rule: evenodd; clip-rule: evenodd; stroke-width: 20; stroke-linecap: round; stroke-linejoin: round; stroke-miterlimit: 22.9256;"
                                                fill-rule="evenodd" clip-rule="evenodd" fill="none" stroke="#fc2424"
                                                stroke-width="20" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-miterlimit="22.9256" data-original="#000000" class=""
                                                opacity="1"></path>
                                        </g>
                                    </svg>
                                </figure>
                                <span>Free Delivery</span>
                            </li>
                            <li>
                                <figure>
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="35" height="35" x="0"
                                        y="0" viewBox="0 0 120 120" style="enable-background: new 0 0 512 512;"
                                        xml:space="preserve" class="">
                                        <g>
                                            <g data-name="Layer 2">
                                                <path
                                                    d="M120 60A59.895 59.895 0 1 1 .21 60a4 4 0 0 1 8 0 51.946 51.946 0 1 0 5.395-23.105h8.364a4 4 0 0 1 0 8H4a4 4 0 0 1-4-4V21.791a4 4 0 0 1 8 0v8.623A59.875 59.875 0 0 1 120 60zM56 79.514V63.677C46.882 62.191 40 55.727 40 48s6.882-14.19 16-15.678V28a4 4 0 0 1 8 0v4.322C73.118 33.81 80 40.273 80 48a4 4 0 0 1-8 0c0-3.406-3.394-6.387-8-7.514v15.836C73.118 57.81 80 64.273 80 72s-6.882 14.19-16 15.677V92a4 4 0 0 1-8 0v-4.323C46.882 86.191 40 79.727 40 72a4 4 0 0 1 8 0c0 3.406 3.394 6.387 8 7.514zm8-15.028v15.028c4.606-1.127 8-4.108 8-7.514s-3.394-6.387-8-7.514zm-8-8.972V40.486c-4.606 1.127-8 4.108-8 7.514s3.394 6.387 8 7.514z"
                                                    data-name="refund" fill="#fc2424" opacity="1"
                                                    data-original="#000000" class=""></path>
                                            </g>
                                        </g>
                                    </svg>
                                </figure>
                                <span>7 days Refund</span>
                            </li>
                            <li>
                                <figure>
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="35" height="35" x="0"
                                        y="0" viewBox="0 0 32 32" style="enable-background: new 0 0 512 512;"
                                        xml:space="preserve" class="">
                                        <g>
                                            <path
                                                d="M25.846 28.356h-.476a1 1 0 0 1 0-2h.476a3.153 3.153 0 0 0 3.153-3.153V9.074a3.15 3.15 0 0 0-.923-2.228l-1.567-1.567a3.154 3.154 0 0 0-2.23-.924H7.72c-.836 0-1.638.332-2.23.924L3.922 6.847a3.152 3.152 0 0 0-.923 2.229v14.126a3.153 3.153 0 0 0 3.153 3.153h13.477v2H6.153A5.153 5.153 0 0 1 1 23.202V9.076a5.15 5.15 0 0 1 1.51-3.644l1.567-1.567a5.158 5.158 0 0 1 3.645-1.509h16.559a5.15 5.15 0 0 1 3.642 1.509l1.567 1.568a5.154 5.154 0 0 1 1.509 3.644v14.126a5.153 5.153 0 0 1-5.153 5.153z"
                                                fill="#fc2424" opacity="1" data-original="#000000" class="">
                                            </path>
                                            <path
                                                d="M1.999 6.356h28v2h-28zM18.052 29.707a1 1 0 0 1 0-1.414l.928-.928-.928-.928a1 1 0 0 1 1.414-1.414l1.815 1.815a.745.745 0 0 1 0 1.054l-1.815 1.815a.999.999 0 0 1-1.414 0zM8.081 22.165c-1.459-.259-2.452-1.64-2.452-3.122v-3.258c0-1.884.995-3.265 2.456-3.523a3.004 3.004 0 0 1 3.544 2.952v.437a1 1 0 0 1-2 0v-.437a1.001 1.001 0 0 0-2 0v4a1.001 1.001 0 0 0 2 0v-.258a1 1 0 0 1 2 0v.258a3.004 3.004 0 0 1-3.548 2.951zM15.999 22.213c-1.654 0-3-1.346-3-3v-4c0-1.654 1.346-3 3-3s3 1.346 3 3v4c0 1.654-1.346 3-3 3zm0-8c-.552 0-1 .449-1 1v4a1.001 1.001 0 0 0 2 0v-4c0-.551-.448-1-1-1zM22.906 22.213h-.27a2.265 2.265 0 0 1-2.265-2.265v-5.471a2.264 2.264 0 0 1 2.264-2.264h.272a3.464 3.464 0 0 1 3.464 3.464v3.071a3.465 3.465 0 0 1-3.465 3.465zm.071-2c.77 0 1.394-.624 1.394-1.394v-3.213c0-.77-.624-1.394-1.394-1.394a.606.606 0 0 0-.606.606v4.787c0 .335.272.606.606.606z"
                                                fill="#fc2424" opacity="1" data-original="#000000" class="">
                                            </path>
                                        </g>
                                    </svg>
                                </figure>
                                <span>Cash On Delivery</span>
                            </li>
                        </div>
                        @if (Auth::guard('customer')->user())
                            <div class="product-custome-sec">
                                <h5>Product Review By Customers</h5>
                                <a class="write-btn-review">Write a review</a>
                                <div class="write-review" style="display: none;">
                                    <div class="product-custome-sec">
                                        <h5>Product Rating</h5>
                                        <form action="{{ route('front-user.addReview') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="product_id" id="product_id"
                                                value="{{ $product->id }}">

                                            <!--<ul class="rating-review" id="starRating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <li data-star="{{ $i }}"><i
                                                            class="fa-regular fa-star"></i></li>
                                                @endfor
                                            </ul>-->
											<ul class="rating-review" id="starRating">
													<li data-star="1"><i class="fa-regular fa-star fa-solid"></i></li>
													<li data-star="2"><i class="fa-regular fa-star"></i></li>
													<li data-star="3"><i class="fa-regular fa-star"></i></li>
													<li data-star="4"><i class="fa-regular fa-star"></i></li>
													<li data-star="5"><i class="fa-regular fa-star"></i></li>
											</ul>
                                            <input type="hidden" name="rating" id="rating" value="0">
                                            @error('rating')
                                                <span class="invalid-feedback d-block"
                                                    role="alert">{{ $message }}</span>
                                            @enderror

                                            <div class="review-box">
                                                <div class="form-group">
                                                    <label>Review Title</label>
                                                    <input type="text" name="title"
                                                        class="form-control @error('title') is-invalid @enderror"
                                                        placeholder="Give your review a title"
                                                        value="{{ old('title') }}" required />
                                                    @error('title')
                                                        <span class="invalid-feedback d-block"
                                                            role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Review (5000)</label>
                                                    <textarea class="form-control @error('review') is-invalid @enderror" name="review"
                                                        placeholder="Write your comments here" value="{{ old('review') }}" required></textarea>
                                                    @error('review')
                                                        <span class="invalid-feedback d-block"
                                                            role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="upload-btn-wrapper">
                                                    <button class="btn">
                                                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="40"
                                                            height="40" x="0" y="0" viewBox="0 0 64 64"
                                                            style="enable-background: new 0 0 512 512;"
                                                            xml:space="preserve" class="">
                                                            <g>
                                                                <path
                                                                    d="M56 47.6V56c0 1.1-.4 2.1-1.2 2.8S53.1 60 52 60H12c-.5 0-1-.1-1.5-.3s-.9-.5-1.3-.9-.7-.8-.9-1.3-.3-1-.3-1.5v-8.4c0-.6.5-1.1 1.1-1.1h1.8c.6 0 1.1.5 1.1 1.1V56h40v-8.4c0-.6.5-1.1 1.1-1.1h1.8c.6 0 1.1.5 1.1 1.1z"
                                                                    fill="#000000" opacity="1" data-original="#000000"
                                                                    class=""></path>
                                                                <path
                                                                    d="m52.5 26.1-1.3 1.3c-.4.4-1.1.4-1.5 0l-2.9-2.9c-.1 0-.1-.1-.2-.2L34 11.7v36.5c0 .6-.5 1.1-1.1 1.1h-1.8c-.6 0-1.1-.5-1.1-1.1V11.7L17.4 24.3c0 .1-.1.1-.1.2l-2.9 2.9c-.4.4-1.1.4-1.5 0l-1.3-1.3c-.4-.4-.4-1.1 0-1.5l.4-.6 2.4-2.4 1.2-1.2 3-3 3.9-3.9 4.1-4.1L30 6c1.2-1.2 2.6-1.4 4 0l2.8 2.8 4.1 4.1L45 17l3.2 3.2 1.4 1.4L52 24l.5.5c.5.5.5 1.2 0 1.6z"
                                                                    fill="#000000" opacity="1" data-original="#000000"
                                                                    class=""></path>
                                                            </g>
                                                        </svg>
                                                    </button>
                                                    <input type="file" name="image[]" id="image" multiple
                                                        accept="image/*" class="form-control">
                                                    <div id="preview-area"
                                                        style="margin-top:10px; display:flex; gap:10px; flex-wrap:wrap;">
                                                    </div>
                                                </div>
                                                <p class="bottom-text">
                                                    By submitting your review, you agree to our <a
                                                        href="https://vasvi.in/page/terms-service">terms</a> and <a
                                                        href="https://vasvi.in/page/privacy-policy">privacy policy</a>
                                                </p>
                                                <div class="btn-group">
                                                    <button class="border-fill me-2" type="submit">Submit Review</button>
                                                    <button class="border-btn" type="reset">Cancel Review</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="faq-inner mt-5" style="margin-top: 1rem !important;">
                    <div class="accordion" id="accordionExample">
                        @if (!empty($product->product_details))
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Product Details
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>
                                            {!! $product->product_details !!}

                                        </p>

                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!empty($product->specification))
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Product Specification
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>
                                            {!! $product->specification !!}

                                        </p>

                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!empty($returnexchangeProduct->value))
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        Delivery & Returns
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>
                                            {!! $returnexchangeProduct->value !!}

                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!empty($product->wash_care))
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour">
                                        Wash & Care
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse"
                                    aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>
                                            {!! $product->wash_care !!}

                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif


                        @if (isset($contactDetails))
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                        aria-expanded="false" aria-controls="collapseFive">
                                        Need Help
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse"
                                    aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        @foreach ($contactDetails as $key => $value)
                                            @if ($key == 0)
                                                <p><i class="fa fa-envelope" aria-hidden="true"></i>
                                                    {{ $value->value }}</p>
                                            @elseif($key == 1)
                                                <p><i class="fa fa-phone" aria-hidden="true"></i> {{ $value->value }}
                                                </p>
                                            @else
                                                <p> <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                                    {{ $value->value }}</p>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Related Products -->
                <!-- @if (isset($releatedProduct[0])) -->
                    <!-- <div class="col-md-12 mt-5 recent-product-sec">
                        <h3>Related Products</h3>
                        <section class="women-seller custom-seller-slider women-seller-slider" id="releated-product">
                            <div class="owl-carousel owl-theme" id="releated-product-slider">
                                @foreach ($releatedProduct as $productRetVariants)
                                    @php
                                        // Pehle variant ka pehla image
                                        $firstVariantImage = optional(
                                            $productRetVariants->productVariants->first()->variantValues->first()
                                                ->first_image,
                                        )->graphic;
                                    @endphp

                                    @if ($firstVariantImage)
                                        <a
                                            href="{{ route('front-product-detail', ['sku' => $productRetVariants->sku, 'slug' => productSlug($productRetVariants->short_description)]) }}">
                                            <div class="item">
                                                <div class="product-card">
                                                    <figure>
                                                        <img src="{{ asset('uploads/products/' . $firstVariantImage) }}"
                                                            class="default-image">
                                                        <img src="{{ asset('uploads/products/' . $firstVariantImage) }}"
                                                            class="hover-image">
                                                        <span class="icon-top addtoWishList"
                                                            data-product-id="{{ $productRetVariants->id }}">
                                                            @if (isset($isWishlisteddata[0]))
                                                                <i
                                                                    class="{{ in_array($productRetVariants->id, $isWishlisteddata) ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                                            @else
                                                                <i class="fa-regular fa-heart"></i>
                                                            @endif
                                                        </span>
                                                    </figure>

                                                    {{-- Color Variations --}}
                                                    @if (isset($productRetVariants->productVariants))
                                                        <div class="color-choose">
                                                            @foreach ($productRetVariants->productVariants as $productVariantsValue)
                                                                @foreach ($productVariantsValue->variantValues as $variantValue)
                                                                    @if ($variantValue->variant_value->variant_id == 1)
                                                                        <div>
                                                                            <input
                                                                                data-image="{{ strtolower($variantValue->variant_value->name) }}"
                                                                                type="radio"
                                                                                id="{{ strtolower($variantValue->variant_value->name) }}"
                                                                                name="color_{{ $productRetVariants->id }}"
                                                                                value="{{ strtolower($variantValue->variant_value->name) }}" />
                                                                            <label
                                                                                for="{{ strtolower($variantValue->variant_value->name) }}">
                                                                                <span></span>
                                                                            </label>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                </div>
                                                <div class="bottom-content">
                                                    <p>{{ $productRetVariants->name }}</p>
                                                    <div class="price-btn-sec d-flex ">
                                                        <div class="product-color">
                                                            <ul>
                                                                <li class="price">
                                                                    ₹{{ floor($productRetVariants->selling_price) }}</li>
                                                                @if ($productRetVariants->discount > 0)
                                                                    <li class="full-price">
                                                                        ₹{{ floor($productRetVariants->buying_price) }}
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                            {!! \App\Helpers\Attributes::productDiscountMsg($productRetVariants) !!}
                                                        </div>
                                                        <div class="add-cart-btn ms-4">
                                                            <button type="button" class="boost-pfs-quickview-cart-btn"
                                                                onclick="window.location.href='{{ route('front-product-detail', ['sku' => $productRetVariants->sku, 'slug' => productSlug($productRetVariants->short_description)]) }}'">
                                                                Add To Cart
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </section>
                    </div>
                @endif -->



                <?php //echo "<pre>=====>".count($bestproduct); print_r($bestproduct);
                ?>

                
                @if (isset($related_products[0]))
                    <!--Best Sellers Products-->
                    <div class="col-md-12 mt-5 recent-product-sec">
                        <h3>Related Products </h3>
                        <section class="women-seller custom-releated-slider women-seller-slider" id="releated-product">
                            <div class="owl-carousel owl-theme" id="releated-product-slider">
                                @foreach ($related_products as $products)
                                    <?php
                                    $graphics = $products->product_main_images->where('status', 1);
                                    $frontImage = $graphics->firstWhere('is_front', 1);
                                    $backImage = $graphics->firstWhere('is_back', 1);
                                    $fallbackImages = $graphics->pluck('graphic')->take(2);
                                    
                                    $firstImage = $frontImage ? $frontImage->graphic : $fallbackImages->get(0) ?? null;
                                    $secondImage = $backImage ? $backImage->graphic : $fallbackImages->get(1) ?? $firstImage;
                                    ?>

                                    <div class="item">
                                        <div class="product-card">
                                            <figure>
                                                <a
                                                    href="{{ route('front-product-detail', ['sku' => $products->sku, 'slug' => productSlug($products->short_description)]) }}">

                                                    <img src="{{ $firstImage ? asset('uploads/products/' . $firstImage) : asset('img/no-image.jpg') }}"
                                                        alt="{{ $products->name }}" class="default-image">
                                                    <img src="{{ $secondImage ? asset('uploads/products/' . $secondImage) : asset('img/no-image.jpg') }}"alt="{{ $products->name }} Hover"
                                                        class="hover-image">
                                                </a>
                                                <span class="icon-top addtoWishList"
                                                    data-product-id="{{ $products->id }}">
                                                    @if (isset($isWishlisteddata[0]))
                                                        <i
                                                            class="{{ in_array($products->id, $isWishlisteddata) ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                                    @else
                                                        <i class="fa-regular fa-heart"></i>
                                                    @endif
                                                </span>
                                            </figure>
                                            @if (isset($products->productVariants))
                                                <div class="color-choose">

                                                    @foreach ($products->productVariants as $productVariantsValue)
                                                        @foreach ($productVariantsValue->variantValues as $variantValue)
                                                            <?php //echo "<pre>@@@".$variantValue->name; print_r($variantValue->variant_value);
                                                            ?>
                                                            @if ($variantValue->variant_value->variant_id == 1)
                                                                <div>
                                                                    <input
                                                                        data-image="{{ strtolower($variantValue->variant_value->name) }}"
                                                                        type="radio"
                                                                        id="{{ strtolower($variantValue->variant_value->name) }}"
                                                                        name="color"
                                                                        value="{{ strtolower($variantValue->variant_value->name) }}"
                                                                        checked />
                                                                    <label
                                                                        for="{{ strtolower($variantValue->variant_value->name) }}"><span></span></label>

                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="bottom-content">
                                            <p>{{ $products->name }}</p>
                                            <div class="price-btn-sec d-flex ">
                                                <div class="product-color">
                                                    <ul>
                                                        <li class="price">₹{{ floor($products->selling_price) }}</li>
                                                        @if ($products->discount > 0)
                                                            <li class="full-price">₹{{ floor($products->buying_price) }}
                                                            </li>
                                                        @endif
                                                    </ul>

                                                    {!! \App\Helpers\Attributes::productDiscountMsg($products) !!}
                                                </div>

                                                <div class="add-cart-btn ms-4">
                                                    <button type="button" class="boost-pfs-quickview-cart-btn"
                                                        onclick="window.location.href='{{ route('front-product-detail', ['sku' => $products->sku, 'slug' => productSlug($products->short_description)]) }}'">
                                                        Add To Cart
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </div>
                @endif

                @if (isset($bestproduct[0]))
                    <!--Best Sellers Products-->
                    <div class="col-md-12 mt-5 recent-product-sec">
                        <h3>Best Sellers Products</h3>
                        <section class="women-seller custom-seller-slider women-seller-slider" id="best-seller">
                            <div class="owl-carousel owl-theme" id="best-seller-slider">
                                @foreach ($bestproduct as $products)
                                    <?php
                                    $graphics = $products->product_main_images->where('status', 1);
                                    $frontImage = $graphics->firstWhere('is_front', 1);
                                    $backImage = $graphics->firstWhere('is_back', 1);
                                    $fallbackImages = $graphics->pluck('graphic')->take(2);
                                    
                                    $firstImage = $frontImage ? $frontImage->graphic : $fallbackImages->get(0) ?? null;
                                    $secondImage = $backImage ? $backImage->graphic : $fallbackImages->get(1) ?? $firstImage;
                                    ?>


                                    <div class="item">
                                        <div class="product-card">
                                            <figure>
                                                <a
                                                    href="{{ route('front-product-detail', ['sku' => $products->sku, 'slug' => productSlug($products->short_description)]) }}">

                                                    <img src="{{ $firstImage ? asset('uploads/products/' . $firstImage) : asset('img/no-image.jpg') }}"
                                                        alt="{{ $products->name }}" class="default-image">
                                                    <img src="{{ $secondImage ? asset('uploads/products/' . $secondImage) : asset('img/no-image.jpg') }}"alt="{{ $products->name }} Hover"
                                                        class="hover-image">
                                                </a>
                                                <span class="icon-top addtoWishList"
                                                    data-product-id="{{ $products->id }}">
                                                    @if (isset($isWishlisteddata[0]))
                                                        <i
                                                            class="{{ in_array($products->id, $isWishlisteddata) ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                                    @else
                                                        <i class="fa-regular fa-heart"></i>
                                                    @endif
                                                </span>
                                            </figure>
                                            @if (isset($products->productVariants))
                                                <div class="color-choose">

                                                    @foreach ($products->productVariants as $productVariantsValue)
                                                        @foreach ($productVariantsValue->variantValues as $variantValue)
                                                            <?php //echo "<pre>@@@".$variantValue->name; print_r($variantValue->variant_value);
                                                            ?>
                                                            @if ($variantValue->variant_value->variant_id == 1)
                                                                <div>
                                                                    <input
                                                                        data-image="{{ strtolower($variantValue->variant_value->name) }}"
                                                                        type="radio"
                                                                        id="{{ strtolower($variantValue->variant_value->name) }}"
                                                                        name="color"
                                                                        value="{{ strtolower($variantValue->variant_value->name) }}"
                                                                        checked />
                                                                    <label
                                                                        for="{{ strtolower($variantValue->variant_value->name) }}"><span></span></label>

                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="bottom-content">
                                            <p>{{ $products->name }}</p>
                                            <div class="price-btn-sec d-flex ">
                                                <div class="product-color">
                                                    <ul>
                                                        <li class="price">₹{{ floor($products->selling_price) }}</li>
                                                        @if ($products->discount > 0)
                                                            <li class="full-price">₹{{ floor($products->buying_price) }}
                                                            </li>
                                                        @endif
                                                    </ul>

                                                    {!! \App\Helpers\Attributes::productDiscountMsg($products) !!}
                                                </div>

                                                <div class="add-cart-btn ms-4">
                                                    <button type="button" class="boost-pfs-quickview-cart-btn"
                                                        onclick="window.location.href='{{ route('front-product-detail', ['sku' => $products->sku, 'slug' => productSlug($products->short_description)]) }}'">
                                                        Add To Cart
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </div>
                @endif


                <!--Recently Viewed Products-->
                @if (isset($recentlyViewedProducts[0]))
                    <!--Best Sellers Products-->
                    <div class="col-md-12 mt-5 recent-product-sec">
                        <h3>Recent Viewed Products</h3>
                        <section class="women-seller custom-seller-slider women-seller-slider" id="best-seller2">
                            <div class="owl-carousel owl-theme" id="best-seller-slider2">
                                @foreach ($recentlyViewedProducts as $product)
                                    <?php
                                    $graphics = $product->product_main_images->where('status', 1);
                                    $frontImage = $graphics->firstWhere('is_front', 1);
                                    $backImage = $graphics->firstWhere('is_back', 1);
                                    $fallbackImages = $graphics->pluck('graphic')->take(2);
                                    
                                    $firstImage = $frontImage ? $frontImage->graphic : $fallbackImages->get(0) ?? null;
                                    $secondImage = $backImage ? $backImage->graphic : $fallbackImages->get(1) ?? $firstImage;
                                    ?>


                                    <div class="item">
                                        <div class="product-card">
                                            <figure>
                                                <a
                                                    href="{{ route('front-product-detail', ['sku' => $product->sku, 'slug' => productSlug($product->slug)]) }}">

                                                    <img src="{{ $firstImage ? asset('uploads/products/' . $firstImage) : asset('img/no-image.jpg') }}"
                                                        alt="{{ $product->name }}" class="default-image">
                                                    <img src="{{ $secondImage ? asset('uploads/products/' . $secondImage) : asset('img/no-image.jpg') }}"alt="{{ $product->name }} Hover"
                                                        class="hover-image">
                                                </a>
                                                <span class="icon-top addtoWishList"
                                                    data-product-id="{{ $product->id }}">
                                                    @if (isset($isWishlisteddata[0]))
                                                        <i
                                                            class="{{ in_array($product->id, $isWishlisteddata) ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                                    @else
                                                        <i class="fa-regular fa-heart"></i>
                                                    @endif
                                                </span>
                                            </figure>
                                            @if (isset($product->productVariants))
                                                <div class="color-choose">

                                                    @foreach ($product->productVariants as $productVariantsValue)
                                                        @foreach ($productVariantsValue->variantValues as $variantValue)
                                                            <?php //echo "<pre>@@@".$variantValue->name; print_r($variantValue->variant_value);
                                                            ?>
                                                            @if ($variantValue->variant_value->variant_id == 1)
                                                                <div>
                                                                        <input
                                                                        data-image="{{ strtolower($variantValue->variant_value->name) }}"
                                                                        type="radio"
                                                                        id="{{ strtolower($variantValue->variant_value->name) }}"
                                                                        name="color"
                                                                        value="{{ strtolower($variantValue->variant_value->name) }}"
                                                                        checked />
                                                                        <label  for="{{ strtolower($variantValue->variant_value->name) }}"><span></span></label>
                                                                    </div>
                                                                
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="bottom-content">
                                            <p>{{ $product->name }}</p>
                                            <div class="price-btn-sec d-flex ">
                                                <div class="product-color">
                                                    <ul>
                                                        <li class="price">₹{{ floor($product->selling_price) }}</li>
                                                        @if ($product->discount > 0)
                                                            <li class="full-price">₹{{ floor($product->buying_price) }}
                                                            </li>
                                                        @endif
                                                    </ul>

                                                    {!! \App\Helpers\Attributes::productDiscountMsg($product) !!}
                                                </div>

                                                <div class="add-cart-btn ms-4">
                                                    <button type="button" class="boost-pfs-quickview-cart-btn"
                                                        onclick="window.location.href='{{ route('front-product-detail', ['sku' => $product->sku, 'slug' => $product->slug ]) }}'">
                                                        Add To Cart
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    </div>
                @endif

                @if(count($reviews) > 0)
                    <div class="col-md-12 mt-5 recent-product-sec">
                        <h3>Customer reviews</h3>
                        @foreach ($reviews as $review)
                            <div class="review-card">
                                <div class="review-header">
                                    <div class="review-user">
                                        <img src="{{ $review->user->image ?? asset('images/default-user.png') }}"
                                            alt="{{ @$review->user->name }}">
                                        <div>
                                            <h6>{{ @$review->user->name }}</h6>
                                            <small>{{ @$review->title }}</small>
                                        </div>
                                    </div>
                                    <div class="review-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="{{ $i <= $review->rating ? 'fas fa-star text-warning' : 'far fa-star text-muted' }}"></i>
                                        @endfor
                                    </div>
                                </div>

                                <p class="review-text">{{ @$review->review }}</p>

                                @if (!empty($review->image))
                                    @php $images = json_decode($review->image, true); @endphp
                                    <div class="review-images d-flex flex-wrap gap-2 mt-2">
                                        @foreach ($images as $img)
                                            <img src="{{ asset('uploads/reviews/' . $img) }}" alt="Review Image"
                                                class="review-thumb border rounded shadow-sm"
                                                style="width: 70px; height: 70px; object-fit: cover; cursor: pointer;">
                                        @endforeach
                                    </div>
                                @endif

                                <!-- 🔹 Image Popup Modal -->
                                <div id="imagePopup" class="image-popup">
                                    <span class="close-popup">&times;</span>
                                    <img class="popup-content" id="popupImg">
                                </div>

                                <p class="review-date">Reviewed on {{ $review->created_at->format('M d, Y') }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif    
            </div>
        </div>
    </section>

    <div class="modal fade flip-modal search-modal" id="Serch-box" tabindex="-1" aria-labelledby="exampleModalLabel"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="serch-space">
                        <div class="serch-box-modal">
                            <input type="text" name="" placeholder="Search..." class="form-control" />
                            <button class="serch-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>

                    <div class="popular-choice p-3 pt-0">
                        <h3><i class="fa-solid fa-arrow-trend-up"></i> Popular Choices</h3>

                        <ul class="popular-choice-list">
                            <li>Christmas <i class="fa-solid fa-arrow-right"></i></li>

                            <li>Bedsheets <i class="fa-solid fa-arrow-right"></i></li>

                            <li>Cushion Covers <i class="fa-solid fa-arrow-right"></i></li>

                            <li>Tawa <i class="fa-solid fa-arrow-right"></i></li>

                            <li>Plates & Dinner Sets <i class="fa-solid fa-arrow-right"></i></li>

                            <li>Storage Box & Containers <i class="fa-solid fa-arrow-right"></i></li>
                        </ul>
                    </div>

                    <div class="result-show-box">
                        <div class="Search-suggestions">
                            <div class="Search-suggestions-l">
                                <h4>Search Suggestions</h4>
                                <ul class="search-suggestions-list">
                                    <li>Premium Cotton Bedsheets - Tested for 100+ washes</li>
                                    <li>Premium Cotton Bedsheets - Tested for 100+ washes</li>
                                    <li>Premium Cotton Bedsheets - Tested for 100+ washes</li>
                                    <li>Premium Cotton Bedsheets - Tested for 100+ washes</li>
                                    <li>Premium Cotton Bedsheets - Tested for 100+ washes</li>
                                    <li>Premium Cotton Bedsheets - Tested for 100+ washes</li>
                                </ul>
                            </div>
                            <div class="Search-suggestions-r">
                                <h3>Search Results</h3>
                                <div class="women-seller women-seller-slider">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="product-card">
                                                <div>
                                                    <figure class="item-single">
                                                        <img src="assets/img/photo1.avif" alt="Product 1"
                                                            class="default-image" />
                                                        <img src="assets/img/photo2.avif" alt="Product 1 Hover"
                                                            class="hover-image" />
                                                        <span class="icon-top">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon-icon-P1l">
                                                                <path
                                                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                                                </path>
                                                            </svg>
                                                        </span>
                                                    </figure>
                                                </div>
                                                <div class="bottom-content">
                                                    <p>Georgette Flared Lehenga Choli with Embroidery</p>
                                                    <div class="product-color">
                                                        <ul>
                                                            <li class="price">₹8,999</li>
                                                            <li class="full-price">₹11,999</li>
                                                        </ul>
                                                        <span class="Discount">25% off</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="product-card">
                                                <figure class="item-single">
                                                    <img src="assets/img/photo2.avif" alt="Product 1"
                                                        class="default-image" />
                                                    <img src="assets/img/photo3.avif" alt="Product 1 Hover"
                                                        class="hover-image" />
                                                    <span class="icon-top">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="icon-icon-P1l">
                                                            <path
                                                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </figure>
                                                <div class="bottom-content">
                                                    <p>Georgette Flared Lehenga Choli with Embroidery</p>
                                                    <div class="product-color">
                                                        <ul>
                                                            <li class="price">₹8,999</li>
                                                            <li class="full-price">₹11,999</li>
                                                        </ul>
                                                        <span class="Discount">25% off</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="product-card">
                                                <figure class="item-single">
                                                    <img src="assets/img/photo3.avif" alt="Product 1"
                                                        class="default-image" />
                                                    <img src="assets/img/photo4.avif" alt="Product 1 Hover"
                                                        class="hover-image" />
                                                    <span class="icon-top">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="icon-icon-P1l">
                                                            <path
                                                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </figure>
                                                <div class="bottom-content">
                                                    <p>Georgette Flared Lehenga Choli with Embroidery</p>
                                                    <div class="product-color">
                                                        <ul>
                                                            <li class="price">₹8,999</li>
                                                            <li class="full-price">₹11,999</li>
                                                        </ul>
                                                        <span class="Discount">25% off</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="product-card">
                                                <figure class="item-single">
                                                    <img src="assets/img/photo4.avif" alt="Product 1"
                                                        class="default-image" />
                                                    <img src="assets/img/photo1.avif" alt="Product 1 Hover"
                                                        class="hover-image" />
                                                    <span class="icon-top">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="icon-icon-P1l">
                                                            <path
                                                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </figure>
                                                <div class="bottom-content">
                                                    <p>Georgette Flared Lehenga Choli with Embroidery</p>
                                                    <div class="product-color">
                                                        <ul>
                                                            <li class="price">₹8,999</li>
                                                            <li class="full-price">₹11,999</li>
                                                        </ul>
                                                        <span class="Discount">25% off</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="serch-bottom">
                            <a href="search-page.html" class="search-view-all">View All <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @php
        $productIdDetailPage = $orderedImages->first()->product_id;
        $activeVarientId = activeVarientByProductId($productIdDetailPage);
    @endphp
    <div class="modal fade modal-light" id="modal1" tabindex="-1" aria-labelledby="exampleModalLabel"  aria-hidden="true">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body" id="modal_slide_image">
                    @foreach (['sync1', 'sync2'] as $carouselId)
                        <div id="{{ $carouselId }}" class="owl-carousel owl-theme">
                            @foreach ($orderedImages as $images)
                                @if($images->variant_id == $activeVarientId)
                                    <div class="item">
                                        <img src="{{ asset('uploads/products/' . $images['graphic']) }}" />
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade common-modal" id="get-quote" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form method="POST" id="bulkOrderForm" class="validationForm" autocomplete="off">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Bulk Order</h1>

                        <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                            aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <div id="formErrorMessages" class="alert alert-danger d-none"></div>
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <input type="text" name="first_name" id="first_name" class="form-control"
                                placeholder="First name" required>
                        </div>

                        <div class="form-group mb-3">
                            <input type="number" name="phone" id="phone" class="form-control" data-min="10"
                                data-max="12" placeholder="Phone" required minlength="10" maxlength="12"
                                data-rule-digits="true" data-msg-minlength="Minimum 10 digits required"
                                data-msg-maxlength="Maximum 12 digits allowed" data-msg-digits="Only numbers allowed">
                        </div>

                        <div class="form-group mb-3">
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="Email ID" required>
                        </div>

                        <div class="form-group mb-3">
                            <input type="number" name="quantity" data-rule-digits="true" data-min="11" id="quantity"
                                data-msg-digits="Only numbers allowed" class="form-control"
                                placeholder="Enter quantity (minimum 10)" required>
                        </div>

                        <div class="form-group mb-3">
                            <select class="form-select" name="customisation" id="customisation" required>
                                <option value="">Do you need any product customisations?</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <select class="form-select" name="gst" id="gst" required>
                                <option value="">Do you have a GST number and require a GST invoice?</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <select class="form-select" name="preferred_time" id="preferred_time" required>
                                <option value="">Please suggest a preferred time to call</option>
                                <option value="Morning">Morning</option>
                                <option value="Afternoon">Afternoon</option>
                                <option value="Evening">Evening</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <textarea name="details" id="details" class="form-control" placeholder="Additional Details" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal-overlay" style="display: none;"></div>
    <div class="vasvi_size_chat">
        <div class="vasvi_size_chat_inner">
            <div class="vasvi_size_chat_wrapper">
                <div class="main_model_header">
                    <span class="vasvi_close">×</span>
                    <h2>Size Chart</h2>
                    <h6>All measurements mentioned below are in inches and centimeters.</h6>
                </div>
                @php
                    $category_image = \App\Models\Category::where('id', $product->main_category_id)->first();
                    $chart_measurement = \App\Models\SizeChartTebular::where(
                        'category_id',
                        $product->main_category_id,
                    )->first();
                    $sizes = ['xs', 's', 'm', 'l', 'xl', '2xl'];
                    $inch_upper = $inch_bottom = $cm_upper = $cm_bottom = [];

                    if ($chart_measurement && $chart_measurement->measurement_inch) {
                        $data_inch = json_decode($chart_measurement->measurement_inch, true);

                        if (!empty($data_inch['upper'])) {
                            foreach ($data_inch['upper'] as $label => $values) {
                                if (!empty($values['is_active'])) {
                                    foreach ($sizes as $size) {
                                        $inch_upper[$label][$size] = $values[$size] ?? '-';
                                    }
                                }
                            }
                        }

                        if (!empty($data_inch['bottom'])) {
                            foreach ($data_inch['bottom'] as $label => $values) {
                                if (!empty($values['is_active'])) {
                                    foreach ($sizes as $size) {
                                        $inch_bottom[$label][$size] = $values[$size] ?? '-';
                                    }
                                }
                            }
                        }

                        // Convert inch to cm (rounded to 1 decimal place)
                        foreach ($inch_upper as $label => $vals) {
                            foreach ($vals as $size => $val) {
                                $cm_upper[$label][$size] = is_numeric($val) ? number_format($val * 2.54, 1) : '-';
                            }
                        }

                        foreach ($inch_bottom as $label => $vals) {
                            foreach ($vals as $size => $val) {
                                $cm_bottom[$label][$size] = is_numeric($val) ? number_format($val * 2.54, 1) : '-';
                            }
                        }
                    }
                @endphp
                <div class="main_model_content">
                    <div class="main_model_content_head">
                        <div class="title_table_chart">VASVI SIZE CHART <span class="size_counter">INCH</span></div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="inches-tab" data-bs-toggle="tab"
                                    data-bs-target="#inches-tab-pane" type="button" role="tab"
                                    aria-controls="inches-tab-pane" aria-selected="true">Inches</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="centimeters-tab" data-bs-toggle="tab"
                                    data-bs-target="#centimeters-tab-pane" type="button" role="tab"
                                    aria-controls="centimeters-tab-pane" aria-selected="false">Centimeters</button>
                            </li>
                        </ul>
                    </div>
                    <div class="main_model_content_head_bottom">
                        <button class="nav-link active" id="upper-tab" data-bs-toggle="tab"
                            data-bs-target="#upper-tab-pane" type="button" role="tab"
                            aria-controls="upper-tab-pane" aria-selected="true">UPPER</button>
                        <button class="nav-link" id="bottom-tab" data-bs-toggle="tab" data-bs-target="#bottom-tab-pane"
                            type="button" role="tab" aria-controls="bottom-tab-pane"
                            aria-selected="false">BOTTOM</button>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="inches-tab-pane" role="tabpanel"
                            aria-labelledby="inches-tab" tabindex="0">
                            <div class="vasvi_tabs_content">
                                @if (!empty($inch_upper))
                                    <table class="table" id="sizeChart">
                                        <thead>
                                            <tr>
                                                <th>SIZE</th>
                                                @foreach (array_keys($inch_upper) as $label)
                                                    <th>{{ strtoupper($label) }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sizes as $size)
                                                <tr>
                                                    <td>{{ strtoupper($size) }}</td>
                                                    @foreach ($inch_upper as $vals)
                                                        <td>{{ $vals[$size] ?? '-' }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                @if (!empty($inch_bottom))
                                    <table class="table" id="sizeChart1">
                                        <thead>
                                            <tr>
                                                <th>SIZE</th>
                                                @foreach (array_keys($inch_bottom) as $label)
                                                    <th>{{ strtoupper($label) }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sizes as $size)
                                                <tr>
                                                    <td>{{ strtoupper($size) }}</td>
                                                    @foreach ($inch_bottom as $vals)
                                                        <td>{{ $vals[$size] ?? '-' }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="centimeters-tab-pane" role="tabpanel"
                            aria-labelledby="centimeters-tab" tabindex="0">
                            <div class="vasvi_tabs_content">
                                @if (!empty($cm_upper))
                                    <table class="table" id="sizeChart">
                                        <thead>
                                            <tr>
                                                <th>SIZE</th>
                                                @foreach (array_keys($cm_upper) as $label)
                                                    <th>{{ strtoupper($label) }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sizes as $size)
                                                <tr>
                                                    <td>{{ strtoupper($size) }}</td>
                                                    @foreach ($cm_upper as $vals)
                                                        <td>{{ $vals[$size] ?? '-' }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                @if (!empty($cm_bottom))
                                    <table class="table" id="sizeChart1">
                                        <thead>
                                            <tr>
                                                <th>SIZE</th>
                                                @foreach (array_keys($cm_bottom) as $label)
                                                    <th>{{ strtoupper($label) }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sizes as $size)
                                                <tr>
                                                    <td>{{ strtoupper($size) }}</td>
                                                    @foreach ($cm_bottom as $vals)
                                                        <td>{{ $vals[$size] ?? '-' }}</td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="myTabContent1">
                    </div>
                    <div class="inner_size_chart_img" id="upperImageBlock">
                        <h5>{{ $category_image->uppar_chart_title }}</h5>
                        <img src="{{ asset('uploads/category/' . $category_image->uppar_chart_image) }}" alt="img">
                    </div>

                    <div class="inner_bottom_size_chart_img" id="bottomImageBlock" style="display: none;">
                        <h5>{{ $category_image->bootom_chart_title }}</h5>
                        <img src="{{ asset('uploads/category/' . $category_image->bottom_chart_image) }}"
                            alt="img">
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@push('scripts')
    <script>
        var getVarient = "{{ route('variant.combination.prices') }}";
        var getVarientReaminingQty = "{{ route('get-variant-remaining-qty') }}";
        var checkoutUrl = "{{ route('front-product.checkoutBag') }}";
    </script>
    <script src="{{ asset('assets/front/js/product-details.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#buy_now_auto_add_to_cart").click(function() {
                var oldCartItems = localStorage.getItem('cartItems');
                localStorage.setItem('oldCartItems', oldCartItems);
                console.log('old cart : ', oldCartItems);

                localStorage.setItem('cartItems', JSON.stringify([]));
                console.log('blank cart : ', localStorage.getItem('cartItems'));

                setTimeout(() => {
                    $(".addToCartBtn").trigger("click");
                    console.log('after add to cart : ', localStorage.getItem('cartItems'));

                    window.location.href = checkoutUrl;
                }, 1000);

            });
        });
    </script>


    <script>
        //Product slider for details.
        $(document).ready(function() {
            $('#modal1').on('shown.bs.modal', function() {  
                initOwlSyncSlider();
            });
        });

        function initOwlSyncSlider() {
            var sync1 = $("#sync1");
            var sync2 = $("#sync2");

            sync1.owlCarousel({
                items: 1,
                slideSpeed: 2000,
                nav: true,
                autoplay: false,
                dots: false,
                loop: true,
                responsiveRefreshRate: 200
            }).on("changed.owl.carousel", syncPosition);

            sync2.owlCarousel({
                items: 3,
                dots: false,
                nav: true,
                smartSpeed: 200,
                slideSpeed: 500,
                margin: 10,
                responsiveRefreshRate: 100
            }).on("click", ".owl-item", function(e) {
                e.preventDefault();
                var index = $(this).index();
                sync1.trigger("to.owl.carousel", [index, 300, true]);
            });

            function syncPosition(e) {
                var i = e.item.index - e.relatedTarget._clones.length / 2;
                var t = e.item.count;
                if (i < 0) i = t - 1;
                if (i >= t) i = 0;
                sync2.find(".owl-item").removeClass("current").eq(i).addClass("current");
            }
        }

        let activeUnit = 'inch'; // Default unit
        let activeTab = 'upper'; // Default tab is "upper"

        // Set active tab based on Inch or CM tab click
        document.getElementById('inches-tab').addEventListener('click', function() {
            activeUnit = 'inch';
            document.querySelector('.size_counter').textContent = 'INCH';
            setActiveUnitTab(this);
            activateTab('upper'); // Default to Upper tab
            showUpperTable();
        });

        document.getElementById('centimeters-tab').addEventListener('click', function() {
            activeUnit = 'cm';
            document.querySelector('.size_counter').textContent = 'CM';
            setActiveUnitTab(this);
            activateTab('upper'); // Default to Upper tab
            showUpperTable();
        });

        // Set active state for Upper/Bottom button clicks
        document.getElementById('upper-tab').addEventListener('click', function() {
            activateTab('upper');
            showUpperTable();
        });

        document.getElementById('bottom-tab').addEventListener('click', function() {
            activateTab('bottom');
            showBottomTable();
        });

        // Helper function to activate correct unit tab button (Inches or CM)
        function setActiveUnitTab(selectedBtn) {
            // Remove active class from both unit tabs
            document.querySelectorAll('#myTab .nav-link').forEach(btn => btn.classList.remove('active'));
            selectedBtn.classList.add('active');
        }

        // Helper function to set the active state of Upper/Bottom button
        function activateTab(tab) {
            activeTab = tab;

            // Remove active class from both Upper and Bottom buttons
            document.querySelectorAll('.main_model_content_head_bottom .nav-link').forEach(btn => {
                btn.classList.remove('active');
            });

            // Add active class to the clicked tab
            if (tab === 'upper') {
                document.getElementById('upper-tab').classList.add('active');
            } else if (tab === 'bottom') {
                document.getElementById('bottom-tab').classList.add('active');
            }
        }

        function showUpperTable() {
            if (activeUnit === 'inch') {
                document.querySelector('#inches-tab-pane #sizeChart').style.display = 'table';
                document.querySelector('#inches-tab-pane #sizeChart1').style.display = 'none';
            } else {
                document.querySelector('#centimeters-tab-pane #sizeChart').style.display = 'table';
                document.querySelector('#centimeters-tab-pane #sizeChart1').style.display = 'none';
            }
        }

        function showBottomTable() {
            if (activeUnit === 'inch') {
                document.querySelector('#inches-tab-pane #sizeChart').style.display = 'none';
                document.querySelector('#inches-tab-pane #sizeChart1').style.display = 'table';
            } else {
                document.querySelector('#centimeters-tab-pane #sizeChart').style.display = 'none';
                document.querySelector('#centimeters-tab-pane #sizeChart1').style.display = 'table';
            }
        }

        // Default behavior on page load: show upper table and activate Upper tab
        document.addEventListener('DOMContentLoaded', function() {
            showUpperTable();
            activateTab('upper');
        });

        function activateTab(tab) {
            document.querySelectorAll('.main_model_content_head_bottom .nav-link').forEach(btn => btn.classList.remove(
                'active'));

            if (tab === 'upper') {
                document.getElementById('upper-tab').classList.add('active');
                showUpperTable();
                document.getElementById('upperImageBlock').style.display = 'block';
                document.getElementById('bottomImageBlock').style.display = 'none';
            } else {
                document.getElementById('bottom-tab').classList.add('active');
                showBottomTable();
                document.getElementById('upperImageBlock').style.display = 'none';
                document.getElementById('bottomImageBlock').style.display = 'block';
            }
        }

        $(".size-chart").click(function() {
            $(".vasvi_size_chat").addClass("active");
        });

        $(".vasvi_close").click(function() {
            $(".vasvi_size_chat").removeClass("active");
        });

        $(".write-btn-review").click(function() {
            $(".write-review").toggleClass("show");
        });

        $(document).ready(function() {
            $(".write-btn-review").click(function() {
                $(".write-review").slideToggle(400);
                $(this).toggleClass("open");
            });
        });


        $(function() { // Releated Products
            const $s = $("#releated-product-slider"),
                c = $s.find(".item").length > 4;
            if ($s.find(".item").length > 4) {
                $('#releated-product').removeClass('custom-seller-slider');
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

        $(function() { // releated Products
            const $s = $("#releated-product-slider"),
                c = $s.find(".item").length > 4;
            if ($s.find(".item").length > 4) {
                $('#releated-product').removeClass('custom-releated-slider');
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

        $(function() { // recent viewed Products
            const $s = $("#best-seller-slider2"),
                c = $s.find(".item").length > 4;
            if ($s.find(".item").length > 4) {
                $('#best-seller2').removeClass('custom-seller-slider');
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


        // Check Delivery Time

        document.getElementById('pincodeInput').addEventListener('input', function() {
            // Allow only numbers
            this.value = this.value.replace(/\D/g, '');

            // Automatically trigger when 6 digits are entered
            if (this.value.length === 6) {
                calculateDelivery();
            }
        });

        function calculateDelivery() {
            const deliveryTimeEl = document.getElementById('delivery_time');

            const today = new Date();
            today.setDate(today.getDate() + 7); // 7 days ahead

            const options = {
                weekday: 'short',
                day: 'numeric',
                month: 'short'
            };
            const formattedDate = today.toLocaleDateString('en-US', options);

            const svgImage = `<svg
            class="me-2"
            xmlns="http://www.w3.org/2000/svg"
            width="20"
            height="20"
            viewBox="0 0 512 512"
            style="enable-background: new 0 0 512 512;"
            xml:space="preserve">
            <g>
                <path d="M386.689 304.403c-35.587 0-64.538 28.951-64.538 64.538s28.951 64.538 64.538 64.538c35.593 0 64.538-28.951 64.538-64.538s-28.951-64.538-64.538-64.538zm0 96.807c-17.796 0-32.269-14.473-32.269-32.269s14.473-32.269 32.269-32.269 32.269 14.473 32.269 32.269c0 17.797-14.473 32.269-32.269 32.269zM166.185 304.403c-35.587 0-64.538 28.951-64.538 64.538s28.951 64.538 64.538 64.538 64.538-28.951 64.538-64.538-28.951-64.538-64.538-64.538zm0 96.807c-17.796 0-32.269-14.473-32.269-32.269s14.473-32.269 32.269-32.269c17.791 0 32.269 14.473 32.269 32.269 0 17.797-14.473 32.269-32.269 32.269zM430.15 119.675a16.143 16.143 0 0 0-14.419-8.885h-84.975v32.269h75.025l43.934 87.384 28.838-14.5-48.403-96.268z"
                    fill="#fc2424"></path>
                <path d="M216.202 353.345h122.084v32.269H216.202zM117.781 353.345H61.849c-8.912 0-16.134 7.223-16.134 16.134 0 8.912 7.223 16.134 16.134 16.134h55.933c8.912 0 16.134-7.223 16.134-16.134 0-8.912-7.223-16.134-16.135-16.134zM508.612 254.709l-31.736-40.874a16.112 16.112 0 0 0-12.741-6.239H346.891V94.655c0-8.912-7.223-16.134-16.134-16.134H61.849c-8.912 0-16.134 7.223-16.134 16.134s7.223 16.134 16.134 16.134h252.773V223.73c0 8.912 7.223 16.134 16.134 16.134h125.478l23.497 30.268v83.211h-44.639c-8.912 0-16.134 7.223-16.134 16.134 0 8.912 7.223 16.134 16.134 16.134h60.773c8.912 0 16.134-7.223 16.135-16.134V264.605c0-3.582-1.194-7.067-3.388-9.896zM116.706 271.597H42.487c-8.912 0-16.134 7.223-16.134 16.134 0 8.912 7.223 16.134 16.134 16.134h74.218c8.912 0 16.134-7.223 16.134-16.134.001-8.911-7.222-16.134-16.133-16.134zM153.815 208.134H16.134C7.223 208.134 0 215.357 0 224.269s7.223 16.134 16.134 16.134h137.681c8.912 0 16.134-7.223 16.134-16.134s-7.222-16.135-16.134-16.135z"
                    fill="#fc2424"></path>
                <path d="M180.168 144.672H42.487c-8.912 0-16.134 7.223-16.134 16.134 0 8.912 7.223 16.134 16.134 16.134h137.681c8.912 0 16.134-7.223 16.134-16.134.001-8.911-7.222-16.134-16.134-16.134z"
                    fill="#fc2424"></path>
            </g>
        </svg>`;

            // Set the content
            deliveryTimeEl.innerHTML = `${svgImage} Get it by <b>9:00 PM on ${formattedDate}</b>`;
        }
        // End Check Delivery Time



        recentlyViewProduct();

        function recentlyViewProduct() {
            const productId = "{{ $product->id }}";

            let viewedProducts = JSON.parse(localStorage.getItem('recently_viewed_products')) || [];

            // Remove if already exists, to avoid duplicates
            viewedProducts = viewedProducts.filter(id => id != productId);
            viewedProducts.unshift(productId); // Add to beginning
            viewedProducts = viewedProducts.slice(0, 12); // Limit to last 12

            localStorage.setItem('recently_viewed_products', JSON.stringify(viewedProducts));

            // Send to Laravel to fetch product data
            $.ajax({
                url: "{{ url('/product/recently-viewed-products') }}",
                method: "POST",
                data: JSON.stringify({
                    ids: viewedProducts
                }),
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#recently-view-product-slider-show').html(response.data);

                    $(function() { // Releated Products
                        const $s = $("#recently-view-product-slider"),
                            c = $s.find(".item").length > 4;
                        if ($s.find(".item").length > 4) {
                            $('#recently_view').removeClass('custom-seller-slider');
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
                }
            });
        }
    </script>
    <script>
        document.querySelectorAll('#starRating li').forEach(star => {
            star.addEventListener('click', function() {
                let rating = this.getAttribute('data-star');
                document.getElementById('rating').value = rating;

                document.querySelectorAll('#starRating li i').forEach((icon, index) => {
                    icon.classList.remove('fa-solid');
                    icon.classList.add('fa-regular');
                    if (index < rating) {
                        icon.classList.add('fa-solid');
                    }
                });
            });
        });
    </script>



    <script>
        $("#bulkOrderForm").validate();
        $(document).on('submit', '#bulkOrderForm', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();

            $.ajax({
                url: "{{ route('bulk.order.submit') }}",
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(response) {
                    if (response.success) {
                        showFlashMessage(response.message);
                        form[0].reset();
                    }
                },
                error: function(xhr) {
                    const errorBox = $('#formErrorMessages');
                    errorBox.empty(); // Clear previous errors

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorList = '<ul>';
                        $.each(errors, function(key, value) {
                            errorList += `<li>${value[0]}</li>`;
                        });
                        errorList += '</ul>';

                        errorBox.html(errorList).removeClass('d-none');
                        setTimeout(() => {
                            errorBox.addClass('d-none').empty();
                        }, 5000);
                    } else {
                        errorBox.html('<p>Something went wrong. Please try again.</p>').removeClass(
                            'd-none');
                    }
                }
            });
        });
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        
        $(document).ready(function () {
            if (window.innerWidth <= 767) {
                $('.delevery-step').insertAfter('.faq-inner');
            }
            let productOut = $('#variantOutOfStock').data('product-out');
            if (productOut == 1) {
                // Force show
                $('#variantOutOfStock').removeClass('d-none');
                $('.add-to-cart').addClass('disabled-action');
            }
        });
        var couponEndDate = "{{ $couponEndDate }}";

        function makeTimer() {
            // Corrected date string

            // var endTime = new Date("25 October 2025 09:56:00 GMT+01:00");
            var endTime = new Date(couponEndDate);

            // Check if the date is valid
            if (isNaN(endTime)) {
                console.error("Invalid date format");
                return;
            }

            // Get time in seconds
            var endTimeSeconds = Math.floor(endTime.getTime() / 1000);
            var nowSeconds = Math.floor(new Date().getTime() / 1000);

            var timeLeft = endTimeSeconds - nowSeconds;

            // Calculate days, hours, minutes, seconds
            var days = Math.floor(timeLeft / 86400);
            var hours = Math.floor((timeLeft % 86400) / 3600);
            var minutes = Math.floor((timeLeft % 3600) / 60);
            var seconds = Math.floor(timeLeft % 60);

            // Pad with leading zeros
            hours = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            // Update DOM elements (ensure these elements exist in your HTML)
            $("#days").html(days + "<span>Days</span>");
            $("#hours").html(hours + "<span>Hours</span>");
            $("#minutes").html(minutes + "<span>Minutes</span>");
            $("#seconds").html(seconds + "<span>Seconds</span>");
        }

        if (couponEndDate) {
            setInterval(function() {
                makeTimer();
            }, 1000);
        }

        document.addEventListener("DOMContentLoaded", function() {
            const activeVariants = document.querySelectorAll('.variant-list .s-variant.active');
            activeVariants.forEach(function(variant) {
                // Trigger the same function as onclick
                selectVariant(variant);
            });

            $('.btn_coupon_code').click(function() {
                let code = $(this).data('code');
                if (code) {
                    navigator.clipboard.writeText(code).then(function() {
                        toastr.success("Coupon code copied: " + code);
                    }).catch(function(err) {
                        toastr.error("Failed to copy coupon code");
                        console.error("Failed to copy: ", err);
                    });
                }
            });
        });
        ////////////////////Image Priview///////////////
        document.getElementById("image").addEventListener("change", function(e) {
            let previewArea = document.getElementById("preview-area");
            previewArea.innerHTML = "";
            for (let file of e.target.files) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let img = document.createElement("img");
                    img.src = e.target.result;
                    img.style.maxWidth = "120px";
                    img.style.border = "1px solid #ddd";
                    img.style.padding = "5px";
                    img.style.borderRadius = "5px";
                    previewArea.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.getElementById("imagePopup");
            const popupImg = document.getElementById("popupImg");
            const closeBtn = document.querySelector(".close-popup");

            // Show popup on image click
            document.querySelectorAll(".review-thumb").forEach(img => {
                img.addEventListener("click", function() {
                    popup.style.display = "block";
                    popupImg.src = this.src;
                });
            });

            // Close popup on close button click
            closeBtn.addEventListener("click", function() {
                popup.style.display = "none";
            });

            // Close popup when clicking outside the image
            popup.addEventListener("click", function(e) {
                if (e.target === popup) popup.style.display = "none";
            });


        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-bs-toggle="tooltip"]').tooltip();
        });

        function checkVariantStock(el) {
            let productId = el.dataset.productid;
            let variantId = el.dataset.id;
            let variantValueId = el.dataset.vid;

            $.ajax({
                url: "{{ route('variant.stock.check') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: productId,
                    variant_id: variantId,
                    variant_value_id: variantValueId
                },
                success: function (res) {

                    let productOut = $('#variantOutOfStock').data('product-out');

                    // If whole product is out, never hide it
                    if (productOut == 1) {
                        $('#variantOutOfStock').removeClass('d-none');
                        $('.add-to-cart').addClass('disabled-action');
                        return;
                    }

                    // Variant-level logic only
                    $('.s-variant').removeClass('out-of-stock');

                    if (res.out_of_stock) {
                        $(el).addClass('out-of-stock');

                        $('#variantOutOfStock').removeClass('d-none');
                        $('.add-to-cart').addClass('disabled-action');
                    } else {
                        $('#variantOutOfStock').addClass('d-none');
                        $('.add-to-cart').removeClass('disabled-action');
                    }
                }

            });
        }

    </script>
@endpush

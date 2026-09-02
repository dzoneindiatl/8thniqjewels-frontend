@extends('front.layouts.app')
@section('content')
    <style>
        .main-slider .slick-slide img {
            height: 700px; /* 👈 Forces a solid, fixed height */
            width: 100% !important; /* Forces the image to take up the full track width */
            object-fit: cover; /* Crops edges perfectly without squishing the image */
        }

        .thumb-slider .slick-slide img {
            height: 200px; /* 👈 Forces a solid, fixed height */
            width: 100% !important; /* Forces the image to take up the full track width */
            object-fit: cover; /* Crops edges perfectly without squishing the image */
        }

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

    <div class="breadcrumb-area mt-100 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <h2 class="text-center">Product Details</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <!-- page main wrapper start -->
    <main class="main-bg">
        <div class="product-details-wrapper pb-14 pt-sm-58">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- product details inner end -->
                        <div class="product-details-inner">
                            <div class="row">
                                <div class="col-lg-5">
                                    <?php 
                                if($product->product_type==1){
                                    $activeVarientId = $product->id;
                                    $firstImage = getActiveFrontImg($product->id,$product->id);
                                    $secondImage  = getActiveBackImg($product->id,$product->id);
                                } else {
                                    $activeVarientId = activeVarientByProductId($product->id);
                                    $firstImage = getActiveFrontImg($product->id,$activeVarientId);
                                    $secondImage  = getActiveBackImg($product->id,$activeVarientId);
                                }
                                
                                if($product->product_type==2){
                                    $priceData = getPriceByActiveVarientId($product->id,$activeVarientId);
                                    $buying_price = $priceData['buying_price'];
                                    $selling_price = $priceData['selling_price'];
                                    $discount_product = $buying_price - $selling_price;
                                    $productImages = getActiveVarientImg($product->id, $activeVarientId);
                                } else {
                                    $buying_price = $product->buying_price;
                                    $selling_price = $product->selling_price;
                                    $discount_product = $buying_price - $selling_price;
                                    $productImages = getActiveVarientImg($product->id, $product->id);
                                }
                                ?>
                                    <div class="product-large-slider mb-20 slider-arrow-style slider-arrow-style__style-2 main-slider">
                                        @php
                                            $colorArr = json_decode(request()->query('colorArr'));
                                            $sizeArr = json_decode(request()->query('sizeArr'));
                                            // Pehle order set kar lete hain: front -> back -> rest
                                            $selectedVarientImages = $product->product_main_images->where('variant_id', $activeVarientId);
                                            $frontImages = $selectedVarientImages->where('is_front', 1);
                                            $backImages = $selectedVarientImages->where('is_back', 1);
                                            $otherImages = $selectedVarientImages->where('is_front', '!=', 1)->where('is_back', '!=', 1);
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
                                                @if ($image['graphic_type'] == 'image')
                                                    <div class="pro-large-img img-zoom" id="img {{ $image['id'] }}">
                                                        <img src="{{ asset('uploads/products/' . $image['graphic']) }}" alt="{{ $product->name }}" />
                                                    </div>
                                                 @endif
                                                @php $i++; @endphp
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="pro-nav slick-padding2 slider-arrow-style slider-arrow-style__style-2 thumb-slider">
                                        @php
                                            $colorArr = json_decode(request()->query('colorArr'));
                                            $sizeArr = json_decode(request()->query('sizeArr'));
                                            // Pehle order set kar lete hain: front -> back -> rest
                                            $selectedVarientImages = $product->product_main_images->where('variant_id', $activeVarientId);
                                            $frontImages = $selectedVarientImages->where('is_front', 1);
                                            $backImages = $selectedVarientImages->where('is_back', 1);
                                            $otherImages = $selectedVarientImages->where('is_front', '!=', 1)->where('is_back', '!=', 1);
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
                                                @if ($image['graphic_type'] == 'image')
                                                    <div class="pro-nav-thumb"><img src="{{ asset('uploads/products/' . $image['graphic']) }}" alt="{{ $product->name }}" /></div>
                                                @endif
                                                @php $i++; @endphp
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="product-details-des pt-md-98 pt-sm-58">
                                        <!-- <h6 class="category-show">{{  @$productcat->name }}</h6> -->
                                        <h6 class="mt-30 mb-10 category-show">{{ $product->name }} 
                                            <div class="wishlist">
                                                <a href="#" class="wishlist-simple addtoWishList" data-product-id="{{ @$product->id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Wishlist">
                                                    <i class="ion-heart"></i>
                                                </a>
                                            </div>
                                        </h6>
                                        <p>
                                            {{ @$product->short_description }}
                                        </p>
                                        <div class="pricebox pb-30">
                                            <span class="regular-price">
                                                @if ($product->discount > 0)
                                                    <del>Rs.  {{ floor($buying_price) }}</del>
                                                @endif
                                                <span>Rs. {{ floor($selling_price) }}</span>
                                            </span>
                                        </div>
                                        <div class="availability mb-30">
                                            <h5>Availability:</h5>
                                            @if($product->in_stock)
                                            <span>In stock</span>
                                            @else 
                                             <span>Out stock</span>
                                            @endif
                                        </div>

                                        <!-- variant options for configured product -->
                                        @if($product->product_type==2)
                                        <div class="single-product-attribute">
                                                @if($productvariants)
                                                @foreach($productvariants as $variant)
                                                <div class="attribute-item">
                                                    <div class="attribute-title">
                                                        <p>{{  $variant['variant_name'] }}</p>
                                                    </div>
                                                    <div class="attribute-wrap">
                                                        <ul class="attribute-menu attribute-color product_details">
                                                            @foreach($variant['variant_values'] as $variantValue)
                                                            @php
                                                                $isActive = false;
                                                                $image = '';
                                                                if($activeVarientId && $variantValue['variant_value_id']==$activeVarientId){
                                                                    $isActive = true;
                                                                    $variantImage = $product->product_main_images->where('variant_id', $variantValue['id'])->first();
                                                                    if($variantImage){
                                                                        $image = asset('uploads/products/' . $variantImage->graphic);
                                                                    }
                                                                }
                                                                $type = $variant['variant_type'];
                                                            @endphp
                                                            <li data-productId = "{{  $variant['product_id'] }}"
                                                                    data-id="{{ $variantValue['id'] }}" 
                                                                    data-type="<?php echo strtolower($variant['variant_name']); ?>"
                                                                    data-value="<?php echo strtolower($variantValue['name']); ?>"
                                                                    data-vid="{{ $variantValue['variant_value_id'] }}"
                                                                    onclick="selectVariant(this); checkVariantStock(this);"
                                                                    class="s-variant activeVarientLi
                                                                    {{ in_array($type, [3]) ? 's-variant-round' : '' }} 
                                                                    {{ $isActive ? 'active' : '' }} mx-1"
                                                                    style="
                                                                    {{ in_array($type, [3, 6]) ? 'background-image:url(' . $image . '); background-size:cover;' : '' }}
                                                                    padding:5px; cursor: pointer;
                                                                ">   
                                                                <input class="attribute-input" name="{{ strtolower($variant['variant_name']) }}" id="color_brown{{  $variantValue['id'] }}" value="{{ $variantValue['id'] }}" type="radio">                                         
                                                                <div class="pro_img">
                                                                <img src="https://furnishworlds.com/uploads/products/APR2026/variant_76_69df1faa8b9f0.jpg" alt="" width="20" height="20" style="display: {{ in_array($type, [3, 6]) ? 'block' : 'none' }}; border-radius: {{ in_array($type, [3]) ? '50%' : '0' }};">
                                                                </div>
                                                                <label>{{ $variantValue['name'] }}</label>
                                                            </li>
                                                            @endforeach
                                                        </ul> 
                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                        @endif
                                        <!-- variant options for configured product -->

                                        @if($product->in_stock == '1')
                                        <div class="quantity-cart-box d-flex align-items-center mb-24 quantity">
                                            <!-- <div class="quantity">
                                                <div class="pro-qty"><input type="text" class="qty-inp" value="1"></div>
                                            </div> -->
                                            <div class="input-number-container pro-qty">
                                                <span class="input-number-decrement"></span>
                                                <input class="input-number quantityInput" id="quantityInputBox"
                                                    type="text" value="1"
                                                    min="{{ $product->min_selling_units ? $product->min_selling_units : 0 }}"
                                                    max="{{ $product->max_selling_units ? $product->max_selling_units : 10 }}"><span
                                                    class="input-number-increment"></span>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="product-btn product-btn__color">
                                                <a href="javascript:void(0)" name="add" class="detail-cart-btn me-3 addToCartBtn addToCartText"
                                                data-id="{{ $product->id }}" 
                                                data-name="{{ $product->name }}"
                                                data-producttype="{{ $product->product_type }}"
                                                data-instock="1"
                                                data-sku="{{ $product->sku }}"
                                                data-price="{{ $buying_price }}"
                                                data-salePrice="{{ $selling_price }}"
                                                data-discountType="{{ $product->discount_type }}"
                                                data-discount="{{ $product->discount }}" 
                                                data-tax-arr="{{ e(json_encode($categoryTaxes)) }}" >
                                                    <svg width="24" class="svg-cart-button" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.5703 22.9944L15.5703 16.0054" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M18.9891 19.5001L12.0001 19.5001" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M8.80994 2.5L5.18994 6.13" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M15.1899 2.5L18.8099 6.13" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M2 8.34998C2 6.49998 2.99 6.34998 4.22 6.34998H19.78C21.01 6.34998 22 6.49998 22 8.34998C22 10.5 21.01 10.35 19.78 10.35H4.22C2.99 10.35 2 10.5 2 8.34998Z" stroke="#FFB932" stroke-width="1.5" />
                                                        <path d="M3.5 10.5L4.91 19.14C5.23 21.08 6 22.5 8.86 22.5H11M20.5 10.5L19.5 16" stroke="#FFB932" stroke-width="1.5" stroke-linecap="round" />
                                                    </svg>
                                                    Add to cart
                                                </a>
                                            </div>
                                        </div>
                                        @endif

                                        @if($product->in_stock == '0')
                                        <div class="quantity-cart-box d-flex align-items-center mb-24 quantity">
                                            <!-- <div class="quantity">
                                                <div class="pro-qty"><input type="text" class="qty-inp" value="1"></div>
                                            </div> -->
                                            <div class="input-number-container pro-qty">
                                                <span class="input-number-decrement"></span>
                                                <input class="input-number quantityInput" id="quantityInputBox"
                                                    type="text" value="1"
                                                    min="{{ $product->min_selling_units ? $product->min_selling_units : 0 }}"
                                                    max="{{ $product->max_selling_units ? $product->max_selling_units : 10 }}"><span
                                                    class="input-number-increment"></span>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="product-btn product-btn__color">
                                                <a href="javascript:void(0)" name="add" class="detail-cart-btn me-3 addToCartBtn addToCartText1"
                                                data-id="{{ $product->id }}" 
                                                data-name="{{ $product->name }}"
                                                data-producttype="{{ $product->product_type }}"
                                                data-instock="0"
                                                data-sku="{{ $product->sku }}"
                                                data-price="{{ $buying_price }}"
                                                data-salePrice="{{ $selling_price }}"
                                                data-discountType="{{ $product->discount_type }}"
                                                data-discount="{{ $product->discount }}" 
                                                data-tax-arr="{{ e(json_encode($categoryTaxes)) }}" >
                                                    Make to Order
                                                </a>
                                                </br>
                                                <span style="color:red;font-size:16px">Note : Case of "Ready on Order", You should be pay 50% in Advance and remaining amount after delevery (Not Allow COD payment method).</span>
                                            </div>
                                        </div>
                                        
                                        @endif
										
                                        <div class="product-detail-table">
                                            <h4 class="details mb-20 mt-20">Details</h4>
											<!-- product description -->
											<div class="tab">
											  <button class="tablinks active" onclick="openCity(event, 'Description')">Description</button>
											  <button class="tablinks" onclick="openCity(event, 'Specification')">Specification</button>
											  <button class="tablinks" onclick="openCity(event, 'Details')">Product Details</button>
											  <button class="tablinks" onclick="openCity(event, 'Desclaimer')">Desclaimer</button>
											  <button class="tablinks" onclick="openCity(event, 'care')">Jewellery Care</button>
											</div>

											<div id="Description" class="tabcontent" style="display:block">
											  <h3>Description</h3>
											  <p><?php echo  @$product->description; ?></p>
											</div>

											<div id="Specification" class="tabcontent">
											  <h3>Specification</h3>
											  <p><?php echo  @$product->specification; ?></p> 
											</div>

											<div id="Details" class="tabcontent">
											  <h3>Product Details</h3>
											  <p><?php echo  @$product->product_details; ?></p>
											</div>
											
											<div id="Desclaimer" class="tabcontent">
											  <h3>Desclaimer</h3>
											  <p><?php echo  @$product->others; ?></p>
											</div>
											
											<div id="care" class="tabcontent">
											  <h3>Jewellery Care</h3>
											  <p><?php echo  @$product->wash_care; ?></p>
											</div>
											
											
											<script>
											function openCity(evt, cityName) {
											  var i, tabcontent, tablinks;
											  tabcontent = document.getElementsByClassName("tabcontent");
											  for (i = 0; i < tabcontent.length; i++) {
												tabcontent[i].style.display = "none";
											  }
											  tablinks = document.getElementsByClassName("tablinks");
											  for (i = 0; i < tablinks.length; i++) {
												tablinks[i].className = tablinks[i].className.replace(" active", "");
											  }
											  document.getElementById(cityName).style.display = "block";
											  evt.currentTarget.className += " active";
											}
											</script>
											<!-- product description -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- product details inner end -->
                    </div>
                </div>
            </div>
        </div>

        <!--  for csrf token  -->
        <form action="{{ route('front-user.addReview') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <img src="{{ asset('uploads/products/' . $firstImage) }}" alt="Product 1" class="default-image" style="display:none"/>
        </form>

        
        <!-- New Items start -->
        <div class="feature-category-area pt-50 pb-50 pt-md-114 pt-sm-54 pb-sm-0" style="background-image: url(assets/img/about/bg.jpg);background-size:100%;">
            <div class="container">
                <div class="heading text-center">
                    <img src="assets/img/about/OBJECTS.svg" />
                    <h2 class="heading-title">Similar items</h2>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="tab-content text-center">
                            <div class="feature-category-carousel slick-arrow-style spt slick-padding">
                                <div class="col">
                                    <div class="product-item mb-20">
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="assets/img/product/product-1.png" class="simple-imag" alt="product image">
                                                <img src="assets/img/product/hover.avif" class="hover-img" />
                                            </a>
                                            <div class="box-label">
                                                <div class="product-label new">
                                                    <span>new</span>
                                                </div>
                                                <div class="product-label discount">
                                                    <span>-5%</span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="wishlist">
                                            <a href="#" class="wishlist-simple" data-bs-toggle="tooltip" data-bs-placement="left" title="Wishlist">
                                                <i class="ion-heart"></i>
                                            </a>
                                        </div>
                                        <div class="product-description">
                                            <div class="product-name">
                                                <h3><a href="product-details.html">Solitaire Grove</a></h3>
                                            </div>
                                            <div class="price-box">
                                                <p class="regular-price">
                                                    Rs.1,30,051 <a href="#">
                                                        <svg width="24" height="24" viewBox="0 0 33 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M21.3936 31.1355L21.3936 21.5586" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M26.078 26.3473L16.5011 26.3473" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M12.1298 3.05249L7.16937 8.02659" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M20.8721 3.05249L25.8325 8.02659" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M2.79822 11.0687C2.79822 8.53367 4.15479 8.32812 5.84023 8.32812H27.1617C28.8472 8.32812 30.2037 8.53367 30.2037 11.0687C30.2037 14.0148 28.8472 13.8092 27.1617 13.8092H5.84023C4.15479 13.8092 2.79822 14.0148 2.79822 11.0687Z" stroke="#FFB932" stroke-width="2.05541" />
                                                            <path d="M4.85358 14.0146L6.78566 25.8538C7.22415 28.5122 8.27926 30.458 12.1983 30.458H15.1306M28.1483 14.0146L26.778 21.5512" stroke="#FFB932" stroke-width="2.05541" stroke-linecap="round" />
                                                        </svg>
                                                    </a>
                                                </p>
                                                <!--<span class="old-price"><del></del></span>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="product-item mb-20">
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="assets/img/product/product-1.png" class="simple-imag" alt="product image">
                                                <img src="assets/img/product/hover.avif" class="hover-img" />
                                            </a>
                                            <div class="box-label">
                                                <div class="product-label new">
                                                    <span>new</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wishlist">
                                            <a href="#" class="wishlist-listed" data-bs-toggle="tooltip" data-bs-placement="left" title="Wishlist">
                                                <i class="ion-heart"></i>
                                            </a>
                                        </div>
                                        <div class="product-description">
                                            <div class="product-name">
                                                <h3><a href="product-details.html">Solitaire Grove</a></h3>
                                            </div>
                                            <div class="price-box">
                                                <p class="regular-price">
                                                    Rs.1,30,051 <a href="#">
                                                        <svg width="24" height="24" viewBox="0 0 33 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M21.3936 31.1355L21.3936 21.5586" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M26.078 26.3473L16.5011 26.3473" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M12.1298 3.05249L7.16937 8.02659" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M20.8721 3.05249L25.8325 8.02659" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M2.79822 11.0687C2.79822 8.53367 4.15479 8.32812 5.84023 8.32812H27.1617C28.8472 8.32812 30.2037 8.53367 30.2037 11.0687C30.2037 14.0148 28.8472 13.8092 27.1617 13.8092H5.84023C4.15479 13.8092 2.79822 14.0148 2.79822 11.0687Z" stroke="#FFB932" stroke-width="2.05541" />
                                                            <path d="M4.85358 14.0146L6.78566 25.8538C7.22415 28.5122 8.27926 30.458 12.1983 30.458H15.1306M28.1483 14.0146L26.778 21.5512" stroke="#FFB932" stroke-width="2.05541" stroke-linecap="round" />
                                                        </svg>
                                                    </a>
                                                </p>
                                                <!--<span class="old-price"><del></del></span>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="product-item mb-20">
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="assets/img/product/product-1.png" class="simple-imag" alt="product image">
                                                <img src="assets/img/product/hover.avif" class="hover-img" />
                                            </a>
                                            <div class="box-label">
                                                <div class="product-label new">
                                                    <span>new</span>
                                                </div>
                                                
                                            </div>

                                        </div>
                                        <div class="wishlist">
                                            <a href="#" class="wishlist-simple" data-bs-toggle="tooltip" data-bs-placement="left" title="Wishlist">
                                                <i class="ion-heart"></i>
                                            </a>
                                        </div>
                                        <div class="product-description">
                                            <div class="product-name">
                                                <h3><a href="product-details.html">Solitaire Grove</a></h3>
                                            </div>
                                            <div class="price-box">
                                                <p class="regular-price">
                                                    Rs.1,30,051
                                                    <a href="#">
                                                        <svg width="24" height="24" viewBox="0 0 33 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M21.3936 31.1355L21.3936 21.5586" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M26.078 26.3473L16.5011 26.3473" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M12.1298 3.05249L7.16937 8.02659" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M20.8721 3.05249L25.8325 8.02659" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M2.79822 11.0687C2.79822 8.53367 4.15479 8.32812 5.84023 8.32812H27.1617C28.8472 8.32812 30.2037 8.53367 30.2037 11.0687C30.2037 14.0148 28.8472 13.8092 27.1617 13.8092H5.84023C4.15479 13.8092 2.79822 14.0148 2.79822 11.0687Z" stroke="#FFB932" stroke-width="2.05541" />
                                                            <path d="M4.85358 14.0146L6.78566 25.8538C7.22415 28.5122 8.27926 30.458 12.1983 30.458H15.1306M28.1483 14.0146L26.778 21.5512" stroke="#FFB932" stroke-width="2.05541" stroke-linecap="round" />
                                                        </svg>
                                                    </a>
                                                </p>
                                                <!--<span class="old-price"><del></del></span>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="product-item mb-20">
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="assets/img/product/product-1.png" class="simple-imag" alt="product image">
                                                <img src="assets/img/product/hover.avif" class="hover-img" />
                                            </a>
                                            <div class="box-label">
                                                <div class="product-label discount">
                                                    <span>-5%</span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="wishlist">
                                            <a href="#" class="wishlist-simple" data-bs-toggle="tooltip" data-bs-placement="left" title="Wishlist">
                                                <i class="ion-heart"></i>
                                            </a>
                                        </div>
                                        <div class="product-description">
                                            <div class="product-name">
                                                <h3><a href="product-details.html">Solitaire Grove</a></h3>
                                            </div>
                                            <div class="price-box">
                                                <p class="regular-price">
                                                    Rs.1,30,051
                                                    <a href="#">
                                                        <svg width="24" height="24" viewBox="0 0 33 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M21.3936 31.1355L21.3936 21.5586" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M26.078 26.3473L16.5011 26.3473" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M12.1298 3.05249L7.16937 8.02659" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M20.8721 3.05249L25.8325 8.02659" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M2.79822 11.0687C2.79822 8.53367 4.15479 8.32812 5.84023 8.32812H27.1617C28.8472 8.32812 30.2037 8.53367 30.2037 11.0687C30.2037 14.0148 28.8472 13.8092 27.1617 13.8092H5.84023C4.15479 13.8092 2.79822 14.0148 2.79822 11.0687Z" stroke="#FFB932" stroke-width="2.05541" />
                                                            <path d="M4.85358 14.0146L6.78566 25.8538C7.22415 28.5122 8.27926 30.458 12.1983 30.458H15.1306M28.1483 14.0146L26.778 21.5512" stroke="#FFB932" stroke-width="2.05541" stroke-linecap="round" />
                                                        </svg>
                                                    </a>
                                                </p>
                                                <!--<span class="old-price"><del></del></span>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="product-item mb-20">
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="assets/img/product/product-1.png" class="simple-imag" alt="product image">
                                                <img src="assets/img/product/hover.avif" class="hover-img" />
                                            </a>
                                            <div class="box-label">
                                                <div class="product-label new">
                                                    <span>new</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wishlist">
                                            <a href="#" class="wishlist-simple" data-bs-toggle="tooltip" data-bs-placement="left" title="Wishlist">
                                                <i class="ion-heart"></i>
                                            </a>
                                        </div>
                                        <div class="product-description">
                                            <div class="product-name">
                                                <h3><a href="product-details.html">Solitaire Grove</a></h3>
                                            </div>
                                            <div class="price-box">
                                                <p class="regular-price">Rs.1,30,051 <a href="#"><i class="ion-bag"></i></a></p>
                                                <!--<span class="old-price"><del></del></span>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="product-item mb-20">
                                        <div class="product-thumb">
                                            <a href="product-details.html">
                                                <img src="assets/img/product/product-1.png" class="simple-imag" alt="product image">
                                                <img src="assets/img/product/hover.avif" class="hover-img" />
                                            </a>
                                            <div class="box-label">
                                                <div class="product-label new">
                                                    <span>new</span>
                                                </div>
                                                <div class="product-label discount">
                                                    <span>-15%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wishlist">
                                            <a href="#" class="wishlist-simple" data-bs-toggle="tooltip" data-bs-placement="left" title="Wishlist">
                                                <i class="ion-heart"></i>
                                            </a>
                                        </div>
                                        <div class="product-description">
                                            <div class="product-name">
                                                <h3><a href="product-details.html">Solitaire Grove</a></h3>
                                            </div>
                                            <div class="price-box">
                                                <p class="regular-price">
                                                    Rs.1,30,051
                                                    <a href="#">
                                                        <svg width="24" height="24" viewBox="0 0 33 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M21.3936 31.1355L21.3936 21.5586" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M26.078 26.3473L16.5011 26.3473" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M12.1298 3.05249L7.16937 8.02659" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M20.8721 3.05249L25.8325 8.02659" stroke="#FFB932" stroke-width="2.05541" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M2.79822 11.0687C2.79822 8.53367 4.15479 8.32812 5.84023 8.32812H27.1617C28.8472 8.32812 30.2037 8.53367 30.2037 11.0687C30.2037 14.0148 28.8472 13.8092 27.1617 13.8092H5.84023C4.15479 13.8092 2.79822 14.0148 2.79822 11.0687Z" stroke="#FFB932" stroke-width="2.05541" />
                                                            <path d="M4.85358 14.0146L6.78566 25.8538C7.22415 28.5122 8.27926 30.458 12.1983 30.458H15.1306M28.1483 14.0146L26.778 21.5512" stroke="#FFB932" stroke-width="2.05541" stroke-linecap="round" />
                                                        </svg>
                                                    </a>
                                                </p>
                                                <!--<span class="old-price"><del></del></span>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- New Items end -->
    </main>
@endsection
<!--=====================================================
                Site Section End
=========================================================-->

@push('scripts')
    <script>
        var getVarient = "{{ route('variant.combination.prices') }}";
        var getVarientReaminingQty = "{{ route('get-variant-remaining-qty') }}";
        var checkoutUrl = "{{ route('front-product.checkoutBag') }}";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ asset('assets/front/js/product-details.js') }}"></script>

    <script>
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



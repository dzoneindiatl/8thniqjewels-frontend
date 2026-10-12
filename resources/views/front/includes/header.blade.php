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

    $menuContent = menuContent();
    $category = !empty($menuContent['category']) ? $menuContent['category'] : [];
    $collectionCat = !empty($menuContent['collectionCat']) ? $menuContent['collectionCat'] : [];

    $logo = \App\Models\Setting::where('key','Site.logo')->first();
@endphp
<script>
    var minSellingQty = '<?php echo $minSellingQty; ?>';
    var maxSellingQty = '<?php echo $maxSellingQty; ?>';
    var maxSellingQtyNew = 10;
    var notRequiredQtyAjaxClickonQtyBtn = true;
    console.log('header notRequiredQtyAjaxClickonQtyBtn : ',notRequiredQtyAjaxClickonQtyBtn);
    var getVarientReaminingQty = "{{ route('get-variant-remaining-qty') }}";
    var isOutOfStock = "{{ route('is-outofstock') }}";

    var emptyCartImg = '<img  src="<?php echo  env('WEBSITE_URL').'assets/front/img/cart-empty.jfif'; ?>" width="200" height="200" alt="cart empty" />';
</script>

<!-- header area start -->
    <header>
        <!-- main menu area start -->
         <?php
            $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
            $full_url = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            // print($full_url);
            $innerMenupageClass = '';
            if($full_url!='https://8thniqjewells.com/'){
                $innerMenupageClass = 'inner-pages-menu-bg';
            }
        ?>
        <div class="header-main transparent-menu sticky <?php echo  $innerMenupageClass; ?>">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-3">
                        <div class="logo">
                            <a href="{{ env('WEBSITE_URL') }}">
                                <img src="{{ env('WEBSITE_URL').'uploads/settings/'.@$logo->value }}" alt="Brand logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 d-none d-lg-block">
                        <div class="main-header-inner">
                            <div class="main-menu">
                                <nav id="mobile-menu">
                                    <ul>
                                        <li class="active"><a href="{{ env('WEBSITE_URL') }}">Home</a></li>
                                        <li><a href="{{ env('WEBSITE_URL').'page/about-us' }}">About Us</a></li>
                                        <li class="static last_step_menu menu_mega_steps menu-hover">
                                            <a href="javascript:void(0);">Shop <i class="fa fa-angle-down"></i></a>
                                            <ul class="megamenu dropdown">
                                                @if(!empty($category))
                                                    @foreach($category as $cat)
                                                        @if(@$cat?->slug=='ring')
                                                        <li class="mega-title active">
                                                            <a href="<?php echo env('WEBSITE_URL').$cat?->slug; ?>">
                                                                {{ $cat->name }}
                                                            </a>
                                                            <div class="mega-product">
                                                                <div class="left-container">
                                                                    <div class="product-list">
                                                                        <ul class="list-name">
                                                                            @if(!empty($cat->subcategories))
                                                                                @foreach($cat->subcategories as $subcategories)
                                                                                <li>
                                                                                    <?php $subcategory_image_url = asset('uploads/categories/'.$subcategories->getAttributes()['image']);  ?>
                                                                                    <a href="<?php echo env('WEBSITE_URL').$cat?->slug.'/'.$subcategories?->slug; ?>">
                                                                                        <img src="<?php echo $subcategory_image_url; ?>" alt="jewellery">
                                                                                        <span>{{ @$subcategories->name }}</span>
                                                                                    </a>
                                                                                </li>
                                                                                @endforeach
                                                                            @endif
                                                                        </ul>
                                                                        <div class="banner">
                                                                            <div class="bennar-bottom">
                                                                                <div class="img-content">
                                                                                    <div>
                                                                                        <img src="{{ asset('assets/front/8thniqjewells/assets/img/all-jew-menu-bottom.png') }}" alt="">
                                                                                    </div>
                                                                                    <div>
                                                                                        <h3>Jewellery for Every Moment—See It
                                                                                            All
                                                                                            Here!</h3>
                                                                                        <p>14,000+ designs to choose from</p>
                                                                                    </div>
                                                                                </div>
                                                                                <a href="<?php echo env('WEBSITE_URL').$cat?->slug; ?>" class="view-btn">
                                                                                    View All
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="image-heading">
                                                                        <div class="card-img">
                                                                            <?php 
                                                                            $category_image_url = asset('uploads/categories/'.$cat->getAttributes()['image']);  ?>
                                                                            <img src="<?php echo $category_image_url; ?>" alt="">
                                                                        </div>
                                                                        <h3><?php echo @$cat->description; ?></h3>
                                                                        <a href="<?php echo env('WEBSITE_URL').$cat?->slug; ?>">
                                                                            <span>Explore Now</span>
                                                                            <img src="{{ asset('assets/front/8thniqjewells/assets/img/arrow.svg') }}" alt="">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @else
                                                        <li class="mega-title">
                                                            <a href="<?php echo env('WEBSITE_URL').$cat?->slug; ?>">
                                                                {{ $cat->name }}
                                                            </a>
                                                            <div class="mega-product">
                                                                <div class="left-container">
                                                                    <div class="product-list">
                                                                        <ul class="list-img">
                                                                            @if(!empty($cat->subcategories))
                                                                                @foreach($cat->subcategories as $subcategories)
                                                                                <li>
                                                                                    <?php $subcategory_image_url = asset('uploads/categories/'.$subcategories->getAttributes()['image']);  ?>
                                                                                    <a href="<?php echo env('WEBSITE_URL').$cat?->slug.'/'.$subcategories?->slug; ?>">
                                                                                        <img src="<?php echo $subcategory_image_url; ?>" alt="jewellery">
                                                                                        <span>{{ @$subcategories->name }}</span>
                                                                                    </a>
                                                                                </li>
                                                                                @endforeach
                                                                            @endif
                                                                        </ul>
                                                                        <div class="banner">
                                                                            <div class="bennar-bottom">
                                                                                <div class="img-content">
                                                                                    <div>
                                                                                        <img 
                                                                                        src="{{ asset('assets/front/8thniqjewells/assets/img/all-jew-menu-bottom.png') }}" alt="">
                                                                                    </div>
                                                                                    <div>
                                                                                        <h3>Jewellery for Every Moment—See It
                                                                                            All
                                                                                            Here!</h3>
                                                                                        <p>14,000+ designs to choose from</p>
                                                                                    </div>
                                                                                </div>
                                                                                <a href="" class="view-btn">
                                                                                    View All
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="image-heading">
                                                                        <div class="card-img">
                                                                            <?php 
                                                                            $category_image_url = asset('uploads/categories/'.$cat->getAttributes()['image']);  ?>
                                                                            <img src="<?php echo $category_image_url; ?>" alt="">
                                                                        </div>
                                                                        <h3><?php echo @$cat->description; ?></h3>
                                                                        <a href="<?php echo env('WEBSITE_URL').$cat?->slug; ?>">
                                                                            <span>Explore Now</span>
                                                                            <img src="{{ asset('assets/front/8thniqjewells/assets/img/arrow.svg') }}" alt="">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </li>
                                        @if(!empty($collectionCat))
                                        <li class="static last_step_menu">
                                            <a href="javascript:void(0);">Collections <i class="fa fa-angle-down"></i></a>
                                            <ul class="megamenu-last dropdown">
                                                @foreach($collectionCat as $collection)
                                                <li class="mega-title">
                                                    <a href="<?php echo env('WEBSITE_URL').$collection?->slug; ?>">
                                                        <div class="category-header">
                                                            <!-- <img src="assets/img/category/ring-1.jpg" /> -->
                                                            <h5>{{  @$collection->name }}</h5>
                                                        </div>
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        @endif
                                        <li>
                                            <a href="javascript:void(0);">New Arrivals</a></li>
                                        <li><a href="{{ env('WEBSITE_URL').'contact-us' }}">Contact Us</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-2 ms-auto">
                        <div class="header-setting-option">
                            <div class="search-wrap">
                                <a data-bs-toggle="modal" data-bs-target="#Serch-box" id="default-search-category">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.25329 16.7467 2 11.5 2C6.25329 2 2 6.25329 2 11.5C2 16.7467 6.25329 21 11.5 21Z" stroke="#FFB932" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M22 22L20 20" stroke="#FFB932" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                            <div class="header-mini-cart">
                                <div class="mini-cart-btn">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.81 2L5.19 5.63" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M15.19 2L18.81 5.63" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M2 7.85001C2 6.00001 2.99 5.85001 4.22 5.85001H19.78C21.01 5.85001 22 6.00001 22 7.85001C22 10 21.01 9.85001 19.78 9.85001H4.22C2.99 9.85001 2 10 2 7.85001Z" stroke="#FFB932" stroke-width="1.5" />
                                        <path d="M3.5 10L4.91 18.64C5.23 20.58 6 22 8.86 22H14.89C18 22 18.46 20.64 18.82 18.76L20.5 10" stroke="#FFB932" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                    <span class="cart-notification center-main">0</span>
                                </div>
                                <div id="addtocatt" style="display:none">
                                    <ul class="cart-list productListCartPopupContainer"> <!-- cart content --> </ul>
                                        <!-- <li class="mini-cart-price" style="border:none;">
                                            <span class="subtotal">subtotal : </span>
                                            <span class="subtotal-price ms-auto">Rs. 2,00,000</span>
                                        </li>
                                        <li class="view-cart" style="border:none;margin-bottom:0px;padding:0px;">
                                            <a href="{{ route('product.viewBag') }}" class="sqr-btn d-block w-100">
                                                View Cart
                                                <svg width="30" height="8" viewBox="0 0 30 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 3.5C0.723858 3.5 0.5 3.72386 0.5 4C0.5 4.27614 0.723858 4.5 1 4.5V3.5ZM29.3536 4.35355C29.5488 4.15829 29.5488 3.84171 29.3536 3.64645L26.1716 0.464466C25.9763 0.269204 25.6597 0.269204 25.4645 0.464466C25.2692 0.659728 25.2692 0.976311 25.4645 1.17157L28.2929 4L25.4645 6.82843C25.2692 7.02369 25.2692 7.34027 25.4645 7.53553C25.6597 7.7308 25.9763 7.7308 26.1716 7.53553L29.3536 4.35355ZM1 4.5H29V3.5H1V4.5Z" fill="black"></path>
                                                </svg>
                                            </a>
                                        </li> -->
                                       </ul>
                                    </ul>
                                </div>
                            </div>
                            <div class="settings-top">
                                <div class="settings-btn">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.16 10.87C12.06 10.86 11.94 10.86 11.83 10.87C9.45 10.79 7.56 8.84 7.56 6.44C7.56 3.99 9.54 2 12 2C14.45 2 16.44 3.99 16.44 6.44C16.43 8.84 14.54 10.79 12.16 10.87Z" stroke="#FFB932" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M7.15997 14.56C4.73997 16.18 4.73997 18.82 7.15997 20.43C9.90997 22.27 14.42 22.27 17.17 20.43C19.59 18.81 19.59 16.17 17.17 14.56C14.43 12.73 9.91997 12.73 7.15997 14.56Z" stroke="#FFB932" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <ul class="settings-list">
                                    <li>
                                        <ul>
                                            <?php if(Auth::guard('customer')->check()) {  ?>
                                            <li><a href="{{ route('user.dashboard') }}">My Profile</a></li>
                                            <li><a href="{{ route('product.viewBag') }}">Cart</a></li>
                                            <li><a href="{{ route('front-user.wishlist') }}">Wishlist</a></li>
                                            <li><a href="{{ route('front-user.logout') }}">Logout</a></li>
                                            <?php } else {  ?>
                                            <li><a href="{{ route('front-user.login') }}">Login</a></li>
                                            <li><a href="{{ route('front-user.signup') }}">Register as Customer</a></li>
                                            <li><a href="{{ route('front-user.affiliates-signup') }}">Register as Affiliates</a></li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-block d-lg-none">
                        <div class="mobile-menu"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- main menu area end -->

        <!-- Start Search Popup -->
        <div class="modal fade flip-modal search-modal" id="Serch-box" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <form class="searchbar_form">
                            <button class="searchbar_trigger_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <circle cx="9.16533" cy="8.99065" r="6.69878" stroke="#022E71" stroke-width="1.5" stroke-linecap="square"></circle>
                                <path d="M13.7393 13.9236L17.5338 17.7084" stroke="#022E71" stroke-width="1.5" stroke-linecap="square"></path>
                                </svg>
                            </button>
                            <input class="searchbar_input" name="searchfor" id="liveSearchInput" placeholder="Search For..">
                            <span class="searchbar_input_after"></span>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                        </form>
                    </div>
                    <div class="modal-body">
                        <div class="search_top_main_inner">
                            <div class="search_box_inner result-show-box">
                                <!-- Dyamic search content goes here -->
                                <!-- <div class="search_box_inner_box">
                                    <div class="search_box_inner_left">
                                        <h3>Populaer Category</h3></hr>
                                        <ul class="search_box_inner_list">
                                            <li>
                                                <a href="javascript:void(0);">Trending Now <img class="hover_arro_sear" src="{{ asset('assets/front/image/search_arrow_right.png') }}" alt="img"></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">Necklaces <img class="hover_arro_sear" src="{{ asset('assets/front/image/search_arrow_right.png') }}" alt="img"></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">Earrings <img class="hover_arro_sear" src="{{ asset('assets/front/image/search_arrow_right.png') }}" alt="img"></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">Bangles <img class="hover_arro_sear" src="{{ asset('assets/front/image/search_arrow_right.png') }}" alt="img"></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">Rings <img class="hover_arro_sear" src="{{ asset('assets/front/image/search_arrow_right.png') }}" alt="img"></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">Mangalsutra <img class="hover_arro_sear" src="{{ asset('assets/front/image/search_arrow_right.png') }}" alt="img"></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="search_box_inner_right">
                                        <h3>Search Product</h3></hr>
                                        <div class="search_box_right_item">
                                            <div class="search_box_right_item_inner">
                                                <a href="javascript:void(0);">
                                                    <div class="search_box_img">
                                                        <img src="{{ asset('assets/front/image/search1.jpg') }}" alt="img">
                                                    </div>
                                                    <span class="search_box_title">Wedding</span>
                                                </a>
                                            </div>
                                            <div class="search_box_right_item_inner">
                                                <a href="javascript:void(0);">
                                                    <div class="search_box_img">
                                                        <img src="{{ asset('assets/front/image/search2.jpg') }}" alt="img">
                                                    </div>
                                                    <span class="search_box_title">Lush Gold</span>
                                                </a>
                                            </div>
                                            <div class="search_box_right_item_inner">
                                                <a href="javascript:void(0);">
                                                    <div class="search_box_img">
                                                        <img src="{{ asset('assets/front/image/search3.jpg') }}" alt="img">
                                                    </div>
                                                    <span class="search_box_title">Elevated Essential</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Search Popup -->
    </header>
    <!-- header area end -->
   
<!-- ===================================================== -->



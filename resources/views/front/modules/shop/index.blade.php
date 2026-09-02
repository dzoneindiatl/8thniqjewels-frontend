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
    <div class="breadcrumb-area mt-100 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <h2 class="text-center">Product List</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->
    <!-- page main wrapper start -->
    <main class="main-bg">
        <!-- search start -->
        <div class="search-list">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-xs-12 col-12"></div>
                    <div class="col-md-6 col-xs-12 col-12">
                        <div class="form-group">
                            <input type="text" id="searchlist" class="form-control search" placeholder="Search......" />
                            <button class="search" type="button">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.25329 16.7467 2 11.5 2C6.25329 2 2 6.25329 2 11.5C2 16.7467 6.25329 21 11.5 21Z" stroke="#FFB932" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M22 22L20 20" stroke="#FFB932" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                            </button>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12 col-12"></div>
                </div>
            </div>
        </div>
        <!-- search end -->
        <div class="shop-main-wrapper pt-100 pb-100 pt-sm-58 pb-sm-58">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 hidden-xs">
                        <div class="sidebar-wrapper mt-md-100 mt-sm-48 mobile-none">
                            <!-- single sidebar start -->
                            <div class="sidebar-single">
                                <div class="sidebar-title">
                                    <h3>FILTERS</h3>
                                </div>
                            </div>
                            <div class="sidebar-body">
                                <div class="accordion" id="general-question">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                <button class="accordio-heading" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Categories
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-bs-parent="#general-question">
                                            <div class="card-body">
                                                <div class="filter-check">
                                                    @if(!empty($categoriesData))
                                                        @foreach($categoriesData as $cat)
                                                        <label class="container">
                                                            {{ @$cat->name }}
                                                            <input type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        @endforeach
                                                     @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                                <button class="accordio-heading" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                    Collection
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-bs-parent="#general-question">
                                            <div class="card-body">
                                                <div class="filter-check">
                                                    @if(!empty($collectionCat))
                                                        @foreach($collectionCat as $collection)
                                                        <label class="container">
                                                            {{  @$collection->name }}
                                                            <input type="checkbox">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingThree">
                                            <h5 class="mb-0">
                                                <button class="accordio-heading" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                                    Metal Color
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-bs-parent="#general-question">
                                            <div class="card-body">
                                                <div class="filter-check">
                                                    <label class="container">
                                                        Rose Gold
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        White Gold
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        White and Rose Gold
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Yellow Gold
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <label class="container">
                                                        Yellow and White Gold
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingfive">
                                            <h5 class="mb-0">
                                                <button class="accordio-heading" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                                    Price
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseFour" class="collapse show" aria-labelledby="headingfive" data-bs-parent="#general-question">
                                            <div class="card-body">
                                                <div class="price-filter">
                                                    <div class="middle">
                                                        <div class="multi-range-slider">
                                                            <input type="range" id="input-left" class="range2" min="0" max="100" value="25" onmousemove="rangeLeftSlider(this.value)">
                                                            <input type="range" id="input-right" class="range2" min="0" max="100" value="75" onmousemove="rangeRightSlider(this.value)">

                                                            <div class="slider">
                                                                <div class="track"></div>
                                                                <div class="range"></div>
                                                                <div class="thumb left"></div>
                                                                <div class="thumb right"></div>
                                                            </div>
                                                        </div>
                                                        <div id="multi_range">
                                                            ₹<span id="range2LeftValue">25</span>
                                                            <span style="float:right;">₹<span id="range2RightValue">75</span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- single sidebar end -->
                        </div>
                    </div>
                    <!-- product view wrapper area start -->
                    <div class="col-xl-9 col-lg-8">
                        <div class="shop-product-wrapper">
                            <!-- shop product top wrap start -->
                            <div class="shop-top-bar">
                                <div class="row">
                                    <div class="col-lg-7 col-md-6">
                                        <div class="top-bar-left">
                                            <!--<div class="product-view-mode">
                                                <a class="active" href="#" data-target="grid"><i class="fa fa-th"></i></a>
                                                <a href="#" data-target="list"><i class="fa fa-list"></i></a>
                                            </div>
                                            <div class="product-amount">
                                                <p>Showing 1–16 of 21 results</p>
                                            </div>-->
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 mobile-none">
                                        <div class="top-bar-right">
                                            <div class="product-short">
                                                <select class="nice-select" name="sortby">
                                                    <option value="trending">SORT BY</option>
                                                    <option value="sales">Name (A - Z)</option>
                                                    <option value="sales">Name (Z - A)</option>
                                                    <option value="rating">Price (Low &gt; High)</option>
                                                    <option value="date">Rating (Lowest)</option>
                                                    <option value="price-asc">Model (A - Z)</option>
                                                    <option value="price-asc">Model (Z - A)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- shop product top wrap start -->

                            <!-- product view mode wrapper start -->
                            <div class="shop-product-wrap grid row">
                                @php
                                    $filteredColors = [];
                                    $i= 0;
                                @endphp
                                @if($results->isNotEmpty())
                                    @foreach($results as $product)
                                        @php
                                        $activeVarientID = 0;
                                        $firstImage ='';
                                        $secondImage = '';
                                        if($product->product_type==1){
                                            $activeVarientId = $product->id;
                                        } else {
                                            $activeVarientId = activeVarientByProductId($product->id);
                                        }
                                        if(!empty($activeVarientId)){
                                            $firstImage = getActiveFrontImg($product->id,$activeVarientId);
                                            $secondImage  = getActiveBackImg($product->id,$activeVarientId);
                                        }
                                        $discount_product = $product->buying_price - $product->selling_price;
                                        @endphp
                                        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6">
                                            <!-- product grid item start -->
                                            <div class="product-item mb-20">
                                                <div class="product-thumb">
                                                    <a href="{{ route('front-product-detail', ['product' => 'product','title' =>productSlug($product->name).'.html', 'sku' => $product->sku]). '?' . http_build_query(['colorArr' => $colorArr, 'sizeArr' => $sizeArr]) }}">
                                                        <img src="{{ asset('uploads/products/' . $firstImage) }}" class="simple-imag" alt="product image">
                                                        <img src="{{ asset('uploads/products/' . $secondImage) }}" class="hover-img" />
                                                    </a>
                                                    <div class="box-label">
                                                        <div class="product-label new">
                                                            <span>new</span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="wishlist">
                                                    <a href="#" class="wishlist-simple addtoWishList" data-product-id="{{ @$product->id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Wishlist">
                                                        <i class="ion-heart"></i>
                                                    </a>
                                                </div>
                                                <div class="product-description">
                                                    <div class="product-name">
                                                        <h3>
                                                            {{ $product->name }}
                                                        </h3>
                                                    </div>
                                                    <div class="price-box">
                                                        <p class="regular-price">
                                                            @if($discount_product > 0)
                                                            <del>₹ {{ floor($product->buying_price) }}</del>
                                                            @endif
                                                            <ins>₹ {{ floor($product->selling_price) }}</ins>
                                                            <a href="#">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M15.5703 22.4944L15.5703 15.5054" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M18.9891 19.0001L12.0001 19.0001" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M8.80994 2L5.18994 5.63" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M15.1899 2L18.8099 5.63" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M2 7.84998C2 5.99998 2.99 5.84998 4.22 5.84998H19.78C21.01 5.84998 22 5.99998 22 7.84998C22 9.99998 21.01 9.84998 19.78 9.84998H4.22C2.99 9.84998 2 9.99998 2 7.84998Z" stroke="#FFB932" stroke-width="1.5" />
                                                                    <path d="M3.5 10L4.91 18.64C5.23 20.58 6 22 8.86 22H11M20.5 10L19.5 15.5" stroke="#FFB932" stroke-width="1.5" stroke-linecap="round" />
                                                                </svg>
                                                            </a>
                                                        </p>
                                                        <!--<span class="old-price"><del></del></span>-->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- product grid item end -->
                                        </div>
                                    @endforeach
                                @endif


                            </div>
                            <!-- product view mode wrapper start -->
                        </div>
                        <!-- start pagination area -->
                        <div class="paginatoin-area text-center mt-18">
                            {{ $results->links('front.includes.custom-pagination') }}
                        </div>
                        <!-- end pagination area -->
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- page main wrapper end -->
    <div class="filter-mobile">
        <div class="row">
            <div class="col-md-6 col-xs-6 col-6">
                <div class="nice-select" tabindex="0">
                    <span class="current mobile-filter">SORT BY</span>
                    <ul class="list">
                        <li data-value="trending" class="option selected focus">SORT BY</li>
                        <li data-value="sales" class="option">Name (A - Z)</li>
                        <li data-value="sales" class="option">Name (Z - A)</li>
                        <li data-value="rating" class="option">Price (Low &gt; High)</li>
                        <li data-value="date" class="option">Rating (Lowest)</li>
                        <li data-value="price-asc" class="option">Model (A - Z)</li>
                        <li data-value="price-asc" class="option">Model (Z - A)</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-xs-6 col-6">
                <div class="nice-select" tabindex="0">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#filter" class="mobile-filter"> FILTER</a>
                </div>
            </div>
        </div>
    </div>

        <!--=====================================================
                        Site Section End
         =========================================================-->
@endsection



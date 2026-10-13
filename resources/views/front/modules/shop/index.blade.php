@extends('front.layouts.app')
@section('content')

    @php
        $colorArr = $colorArr ?? [];
        $sizeArr = $sizeArr ?? [];
    @endphp

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

        .wishlist-simple.is-wishlisted .ion-heart {
            color: #dc3545;
        }

        .product-item .wishlist.wishlist-visible {
            display: block;
        }

        .empty-products-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 340px;
            width: 100%;
            padding: 20px 0;
        }

        .empty-products-card {
            width: min(100%, 560px);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #e8ddd0;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(28, 20, 15, 0.06);
            text-align: center;
            padding: 42px 30px;
        }

        .empty-products-icon {
            width: 88px;
            height: 88px;
            margin: 0 auto 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: linear-gradient(135deg, #f8efe7 0%, #f2e1d0 100%);
            color: #b78d5c;
        }

        .empty-products-card h4 {
            margin: 0 0 10px;
            font-size: 2rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #1d1d1b;
            font-family: 'Times New Roman', serif;
        }

        .empty-products-card p {
            margin: 0;
            color: #6d625d;
            font-size: 1rem;
            line-height: 1.7;
        }

        .empty-products-actions {
            margin-top: 22px;
        }

        .empty-products-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            border-radius: 999px;
            background: #111111;
            color: #fff;
            font-size: 0.88rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: all 0.25s ease;
            text-decoration: none;
        }

        .empty-products-button:hover {
            background: #b78d5c;
            color: #fff;
            text-decoration: none;
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
                            <input type="text" id="searchlist" class="form-control search" placeholder="Search......"
                                value="{{ request('searchlist') }}" autocomplete="off" />
                            <button id="searchlist-submit" class="search" type="button" aria-label="Search products">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M11.5 21C16.7467 21 21 16.7467 21 11.5C21 6.25329 16.7467 2 11.5 2C6.25329 2 2 6.25329 2 11.5C2 16.7467 6.25329 21 11.5 21Z"
                                        stroke="#FFB932" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M22 22L20 20" stroke="#FFB932" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
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
                                                <button class="accordio-heading" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                    Categories
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                            data-bs-parent="#general-question">
                                            <div class="card-body">
                                                <div class="filter-check">
                                                    @if(!empty($categoriesData))
                                                        @foreach($categoriesData as $cat)
                                                            <label class="container">
                                                                {{ @$cat->name }}
                                                                <input type="checkbox" name="categories[]" data-category-filter
                                                                    value="{{ $cat->id }}" {{ in_array($cat->id, (array) request('categories', [])) ? 'checked' : '' }}>
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
                                                <button class="accordio-heading" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseTwo" aria-expanded="true"
                                                    aria-controls="collapseTwo">
                                                    Collection
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                                            data-bs-parent="#general-question">
                                            <div class="card-body">
                                                <div class="filter-check">
                                                    @if(!empty($collectionCat))
                                                        @foreach($collectionCat as $collection)
                                                            <label class="container">
                                                                {{  @$collection->name }}
                                                                <input type="checkbox" name="collections[]" data-collection-filter
                                                                    value="{{ $collection->id }}" {{ in_array($collection->id, (array) request('collections', [])) ? 'checked' : '' }}>
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
                                                <button class="accordio-heading" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseThree" aria-expanded="true"
                                                    aria-controls="collapseThree">
                                                    Metal Color
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseThree" class="collapse show" aria-labelledby="headingThree"
                                            data-bs-parent="#general-question">
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
                                                <button class="accordio-heading" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseFour" aria-expanded="true"
                                                    aria-controls="collapseFour">
                                                    Price
                                                </button>
                                            </h5>
                                        </div>

                                        <div id="collapseFour" class="collapse show" aria-labelledby="headingfive"
                                            data-bs-parent="#general-question">
                                            <div class="card-body">
                                                <div class="price-filter">
                                                    <div class="middle">
                                                        <div class="multi-range-slider">
                                                            <input type="range" id="input-left" class="range2" min="0"
                                                                max="100" value="25"
                                                                onmousemove="rangeLeftSlider(this.value)">
                                                            <input type="range" id="input-right" class="range2" min="0"
                                                                max="100" value="75"
                                                                onmousemove="rangeRightSlider(this.value)">

                                                            <div class="slider">
                                                                <div class="track"></div>
                                                                <div class="range"></div>
                                                                <div class="thumb left"></div>
                                                                <div class="thumb right"></div>
                                                            </div>
                                                        </div>
                                                        <div id="multi_range">
                                                            ₹<span id="range2LeftValue">25</span>
                                                            <span style="float:right;">₹<span
                                                                    id="range2RightValue">75</span></span>
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
                                                <select class="nice-select" name="sortBy" id="product-sort">
                                                    <option value="" {{ request('sortBy') ? '' : 'selected' }}>SORT BY
                                                    </option>
                                                    <option value="a_z" {{ request('sortBy') === 'a_z' ? 'selected' : '' }}>
                                                        Name (A - Z)</option>
                                                    <option value="z_a" {{ request('sortBy') === 'z_a' ? 'selected' : '' }}>
                                                        Name (Z - A)</option>
                                                    <option value="low_high" {{ request('sortBy') === 'low_high' ? 'selected' : '' }}>Price (Low to High)</option>
                                                    <option value="high_low" {{ request('sortBy') === 'high_low' ? 'selected' : '' }}>Price (High to Low)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- shop product top wrap start -->

                            <!-- product view mode wrapper start -->
                            <div class="shop-product-wrap grid row" data-empty-state-url="{{ route('front-shop.index') }}">
                                @php
                                    $filteredColors = [];
                                    $i = 0;
                                @endphp
                                @forelse($results as $product)
                                        @php
                                            $activeVarientID = 0;
                                            $firstImage = '';
                                            $secondImage = '';
                                            if ($product->product_type == 1) {
                                                $activeVarientId = $product->id;
                                            } else {
                                                $activeVarientId = activeVarientByProductId($product->id);
                                            }
                                            if (!empty($activeVarientId)) {
                                                $firstImage = getActiveFrontImg($product->id, $activeVarientId);
                                                $secondImage = getActiveBackImg($product->id, $activeVarientId);
                                            }
                                            $discount_product = $product->buying_price - $product->selling_price;
                                        @endphp
                                        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6">
                                            <!-- product grid item start -->
                                            <div class="product-item mb-20">
                                                <div class="product-thumb">
                                                    <a
                                                        href="{{ route('front-product-detail', ['product' => 'product', 'title' => productSlug($product->name) . '.html', 'sku' => $product->sku]) . '?' . http_build_query(['colorArr' => $colorArr, 'sizeArr' => $sizeArr]) }}">
                                                        <img src="{{ asset('uploads/products/' . $firstImage) }}"
                                                            class="simple-imag" alt="product image">
                                                        <img src="{{ asset('uploads/products/' . $secondImage) }}"
                                                            class="hover-img" />
                                                    </a>
                                                    <div class="box-label">
                                                        <div class="product-label new">
                                                            <span>new</span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div
                                                    class="wishlist {{ in_array($product->id, $isWishlisteddata ?? []) ? 'wishlist-visible' : '' }}">
                                                    <a href="javascript:void(0)"
                                                        class="wishlist-simple addtoWishList {{ in_array($product->id, $isWishlisteddata ?? []) ? 'is-wishlisted' : '' }}"
                                                        data-product-id="{{ @$product->id }}" data-bs-toggle="tooltip"
                                                        data-bs-placement="left" title="Wishlist">
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
                                                            <a
                                                                href="{{ route('front-product-detail', ['product' => 'product', 'title' => productSlug($product->name) . '.html', 'sku' => $product->sku]) . '?' . http_build_query(['colorArr' => $colorArr, 'sizeArr' => $sizeArr]) }}">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M15.5703 22.4944L15.5703 15.5054" stroke="#FFB932"
                                                                        stroke-width="1.5" stroke-miterlimit="10"
                                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M18.9891 19.0001L12.0001 19.0001" stroke="#FFB932"
                                                                        stroke-width="1.5" stroke-miterlimit="10"
                                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M8.80994 2L5.18994 5.63" stroke="#FFB932"
                                                                        stroke-width="1.5" stroke-miterlimit="10"
                                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M15.1899 2L18.8099 5.63" stroke="#FFB932"
                                                                        stroke-width="1.5" stroke-miterlimit="10"
                                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path
                                                                        d="M2 7.84998C2 5.99998 2.99 5.84998 4.22 5.84998H19.78C21.01 5.84998 22 5.99998 22 7.84998C22 9.99998 21.01 9.84998 19.78 9.84998H4.22C2.99 9.84998 2 9.99998 2 7.84998Z"
                                                                        stroke="#FFB932" stroke-width="1.5" />
                                                                    <path
                                                                        d="M3.5 10L4.91 18.64C5.23 20.58 6 22 8.86 22H11M20.5 10L19.5 15.5"
                                                                        stroke="#FFB932" stroke-width="1.5"
                                                                        stroke-linecap="round" />
                                                                </svg>
                                                            </a>
                                                        </p>
                                                        <!--<span class="old-price"><del></del></span>-->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- product grid item end -->
                                        </div>
                                @empty
                                    <div class="col-12">
                                        <div class="empty-products-wrap">
                                            <div class="empty-products-card">
                                                <div class="empty-products-icon" aria-hidden="true">
                                                    <svg width="42" height="42" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M3 7.5C3 6.67 3.67 6 4.5 6H19.5C20.33 6 21 6.67 21 7.5V18.5C21 19.33 20.33 20 19.5 20H4.5C3.67 20 3 19.33 3 18.5V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                                                        <path d="M8 10H16" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                                        <path d="M9 14H15" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                                        <path d="M7.5 6L9 3.5H15L16.5 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                                <h4>No products found</h4>
                                                <p>Try a different search term or clear your filters to explore more pieces from our collection.</p>
                                                <div class="empty-products-actions">
                                                    <a href="{{ route('front-shop.index') }}" class="empty-products-button">Clear filters</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse


                            </div>
                            <div id="product-load-more" data-next-url="{{ $results->nextPageUrl() }}"
                                class="text-center py-4" @if(!$results->hasMorePages()) hidden @endif>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span class="ms-2">Loading more products...</span>
                            </div>
                            <!-- product view mode wrapper start -->
                        </div>
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
                        <li data-value="" class="option {{ request('sortBy') ? '' : 'selected focus' }}">SORT BY</li>
                        <li data-value="a_z" class="option {{ request('sortBy') === 'a_z' ? 'selected focus' : '' }}">Name
                            (A - Z)</li>
                        <li data-value="z_a" class="option {{ request('sortBy') === 'z_a' ? 'selected focus' : '' }}">Name
                            (Z - A)</li>
                        <li data-value="low_high"
                            class="option {{ request('sortBy') === 'low_high' ? 'selected focus' : '' }}">Price (Low to
                            High)</li>
                        <li data-value="high_low"
                            class="option {{ request('sortBy') === 'high_low' ? 'selected focus' : '' }}">Price (High to
                            Low)</li>
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
    <script>
        (() => {
            const loader = document.getElementById('product-load-more');
            const productGrid = document.querySelector('.shop-product-wrap');
            const emptyStateUrl = productGrid?.dataset.emptyStateUrl || '/shop';
            const searchInput = document.getElementById('searchlist');
            const sortSelect = document.getElementById('product-sort');
            const categoryFilters = document.querySelectorAll('[data-category-filter]');
            const collectionFilters = document.querySelectorAll('[data-collection-filter]');

            if (!loader || !productGrid || !searchInput) {
                return;
            }

            let isLoading = false;
            let isSearching = false;
            let searchTimer;
            let searchRequestId = 0;
            let searchController;
            let observer = null;

            const emptyStateHtml = `
                <div class="col-12">
                    <div class="empty-products-wrap">
                        <div class="empty-products-card">
                            <div class="empty-products-icon" aria-hidden="true">
                                <svg width="42" height="42" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 7.5C3 6.67 3.67 6 4.5 6H19.5C20.33 6 21 6.67 21 7.5V18.5C21 19.33 20.33 20 19.5 20H4.5C3.67 20 3 19.33 3 18.5V7.5Z" stroke="currentColor" stroke-width="1.6"/>
                                    <path d="M8 10H16" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                    <path d="M9 14H15" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                    <path d="M7.5 6L9 3.5H15L16.5 6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h4>No products found</h4>
                            <p>Try a different search term or clear your filters to explore more pieces from our collection.</p>
                            <div class="empty-products-actions">
                                <a href="${emptyStateUrl}" class="empty-products-button">Clear filters</a>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            const refreshProducts = async (sortBy = sortSelect?.value || '') => {
                const requestId = ++searchRequestId;
                searchController?.abort();
                searchController = new AbortController();
                isSearching = true;
                observer?.unobserve(loader);

                const url = new URL(window.location.href);
                const searchTerm = searchInput.value.trim();
                if (searchTerm) {
                    url.searchParams.set('searchlist', searchTerm);
                } else {
                    url.searchParams.delete('searchlist');
                }
                if (sortBy) {
                    url.searchParams.set('sortBy', sortBy);
                } else {
                    url.searchParams.delete('sortBy');
                }
                url.searchParams.delete('categories[]');
                categoryFilters.forEach((filter) => {
                    if (filter.checked) {
                        url.searchParams.append('categories[]', filter.value);
                    }
                });
                url.searchParams.delete('collections[]');
                collectionFilters.forEach((filter) => {
                    if (filter.checked) {
                        url.searchParams.append('collections[]', filter.value);
                    }
                });
                url.searchParams.delete('page');

                try {
                    const response = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        signal: searchController.signal
                    });
                    if (!response.ok) {
                        throw new Error('Unable to search products.');
                    }

                    const data = await response.json();
                    if (requestId !== searchRequestId) {
                        return;
                    }

                    productGrid.innerHTML = data.html || emptyStateHtml;
                    loader.dataset.nextUrl = data.nextUrl || '';
                    loader.hidden = !loader.dataset.nextUrl;
                    window.history.replaceState({}, '', url.toString());
                    if (loader.dataset.nextUrl) {
                        observer?.observe(loader);
                    }
                } catch (error) {
                    if (error.name !== 'AbortError') {
                        console.error('Product listing refresh error:', error);
                    }
                } finally {
                    if (requestId === searchRequestId) {
                        isSearching = false;
                    }
                }
            };

            const scheduleSearch = () => {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => refreshProducts(), 300);
            };

            searchInput.addEventListener('input', scheduleSearch);
            categoryFilters.forEach((filter) => {
                filter.addEventListener('change', () => refreshProducts());
            });
            collectionFilters.forEach((filter) => {
                filter.addEventListener('change', () => refreshProducts());
            });
            searchInput.addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    clearTimeout(searchTimer);
                    refreshProducts();
                }
            });
            document.getElementById('searchlist-submit').addEventListener('click', () => {
                clearTimeout(searchTimer);
                refreshProducts();
            });

            sortSelect?.addEventListener('change', () => refreshProducts(sortSelect.value));
            document.querySelectorAll('.filter-mobile .option').forEach((option) => {
                option.addEventListener('click', () => {
                    const sortBy = option.dataset.value || '';
                    if (sortSelect) {
                        sortSelect.value = sortBy;
                    }
                    option.closest('.nice-select')?.querySelector('.current')?.replaceChildren(option.textContent.trim());
                    option.closest('ul')?.querySelectorAll('.option').forEach((item) => item.classList.remove('selected', 'focus'));
                    option.classList.add('selected', 'focus');
                    refreshProducts(sortBy);
                });
            });

            observer = new IntersectionObserver(async ([entry]) => {
                const nextUrl = loader.dataset.nextUrl;
                if (!entry.isIntersecting || isLoading || isSearching || !nextUrl) {
                    return;
                }

                isLoading = true;
                const requestId = searchRequestId;
                try {
                    const response = await fetch(nextUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });
                    if (!response.ok) {
                        throw new Error('Unable to load more products.');
                    }

                    const data = await response.json();
                    if (requestId !== searchRequestId) {
                        return;
                    }

                    productGrid.insertAdjacentHTML('beforeend', data.html || '');
                    loader.dataset.nextUrl = data.nextUrl || '';
                    if (!loader.dataset.nextUrl) {
                        observer.disconnect();
                        loader.hidden = true;
                    }
                } catch (error) {
                    observer.unobserve(loader);
                    loader.querySelector('span:last-child').textContent = 'Could not load products. Scroll to retry.';
                    loader.addEventListener('click', () => observer.observe(loader), { once: true });
                } finally {
                    isLoading = false;
                }
            }, { rootMargin: '300px 0px' });

            if (loader.dataset.nextUrl) {
                observer.observe(loader);
            }
        })();
    </script>
@endsection
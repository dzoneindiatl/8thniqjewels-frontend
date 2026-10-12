@foreach($results as $product)
    @php
        $activeVarientId = $product->product_type == 1 ? $product->id : activeVarientByProductId($product->id);
        $firstImage = '';
        $secondImage = '';
        if (!empty($activeVarientId)) {
            $firstImage = getActiveFrontImg($product->id, $activeVarientId);
            $secondImage = getActiveBackImg($product->id, $activeVarientId);
        }
        $discount_product = $product->buying_price - $product->selling_price;
    @endphp
    <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6">
        <div class="product-item mb-20">
            <div class="product-thumb">
                <a href="{{ route('front-product-detail', ['product' => 'product', 'title' => productSlug($product->name).'.html', 'sku' => $product->sku]). '?' . http_build_query(['colorArr' => $colorArr, 'sizeArr' => $sizeArr]) }}">
                    <img src="{{ asset('uploads/products/' . $firstImage) }}" class="simple-imag" alt="{{ $product->name }}">
                    <img src="{{ asset('uploads/products/' . $secondImage) }}" class="hover-img" alt="{{ $product->name }}">
                </a>
                <div class="box-label">
                    <div class="product-label new"><span>new</span></div>
                </div>
            </div>
            <div class="wishlist {{ in_array($product->id, $isWishlisteddata ?? []) ? 'wishlist-visible' : '' }}">
                <a href="javascript:void(0)" class="wishlist-simple addtoWishList {{ in_array($product->id, $isWishlisteddata ?? []) ? 'is-wishlisted' : '' }}" data-product-id="{{ $product->id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Wishlist">
                    <i class="ion-heart"></i>
                </a>
            </div>
            <div class="product-description">
                <div class="product-name"><h3>{{ $product->name }}</h3></div>
                <div class="price-box">
                    <p class="regular-price">
                        @if($discount_product > 0)
                            <del>₹ {{ floor($product->buying_price) }}</del>
                        @endif
                        <ins>₹ {{ floor($product->selling_price) }}</ins>

                        <a href="{{ route('front-product-detail', ['product' => 'product', 'title' => productSlug($product->name).'.html', 'sku' => $product->sku]). '?' . http_build_query(['colorArr' => $colorArr, 'sizeArr' => $sizeArr]) }}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.5703 22.4944L15.5703 15.5054" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M18.9891 19.0001L12.0001 19.0001" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M8.80994 2L5.18994 5.63" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M15.1899 2L18.8099 5.63" stroke="#FFB932" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M2 7.84998C2 5.99998 2.99 5.84998 4.22 5.84998H19.78C21.01 5.84998 22 5.99998 22 7.84998C22 9.99998 21.01 9.84998 19.78 9.84998H4.22C2.99 9.84998 2 9.99998 2 7.84998Z" stroke="#FFB932" stroke-width="1.5"></path>
                                <path d="M3.5 10L4.91 18.64C5.23 20.58 6 22 8.86 22H11M20.5 10L19.5 15.5" stroke="#FFB932" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endforeach
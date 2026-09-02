@extends('front.layouts.app')
@section('content')
<!-- slider area start -->
 
    @if(!empty($homeBanner))
    <div class="hero-area main-slider">
        <div class="hero-slider-active slider-arrow-style slick-dot-style hero-dot">
            @foreach($homeBanner as $banner)
            <?php $banner_url = asset('uploads/banners/'.$banner->image);  ?> 
            <div class="hero-single-slide hero-1 d-flex align-items-center" style="background-image: url({{ $banner_url }});background-attachment:fixed;">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="slider-content">
                                <h1><span id="docs-internal-guid-7a74ea55-7fff-8086-9d23-815713118106"><span style="font-size: 11pt; font-family: Arial, sans-serif; color: #ffc107; background-color: transparent; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-variant-position: normal; font-variant-emoji: normal; vertical-align: baseline; white-space-collapse: preserve;"><?php echo  @$banner->description; ?></span></h1>
                                <a href="{{ @$banner->url }}" class="slider-btn">
                                    Explore <svg width="30" height="9" viewBox="0 0 30 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 4C0.723858 4 0.5 4.22386 0.5 4.5C0.5 4.77614 0.723858 5 1 5V4ZM29.3536 4.85355C29.5488 4.65829 29.5488 4.34171 29.3536 4.14645L26.1716 0.964466C25.9763 0.769204 25.6597 0.769204 25.4645 0.964466C25.2692 1.15973 25.2692 1.47631 25.4645 1.67157L28.2929 4.5L25.4645 7.32843C25.2692 7.52369 25.2692 7.84027 25.4645 8.03553C25.6597 8.2308 25.9763 8.2308 26.1716 8.03553L29.3536 4.85355ZM1 5H29V4H1V5Z" fill="white" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    <!-- slider area end -->

    <!-- Welcome to 8thiniq start -->
    <div class="about-section" style="background-image: url(assets/img/about/about-bg.jpg);">
        <div class="container">
            <div class="about-details text-center">
                <img src="{{ asset('assets/front/8thniqjewells/assets/img/about/OBJECTS.svg') }}" />
                <h2 class="heading-title">Welcome to 8thniq Jewels</h2>
                <p class="heading-paragraph pb-50">
                   <?php if(!empty($aboutUsContent)) { echo @$aboutUsContent->value;  } ?>
                </p>
                <a class="learn-more" href="#">Learn more about us <i class="fa fa-long-arrow-right"></i></a>
                <img src="{{ asset('assets/front/8thniqjewells/assets/img/about/OBJECTS1.svg') }}" class="vector-img-left" />
                <img src="{{ asset('assets/front/8thniqjewells/assets/img/about/OBJECTS2.svg') }}" class="vector-img-right" />
            </div>
        </div>
    </div>
    <!-- Welcome to 8thiniq end -->

    <!-- Book An Appointment start -->
        <div class="book-appointment">
            <div class="container">
                <div class="apointment-items">
                    <div class="book-image">
                        <img src="{{ asset('assets/front/8thniqjewells/assets/img/book-apointment.jpg') }}" alt="apointment">
                    </div>
                    <div class="apointment-content">
                        <h2 class="heading-title">{{ @$bookAppointmentContent->name }}</h2>
                        <p><?php echo @$bookAppointmentContent->description; ?></p>
                        <a class="learn-more" href="https://wa.me/919929095686">Book An Appointment <i
                        class="fa fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    <!-- Book An Appointment end -->

    <!-- SHOP BY OCCASION start -->
    @if(!empty($collectionCat))
    <div class="banner-statistic-one" style="background-image: url({{ asset('assets/front/8thniqjewells/assets/img/about/bg.jpg') }});background-size:100%;">
        <div class="container">
            <div class="heading text-center">
                <img src="{{ asset('assets/front/8thniqjewells/assets/img/about/OBJECTS.svg') }}" />
                <h2 class="heading-title">SHOP BY OCCASION</h2>
            </div>
            <div class="gallery-wrap">
                @foreach($collectionCat as $collection) 
                <?php $occation_collection_img_url = asset('uploads/categories/'. $collection->getAttributes()['image']);  ?> 
                <div class="item item-1" style="background-image: url(<?php echo $occation_collection_img_url; ?>)">
                    <h2>{{  @$collection->name }}</h2>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    <!-- SHOP BY OCCASION end -->

    <!-- Browse category Start -->
    @if(!empty($categoryList))
    <div class="browsebycategory" style="display:none;">
        <div id="wrap">
            <div class="container">
                <div class="category-space">
                    <div class="heading text-center">
                        <h2 class="heading-title text-white pt-50">Browse By Category</h2>
                    </div>
                    <div class="scroll-add">
                        <ul class="scroll-left-right">
                            
                            @foreach($categoryList as $category)
                            <?php 
                                $cat_main_img_url = asset('uploads/categories/'. $category->getAttributes()['image']); 
                                //$cat_hover_img_url = asset('uploads/categories/'. $category->getAttributes()['thumbnail_image']);
                            ?>
                            <li>
                                <div class="container-item active">
                                    <a href="javascript:void(0);" class="link">
                                        <div class="category">
                                            <img src="{{ asset('assets/front/8thniqjewells/assets/img/category/rings.jpg') }}" class="cat-img" style="width:300px;height:200px">/>
                                        </div>
                                        <div class="contect-cat">
                                            <h2>{{ $category->name }}</h2>
                                            <p>{{ $category->description }}</p>
                                        </div>
                                    </a>
                                    <div class="image">
                                        <img src="{{ asset('assets/front/8thniqjewells/assets/img/category/rings.jpg') }}" alt="image" style="width:300px;height:200px">
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Browse category  end -->

    <!-- New Items start -->
    @if(!empty($new_arrivals_product))
    <div class="feature-category-area padding_tb" style="background-image: url({{ asset('assets/front/8thniqjewells/assets/img/about/bg.jpg') }});background-size:100%;">
        <div class="container">
            <div class="heading text-center">
                <img src="{{ asset('assets/front/8thniqjewells/assets/img/about/OBJECTS.svg') }}" />
                <h2 class="heading-title">New Items</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-content text-center">
                        <div class="feature-category-carousel slick-arrow-style spt slick-padding">
                            @foreach($new_arrivals_product as $product)
                            <div class="col">
                                <div class="product-item mb-20">
                                    <div class="product-thumb">
                                        <?php 
                                        if($product->product_type==1){
                                            $getVarientId = $product->id;
                                        } else {
                                            $getVarientId = activeVarientByProductId($product->id);
                                        }
                                        
                                        $front_img = getActiveFrontImg($product->id,$getVarientId);
                                        $back_img = getActiveBackImg($product->id,$getVarientId);
                                        ?>
                                        <a href="{{ route('front-product-detail',['product' => 'product','title' =>productSlug($product->name).'.html', 'sku' => $product->sku])}}">
                                            <img src="{{ asset('uploads/products/' . $front_img) }}" class="simple-imag" alt="{{  $product->name }}" style="width:300px;height:200px">
                                            <img src="{{ asset('uploads/products/' . $back_img) }}" class="hover-img" alt="{{  $product->name }}" style="width:300px;height:200px"/>
                                        </a>
                                        <?php if($product->is_new_arrivals == 1) { ?>
                                        <div class="box-label">
                                            <div class="product-label new">
                                                <span>new</span>
                                            </div>
                                        </div>
                                        <?php } ?>

                                    </div>
                                    <div class="wishlist">
                                        <a href="#" class="wishlist-simple" data-bs-toggle="tooltip" data-bs-placement="left" title="Wishlist">
                                            <i class="ion-heart"></i>
                                        </a>
                                    </div>
                                    <div class="product-description">
                                        <div class="product-name">
                                            <h3><a href="{{ route('front-product-detail',['product' => 'product','title' =>productSlug($product->name).'.html', 'sku' => $product->sku])}}"> 
                                                <?php 
                                                $string = substr($product->name,0,100);
                                                $string = substr($string,0,strrpos($string," "));
                                                echo  trim($string);
                                            ?>
                                            </a></h3>
                                        </div>
                                        <div class="price-box">
                                            <div class="regular-price">
                                                <span class="old-price"><del>{{  $product->buying_price }}</del> {{  $product->selling_price }}</span>
                                                @if(($product->buying_price - $product->selling_price) > 0)
                                                <span class="saveupto"> Save Rs. {{  ($product->buying_price - $product->selling_price) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mb-2">
                <a class="learn-more" href="product-list.html">View All <i class="fa fa-long-arrow-right"></i></a>
            </div>

        </div>
    </div>
    @endif
    <!-- New Items end -->

    
    <!-- SHOP BY CATEGORIES start -->
    @if(!empty($categoryShop))
    <div class="feature-category-area padding_tb" style="background-image: url({{ asset('assets/front/8thniqjewells/assets/img/about/bg.jpg') }});background-size:100%;">
        <div class="container">
            <div class="heading text-center">
                <img src="{{ asset('assets/front/8thniqjewells/assets/img/about/OBJECTS.svg') }}" />
                <h2 class="heading-title">SHOP BY CATEGORIES</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-content text-center">
                        <div class="feature-category-carousel3">
                            @foreach($categoryShop as $cat_shop) 
                            <?php 
                                $cat_main_img_url = asset('uploads/categories/'. $cat_shop->getAttributes()['image']); 
                                $cat_hover_img_url = asset('uploads/categories/'. $cat_shop->getAttributes()['thumbnail_image']);
                            ?> 
                            <div class="col">
                                <div class="product-item mb-20">
                                    <div class="product-thumb">
                                        <a href="javascript:void(0);">
                                            <img src="{{ $cat_main_img_url }}" class="simple-imag" alt="product image" />
                                            <img src="{{ $cat_hover_img_url }}" class="hover-img" alt="product image"  />
                                        </a>
                                        <!-- <div class="box-label">
                                            <div class="product-label new">
                                                <span>new</span>
                                            </div>
                                        </div> -->

                                    </div>
                                    <div class="wishlist">
                                        <a href="javascript:void(0);" class="wishlist-simple">
                                            <i class="ion-heart"></i>
                                        </a>
                                    </div>
                                    <div class="product-name">
                                        <h3><a href="javascript:void(0);">{{  $cat_shop->name }}</a></h3>
                                    </div>
                                    <div class="product-description">
                                        <div class="product-description-left">
                                            <a class="learn-more" href="{{  env('WEBSITE_URL').$cat_shop->slug }}">View More <i class="fa fa-long-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="text-center mb-2">
                <a class="learn-more" href="javascript:void('0')">View All <i class="fa fa-long-arrow-right"></i></a>
            </div> -->
        </div>
    </div>
    @endif
    <!-- SHOP BY CATEGORIES end -->

    <!-- Best Sellers start -->
    @if(!empty($bestproduct))
    <div class="feature-category-area padding_tb" style="background-image: url(assets/img/about/bg.jpg);background-size:100%;">
        <div class="container">
            <div class="heading text-center">
                <img src="{{ asset('assets/front/8thniqjewells/assets/img/about/OBJECTS.svg') }}" />
                <h2 class="heading-title">Best Sellers</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-content text-center">
                        <div class="feature-category-carousel slick-arrow-style spt slick-padding">
                            @foreach($bestproduct as $product)
                            <div class="col">
                                <div class="product-item mb-20">
                                    <div class="product-thumb">
                                        <?php 
                                        if($product->product_type==1){
                                            $getVarientId = $product->id;
                                        } else {
                                            $getVarientId = activeVarientByProductId($product->id);
                                        }
                                        
                                        $front_img = getActiveFrontImg($product->id,$getVarientId);
                                        $back_img = getActiveBackImg($product->id,$getVarientId);
                                        ?>
                                        <a href="{{ route('front-product-detail',['product' => 'product','title' =>productSlug($product->name).'.html', 'sku' => $product->sku])}}">
                                            <img src="{{ asset('uploads/products/' . $front_img) }}" class="simple-imag" alt="{{  $product->name }}" style="width:300px;height:200px">
                                            <img src="{{ asset('uploads/products/' . $back_img) }}" class="hover-img" alt="{{  $product->name }}"/ style="width:300px;height:200px">
                                        </a>
                                        <?php if($product->is_new_arrivals == 1) { ?>
                                        <div class="box-label">
                                            <div class="product-label new">
                                                <span>new</span>
                                            </div>
                                        </div>
                                        <?php } ?>

                                    </div>
                                    <div class="wishlist">
                                        <a href="#" class="wishlist-simple" data-bs-toggle="tooltip" data-bs-placement="left" title="Wishlist">
                                            <i class="ion-heart"></i>
                                        </a>
                                    </div>
                                    <div class="product-description">
                                        <div class="product-name">
                                            <h3><a href="{{ route('front-product-detail',['product' => 'product','title' =>productSlug($product->name).'.html', 'sku' => $product->sku])}}">
                                                <?php 
                                                $string = substr($product->name,0,100);
                                                $string = substr($string,0,strrpos($string," "));
                                                echo  trim($string);
                                                ?>
                                            </a>
                                             </h3>
                                        </div>
                                        <div class="price-box">
                                            <div class="regular-price">
                                                <span class="old-price"><del>{{  $product->buying_price }}</del> {{  $product->selling_price }}</span>
                                                @if(($product->buying_price - $product->selling_price) > 0)
                                                <span class="saveupto"> Save Rs. {{  ($product->buying_price - $product->selling_price) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Best Sellers end -->

    <!-- testimonial area start -->
    @if(!empty($testimonials))
    <div class="testimonial-area padding_tb" style="background-image: url({{ asset('assets/front/8thniqjewells/assets/img/about/bg.jpg') }});background-size:100%;">
        <img src="{{ asset('assets/front/8thniqjewells/assets/img/logo/left-shape.svg') }}" class="test-left" />
        <img src="{{ asset('assets/front/8thniqjewells/assets/img/logo/right-shape.svg') }}" class="test-right" />
        <div class="container">
            <div class="heading text-center">
                <img src="{{ asset('assets/front/8thniqjewells/assets/img/about/OBJECTS.svg') }}" />
                <h2 class="heading-title">Testimonials</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="testimonial-carousel-active slick-dot-style">
                        @foreach($testimonials as $testimonial)
                        <?php $testimonial_image_url = asset('uploads/testimonials/'.$testimonial->image);  ?>
                        <div class="testimonial-item text-center">
                            <div class="testimonial-border">
                                <div class="testimonial-content">
                                    <p>
                                        <?php 
                                        $string = substr($testimonial->description,0,300);
                                        $string = substr($string,0,strrpos($string," "));
                                        echo  trim($string);
                                        ?>
                                    </p>
                                </div>
                                <div class="testimonial-thumb">
                                    <img src="<?php echo $testimonial_image_url; ?>" alt="<?php echo $testimonial->name; ?>" />
                                    <div class="user-details">
                                        <h3><a href="#"><?php echo $testimonial->name; ?></a></h3>
                                        <i class="fa fa-star fill"></i>
                                        <i class="fa fa-star fill"></i>
                                        <i class="fa fa-star fill"></i>
                                        <i class="fa fa-star fill"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- testimonial area end -->

    <!-- Shop by instagram start -->
    <div class="banner-statistic-one bg-dark padding_tb">
        <div class="container">
            <div class="heading text-center">
                <img src="{{ asset('assets/front/8thniqjewells/assets/img/about/OBJECTS.svg') }}" />
                <h2 class="heading-title text-white">Shop by instagram</h2>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="instagram-img">
                        <img src="{{ asset('assets/front/8thniqjewells/assets/img/follow/1.png') }}" />
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="instagram-img">
                        <img src="{{ asset('assets/front/8thniqjewells/assets/img/follow/2.png') }}" />
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="instagram-img">
                        <img src="{{ asset('assets/front/8thniqjewells/assets/img/follow/3.png') }}" />
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="instagram-img">
                        <img src="{{ asset('assets/front/8thniqjewells/assets/img/follow/4.png') }}" />
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="instagram-img">
                        <img src="{{ asset('assets/front/8thniqjewells/assets/img/follow/5.png') }}" />
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="instagram-img">
                        <img src="{{ asset('assets/front/8thniqjewells/assets/img/follow/6.png') }}" />
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="instagram-img">
                        <img src="{{ asset('assets/front/8thniqjewells/assets/img/follow/7.png') }}" />
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="instagram-img">
                        <img src="{{ asset('assets/front/8thniqjewells/assets/img/follow/8.png') }}" />
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>

            </div>
            <div class="text-center mt-50">
                <a class="learn-more view-more" href="#"><i class="fa fa-instagram"></i> View More on Instagram <i class="fa fa-long-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <!-- Shop by instagram end -->

     <!-- Blog area start -->
    @if(!empty($blogs))
    <div class="feature-category-area padding_tb" style="background-image: url(assets/img/about/bg.jpg);background-size:100%;">
        <div class="container">
            <div class="heading text-center">
                <img src="{{ asset('assets/front/8thniqjewells/assets/img/about/OBJECTS.svg') }}" />
                <h2 class="heading-title">Our Blog</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tab-content text-center">
                        <div class="feature-category-carousel slick-arrow-style spt slick-padding">
                            @foreach($blogs as $blog)
                            <div class="col">
                                <div class="product-item mb-20">
                                    <div class="product-thumb">
                                        <?php $blog_image_url = asset('uploads/banners/'.$blog->media);  ?>
                                        <a href="{{ env('WEBSITE_URL').'blog-details/'.@$blog->blog_slug }}">
                                            <img src="<?php echo $blog_image_url; ?>" class="simple-imag" alt="product image" style="width:300px;height:200px">
                                            <img src="<?php echo $blog_image_url; ?>" class="hover-img" style="width:300px;height:200px" />
                                        </a>
                                   </div>
                                    <div class="product-description">
                                        <div class="product-name">
                                            <h3>
                                                <a href="{{ env('WEBSITE_URL').'blog-details/'.@$blog->blog_slug }}">
                                                    <?php  
                                                        $string = substr($blog->title,0,30);
                                                        $string = substr($string,0,strrpos($string," "));
                                                        echo  $string;
                                                    ?>
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="blog-created">
                                            <p>{{ date("d-m-Y",strtotime($blog->created_at)) }}</p>
                                        </div>
                                        <div class="blog-created">
                                            <p><?php  
                                            $string = substr($blog->short_description,0,30);
                                            $string = substr($string,0,strrpos($string," "));
                                            echo  $string;
                                            ?>
                                             </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mb-2">
                <a class="learn-more" href="{{  env('WEBSITE_URL').'blogs' }}">View All <i class="fa fa-long-arrow-right"></i></a>
            </div>
        </div>
    </div>
    @endif
    <!-- blog area end -->
@endsection
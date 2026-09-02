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
<main>
    <!-- blog main wrapper start -->
    <div class="blog-main-wrapper pt-150 pb-100 pt-sm-58 pb-sm-58">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 order-2">
                    <div class="blog-sidebar-wrapper mt-md-100 mt-sm-58">
                        <div class="blog-sidebar">
                            <div class="sidebar-serch-form">
                                <form action="#">
                                    <input type="text" class="search-field" placeholder="search here">
                                    <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
                                </form>
                            </div>
                        </div> <!-- single sidebar end -->
                        <div class="blog-sidebar">
                            <h4 class="title">categories</h4>
                            <ul class="blog-archive">
                                <li><a href="#">Health & beauty (10)</a></li>
                                <li><a href="#">Makeup (08)</a></li>
                                <li><a href="#">Skincare (07)</a></li>
                                <li><a href="#">Jewelry (14)</a></li>
                                <li><a href="#">fashion (10)</a></li>
                            </ul>
                        </div> <!-- single sidebar end -->
                        <div class="blog-sidebar">
                            <h4 class="title">Blog Archives</h4>
                            <ul class="blog-archive">
                                <li><a href="#">January (10)</a></li>
                                <li><a href="#">February (08)</a></li>
                                <li><a href="#">March (07)</a></li>
                                <li><a href="#">April (14)</a></li>
                                <li><a href="#">May (10)</a></li>
                            </ul>
                        </div> <!-- single sidebar end -->
                        <div class="blog-sidebar">
                            <h4 class="title">recent post</h4>
                            <div class="popular-item-inner popular-item-inner__style-2">
                                <div class="popular-item">
                                    <div class="pop-item-thumb">
                                        <a href="blog-details.html">
                                            <img src="assets/img/product/product-1.png" alt="">
                                        </a>
                                    </div>
                                    <div class="pop-item-des">
                                        <h4><a href="blog-details.html">Arbor Swoon Camber</a></h4>
                                        <span class="pop-price">$50.00</span>
                                    </div>
                                </div> <!-- end single popular item -->
                                <div class="popular-item">
                                    <div class="pop-item-thumb">
                                        <a href="blog-details.html">
                                            <img src="assets/img/product/product-1.png" alt="">
                                        </a>
                                    </div>
                                    <div class="pop-item-des">
                                        <h4><a href="blog-details.html">Arbor Swoon Camber</a></h4>
                                        <span class="pop-price">$50.00</span>
                                    </div>
                                </div> <!-- end single popular item -->
                                <div class="popular-item">
                                    <div class="pop-item-thumb">
                                        <a href="blog-details.html">
                                            <img src="assets/img/product/product-1.png" alt="">
                                        </a>
                                    </div>
                                    <div class="pop-item-des">
                                        <h4><a href="blog-details.html">Arbor Swoon Camber</a></h4>
                                        <span class="pop-price">$50.00</span>
                                    </div>
                                </div> <!-- end single popular item -->
                            </div>
                        </div> <!-- single sidebar end -->
                        <div class="blog-sidebar">
                            <h4 class="title">Tags</h4>
                            <ul class="blog-tags">
                                <li><a href="#">camera</a></li>
                                <li><a href="#">computer</a></li>
                                <li><a href="#">watch</a></li>
                                <li><a href="#">smartphone</a></li>
                                <li><a href="#">bag</a></li>
                                <li><a href="#">shoes</a></li>
                            </ul>
                        </div> <!-- single sidebar end -->
                        <div class="blog-sidebar">
                            <h4 class="title">image</h4>
                            <div class="advertising-thumb img-full fix">
                                <a href="#">
                                    <img src="{{ asset('uploads/banners/'.$details->media) }}" alt="">
                                </a>
                            </div>
                        </div> <!-- single sidebar end -->
                    </div>
                </div>
                <div class="col-lg-9 order-1">
                    <div class="blog-wrapper">
                        <div class="blog-item-single">
                            <article class="blog-post blog-details">
                                <div class="blog-post-content">
                                    <div class="blog-top">
                                        <div class="post-date-time">
                                            <span>10 DECEMBER,22 </span>
                                        </div>
                                        <div class="post-blog-meta">
                                            <p>post by <a href="#">HasTech</a></p>
                                        </div>
                                    </div>
                                    <div class="blog-thumb">
                                        <div class="blog-gallery-slider slider-arrow-style slider-arrow-style__style-2">
                                            <div class="blog-single-slide">
                                                <img src="{{ asset('uploads/banners/'.$details->media) }}" alt="">
                                            </div>
                                            <!-- <div class="blog-single-slide">
                                                <img src="assets/img/blog/blog-large-4.jpg" alt="">
                                            </div>
                                            <div class="blog-single-slide">
                                                <img src="assets/img/blog/blog-large-3.jpg" alt="">
                                            </div>
                                            <div class="blog-single-slide">
                                                <img src="assets/img/blog/blog-large-1.jpg" alt="">
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="blog-content blog-details">
                                    <h4>{{ $details->title }}</h4>
                                    <blockquote>{!! $details->short_description !!}</blockquote>
                                    <p>{!! $details->long_description !!}</p>
                                </div>
                                <div class="tag-line">
                                    <h4>tag:</h4>
                                    <a href="#">dry food</a>,
                                    <a href="#">wet food</a>,
                                    <a href="#">reach food</a>,
                                </div>
                                <div class="blog-sharing text-center">
                                    <h4>share this post:</h4>
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-google-plus"></i></a>
                                </div>
                            </article>
                        </div>
                    </div>
                    <!-- comment area start -->
                    <div class="comment-section">
                        <h3>03 comment</h3>
                        <ul>
                            <li>
                                <div class="author-avatar">
                                    <img src="assets/img/blog/comment-icon.png" alt="">
                                </div>
                                <div class="comment-body">
                                    <span class="reply-btn"><a href="#">reply</a></span>
                                    <h5 class="comment-author">admin</h5>
                                    <div class="comment-post-date">
                                        20 nov, 2022 at 9:30pm
                                    </div>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim maiores adipisci optio ex, laboriosam facilis non pariatur itaque illo sunt?</p>
                                </div>
                            </li>
                            <li class="comment-children">
                                <div class="author-avatar">
                                    <img src="assets/img/blog/comment-icon.png" alt="">
                                </div>
                                <div class="comment-body">
                                    <span class="reply-btn"><a href="#">reply</a></span>
                                    <h5 class="comment-author">admin</h5>
                                    <div class="comment-post-date">
                                        20 nov, 2022 at 9:30pm
                                    </div>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim maiores adipisci optio ex, laboriosam facilis non pariatur itaque illo sunt?</p>
                                </div>
                            </li>
                            <li>
                                <div class="author-avatar">
                                    <img src="assets/img/blog/comment-icon.png" alt="">
                                </div>
                                <div class="comment-body">
                                    <span class="reply-btn"><a href="#">reply</a></span>
                                    <h5 class="comment-author">admin</h5>
                                    <div class="comment-post-date">
                                        20 nov, 2022 at 9:30pm
                                    </div>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim maiores adipisci optio ex, laboriosam facilis non pariatur itaque illo sunt?</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- comment area end -->
                    <!-- start blog comment box -->
                    <div class="blog-comment-wrapper mb-sm-6">
                        <h3>leave a reply</h3>
                        <p>Your email address will not be published. Required fields are marked *</p>
                        <form action="#">
                            <div class="comment-post-box">
                                <div class="row">
                                    <div class="col-12">
                                        <label>comment</label>
                                        <textarea name="commnet" placeholder="Write a comment"></textarea>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 mb-sm-20">
                                        <label>Name</label>
                                        <input type="text" class="coment-field" placeholder="Name">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 mb-sm-20">
                                        <label>Email</label>
                                        <input type="text" class="coment-field" placeholder="Email">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 mb-sm-20">
                                        <label>Website</label>
                                        <input type="text" class="coment-field" placeholder="Website">
                                    </div>
                                    <div class="col-12">
                                        <div class="coment-btn mt-20">
                                            <input class="sqr-btn" type="submit" name="submit" value="post comment">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- start blog comment box -->
                </div>
            </div>
        </div>
    </div>
    <!-- blog main wrapper end -->
</main>


    
      
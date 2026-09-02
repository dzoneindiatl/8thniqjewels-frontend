<footer>
    <!-- specilazation -->
    </hr>
    <?php $promisesContent = promisesContent(); ?>
    @if(!empty($promisesContent))
    <div class="banner-statistic-one bg-white pt-50 pb-50 pt-sm-58 pb-sm-58">
        <div class="container">
            <div class="heading text-center">
                <h2 class="heading-title text-black">8thniq Promises</h2>
            </div>
            <div class="row">
                @foreach($promisesContent as $promises)
                <div class="col-md-6 col-lg-3">
                    <div class="instagram-img promises_items">
                        <?php $promises_url = asset('uploads/banners/'.$promises->media);  ?>
                        <img src="{{  $promises_url }}">
                        <div class="instagram-img-cnt">
                            <a href="#"><div class="footer-widget-title text-center text-black">{{ $promises->title }}</div></a>
                            <p><?php echo $promises->short_description;  ?></p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    </hr>
    <!-- specilazation -->

    <!-- footer widget area start -->
    <?php
        // Company Category
        $data = footerCategoryContent();
        $companyCategory = @$data['companyCategory'];
        // Quick Link
        $quickLinkCategory = @$data['quickLinkCategory'];
        // Reach Us
        $reachUsCategory = @$data['reachUsCategory'];
    ?>
    <div class="footer-widget-area pt-62 pb-56 pb-md-26 pt-sm-56 pb-sm-20">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="footer-widget">
                        <!-- <div class="footer-widget-title">
                            <div class="footer-logo">
                                <a href="index.html">
                                    <img src="{{ asset('assets/front/8thniqjewells/assets/img/logo/logo.svg') }}" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="footer-widget-body">
                            <p>Here you can read some details about a nifty little lifecycle of your order's journey from the time you place your order to your new treasures arriving at your doorstep.</p>
                        </div> -->
                        <div class="footer-widget-title">
                            <h3>{{   ucwords(@$companyCategory->name) }}</h3>
                        </div>
                        <div class="footer-widget-body">
                            <ul class="useful-link">
                                <li><a href="{{  env('WEBSITE_URL').'blogs' }}">Blog</a></li>
                                @if(!empty($companyCategory->subcategories))
                                    @foreach($companyCategory->subcategories as $subcategories)
                                        <li><a href="{{  @$subcategories->url }}">{{  @$subcategories->title }}</a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="footer-widget">
                        <div class="footer-widget-title">
                            <h3>{{   ucwords(@$quickLinkCategory->name) }}</h3>
                        </div>
                        <div class="footer-widget-body">
                            <ul class="useful-link">
                                @if(!empty($quickLinkCategory->subcategories))
                                    @foreach($quickLinkCategory->subcategories as $subcategories)
                                        @if($subcategories->type=='url')
                                        <li><a href="{{  @$subcategories->url }}">{{  @$subcategories->title }}</a></li>
                                        @else
                                        <li><a href="{{ env('WEBSITE_URL').'page/'.  @$subcategories->slug }}">{{  @$subcategories->title }}</a></li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="footer-widget">
                        <div class="footer-widget-title">
                            <h3>{{ @$reachUsCategory->name }}</h3>
                        </div>
                        <?php echo @$reachUsCategory->description; ?>
                        <!-- <div class="footer-widget-body">
                            <ul class="address-box">
                                <li>
                                    <p><i class="fa fa-envelope color-yellow"></i>support@trueview.health</p>
                                </li>
                                <li>
                                    <p><i class="fa fa-mobile color-yellow"></i> +1(858)568-1132</p>
                                </li>
                                <li>
                                    <p>
                                        <i class="fa fa-map-marker color-yellow"></i> 100 S Congress Ave, STE 2000 Austin, TX
                                    </p>
                                </li>
                            </ul>
                        </div> -->
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="footer-widget">
                        <div class="footer-widget-title">
                            <h3>Stay Up To Date</h3>
                        </div>

                        <div class="newsletter-inner">
                            <div class="newsletter-box">
                                <form id="mc-form">
                                    <input type="email" id="mc-email" autocomplete="off" placeholder="Your Email address">
                                    <button class="newsletter-btn" id="mc-submit"><i class="fa fa-paper-plane"></i></button>
                                </form>
                            </div>
                        </div>

                        <div class="social-share-area mt-10">
                            <div class="social-icon">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-youtube-play"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                        <div class="social-share-area text-center mt-10">
                            <a class="footer-btn" href="https://wa.me/919929095686">Book An Appointment <i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer widget area end -->
    <!-- footer botton area start -->
    <div class="footer-bottom-area">
        <div class="container">
            <div class="pb-18">
                <div class="row align-items-center">
                    <div class="col-md-6 order-2 order-md-1">
                        <div class="copyright-text">
                            <p>&copy; <b>8thniqjewells</b> Made with <i class="fa fa-heart text-danger"></i> by <a href="https://dzoneindia.co.in/" target="_blank"><b>DZone India</b></a></p>
                        </div>
                    </div>
                    <div class="col-md-6 ms-auto order-1 order-md-2">
                        <div class="footer-payment">
                            <img src="{{ asset('assets/front/8thniqjewells/assets/img/payment.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer botton area end -->

</footer>
<style>
    body.modal-open .background-container{
        -webkit-filter: blur(4px);
        -moz-filter: blur(4px);
        -o-filter: blur(4px);
        -ms-filter: blur(4px);
        filter: blur(4px);
        filter: url("https://gist.githubusercontent.com/amitabhaghosh197/b7865b409e835b5a43b5/raw/1a255b551091924971e7dee8935fd38a7fdf7311/blur".svg#blur);
        filter:progid:DXImageTransform.Microsoft.Blur(PixelRadius='4');
    }
</style>
    <!-- footer area end -->
    <!-- Quick view modal start -->
    <div class="modal fade" id="offer_popup" role="dialog" data-bs-backdrop="static" 
            data-bs-keyboard="false" 
            tabindex="-1"
            aria-labelledby="aboutUsLabel" 
            aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('assets/front/8thniqjewells/assets/img/offer/offer-1.jpg') }}" width="100%" />
                </div>
            </div>
        </div>
    </div>    
	<style>
	.formbody {
    padding: 30px !important;
}
.modal-header.lohoheader {
    background-color: #000;
    padding: 20px;
    text-align: center;
    align-content: center;
}
.img-radius {
    border-radius : 40%;
}
</style>

	<!-- <div class="modal fade" id="underconstruction" role="dialog" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header lohoheader" align="center">
                    <img src="https://8thniqjewells.com/assets/img/logo/logo.svg" style="margin:auto">
                </div>
                <div class="modal-body formbody">
                   <h4>Thank you for visiting us! Currently we are adding more products to our  website and will be live soon.</h4>
			 
				<p style="    font-size: 20px;
				margin-top: 20px;">Please share details below so that we can let you know.</p>
				
				<div class="form-group">
					<label>Enter Name:</label>
					<input type="text" name="name" class="form-control" required>
				</div>
				<div class="form-group">
					<label>Mobile Number ( Whatsapp ):</label>
					<input type="text" name="mobile" class="form-control" required>
				</div>
				<div class="form-group">
					<label>Email:</label>
					<input type="email" name="email" class="form-control" required>
				</div>
				
				<div class="form-group" align="center">
					<input type="submit" name="submit" class="btn btn-success" value="Submit">
				</div>
	
                </div>
            </div>
        </div>
    </div> -->

    <!-- Scroll to top start -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    <!-- Scroll to Top End -->

    <!-- whatsapp icon start -->
      <a class="whatsapp-icon" href="https://wa.me/919929095686">
        <img src="{{ asset('assets/front/8thniqjewells/assets/img/whatsapp_icon.svg') }}" alt="whatsapp icon">
      </a>
     <!-- whatsapp icon end -->
      
    <script src="{{ asset('assets/front/8thniqjewells/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/front/8thniqjewells/assets/js/vendor/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/front/8thniqjewells/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/front/8thniqjewells/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/front/8thniqjewells/assets/js/main.js') }}"></script>
    <script>
	$(document).ready(function(){
	    $("#underconstruction").modal({
            backdrop: 'static',
            keyboard: false
        });
	    $("#underconstruction").modal("show");
 
	
        $(".link").each(function () {
            $(this).on("mouseover", function () {
                $(".container").addClass("hover");
                $(".container-item").removeClass("active");
                $(this).parent().addClass("active");
            }).on("mouseleave", function () {
                $(".container").removeClass("hover");
            });
        }); 
    });
    </script>
    <!-- hover js  -->
    <script id="megaMenuScript">
        document.addEventListener("DOMContentLoaded", function () {
            const items = document.querySelectorAll(".mega-title");

            // Default active (Ring)
            if (items.length > 0) {
                items[0].classList.add("active");
            }

            items.forEach(item => {
                item.addEventListener("mouseenter", function () {
                    // sabse active hatao
                    items.forEach(i => i.classList.remove("active"));

                    // current ko active karo
                    this.classList.add("active");
                });
            });
        });
    </script>

</body>
</html>
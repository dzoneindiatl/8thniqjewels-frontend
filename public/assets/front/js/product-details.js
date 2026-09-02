function selectVariant(el) {
    const {
        type,
        value,
        id,
        vid: variant_id,
        productid: product_id
    } = el.dataset;

    document.querySelectorAll(`li[data-type="${type}"]`).forEach(item =>
        item.classList.remove('active')
    );
    el.classList.add('active');

    // Update selected value display
    const selectedSpan = document.getElementById(`selected-value-${id}`);
    if (selectedSpan) selectedSpan.textContent = value;

    // Collect selected variant IDs
    const selectedVariantIds = $('.s-variant.active').map(function () {
        return $(this).data('vid');
    }).get();

    console.log(' selectedVariantIds cart ', selectedVariantIds);
    checkItemInCart();
    $.ajax({
        url: getVarient,
        type: 'POST',
        data: JSON.stringify({
            product_id,
            vsku: selectedVariantIds,
            variant_id,
            _token: window.csrfToken
        }),
        contentType: 'application/json',
        success: function (response) {
            const combination = response?.combination;
            if (!combination) return;

            const {
                selling_price,
                price,
                sku,
                discount,
                discount_type,
                qty,
            } = combination;

            // Calculate and display discount
            let discountText = "";
            if (discount_type === 'percentage') {
                discountText = `${Math.floor(discount)}% OFF`;
            } else if (discount_type === 'flat' && price > 0) {
                discountText = `₹${Math.floor(discount)} OFF`;
            }

            //$('#productSku').html(sku);
           // $('#productPrice').text(`₹${Math.floor(selling_price)}`);
           // $('#pdpStrikedMrp').text(`MRP:₹${Math.floor(price)}`);
           var regular_price = `<del>Rs. ` +  Math.floor(price)  + `</del><span>Rs. ` + Math.floor(selling_price) + `</span>`;
           $('.regular-price').html(regular_price);

            if (discount_type) {
                $('#pdpDiscountRight').text(discountText).show();
            } else {
                $('#pdpDiscountRight').hide();
            }

            const $addToCartBtn = $('.addToCartBtn');
            $addToCartBtn.data('price', price);
            $addToCartBtn.data('saleprice', selling_price);
            $addToCartBtn.data('discounttype', discount_type);
            $addToCartBtn.data('discount', discount);

            if(qty==0){
                $('.varient_less_than_min_qty_notice').html('Out Of Stock');
                $('.add-to-cart').addClass('d-none');
            } else if(parseInt(minSellingQty) > parseInt(qty)){
                $('.varient_less_than_min_qty_notice').html('<b>Only '+qty+' items are left</b>');
                 $('.add-to-cart').removeClass('d-none')
            }  else {
                $('.varient_less_than_min_qty_notice').html('');
                $('.add-to-cart').removeClass('d-none')
            }

            // Update product image slider
            if (response.images && response.images.length > 0) {
                initCustomSlider(response.images);
                $('#carousel-wrapper').hide();
                $('#custom-slider').show();
            }
        },
        error: function (xhr) {
            console.error("Variant fetch error:", xhr.responseText);
        }
    });
}


checkItemInCart();

    function initCustomSlider(images = []) {
        if (!images.length) return;        
        //console.log(images);
            
            var thumbnailRow = ""; 
            var slide1Row ='';
            var slide2Row = '';
            var defaultImg = '';

            images.forEach((img, index) => {
                if (img.graphic_type === 'image') {
                    
                    defaultImg = img.graphic;
                 } 
            });
            $('.default-image').attr('src', defaultImg);
            
            images.forEach((img, index) => {
                if (img.graphic_type === 'image') {
                    
                    slide1Row += `<div class="pro-large-img img-zoom" id="img${index}">
                                                        <img src="${img.graphic}" alt="img${index}" />
                                                    </div>`;
                    slide2Row += `<div class="pro-nav-thumb"><img src="${img.graphic}" alt="img${index}" /></div>`;
                } else {
                    thumbnailRow += `
                        <div class="col-md-6 detail-grid-img">
                            <video width="100%" height="350" controls>
                                <source src="${img.graphic}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    `;
                }
            });

            console.log(' slide1Row ', slide1Row);
            console.log(' slide2Row ', slide2Row);

            // $(".main-slider").html(slide1Row);
            // $(".thumb-slider").html(slide1Row);

            var $slider = $('.main-slider');
            var $thumbslider = $('.thumb-slider');
            if ($slider.hasClass('slick-initialized')) {
                $slider.slick('unslick');
            }
            $slider.empty().html(slide1Row);

            if ($thumbslider.hasClass('slick-initialized')) {
                $thumbslider.slick('unslick');
            }
            $thumbslider.empty().html(slide2Row);
            $slider.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,          // We only want navigation arrows on the thumbnail bar
                fade: true,
                asNavFor: '.thumb-slider', // Binds it to the thumbnail slider
                adaptiveHeight: true,

                // Custom arrows to replace the raw string text "Previous" and "Next"
                prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>'
            });

            // 5. Initialize Thumb Slider
            $thumbslider.slick({
                slidesToShow: 4,          // Adjust this based on how many thumbnails you want visible
                slidesToScroll: 1,
                asNavFor: '.main-slider',  // Binds it back to the main slider
                focusOnSelect: true,      // Clicking a thumbnail jumps the main slider to that slide
                dots: false,              // Ensures bullet points are turned off
                arrows: true, 
                adaptiveHeight: true ,           // Keeps the arrow functionality active
                
                // Custom arrows to replace the raw string text "Previous" and "Next"
                prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>'
            });
            
    }


    function checkItemInCart() {
        const productId = $('#product_id').val();
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

        let selected = {};

        $('li.active[data-type]').each(function () {
            let type = ($(this).data('type') || '').toLowerCase(); // Normalize key
            let value = $(this).data('value');
            selected[type] = value;
        });

        let exists = cartItems.some(item => {
            if (item.productId != productId) return false;

            let variant = item.selectedVariants || {};
            let keys1 = Object.keys(selected);
            let keys2 = Object.keys(variant);

            if (keys1.length !== keys2.length) return false;

            return keys1.every(k => variant[k] === selected[k]);
        });

        if (exists) {
            $('.addToCartText').html("Go To Cart");
        } else {
            $('.addToCartText').html("Add To Cart");
        }
    }

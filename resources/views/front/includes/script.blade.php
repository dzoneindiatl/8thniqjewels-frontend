<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<!--<script src="{{asset('assets/front/js/swiper-bundle.min.js')}}"></script> -->
<script src="{{asset('assets/front/js/function.js')}}"></script>
<script src="{{asset('assets/front/js/custom.js')}}"></script>
<script src="{{asset('assets/front/js/show-password.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script> -->

<script>
    window.csrfToken = "{{ csrf_token() }}";
    var addToWish = "{{ route('front-addwish') }}";
    const isLoggedIn = "{{ Auth::guard('customer')->check() ? true : false }}";
    var addToCart = "{{ route('user.addToCart') }}";
    var getCouponUrl = "{{ route('get.coupon') }}";
    var wishlistUrl = "{{ route('front-user.wishlist') }}";
    var viewCartUrl = "{{ route('product.viewBag') }}";
    var phonepayPaymentUrl  = "{{ route('phonepay-payment') }}";
    var makeToOrderProductsUrl = "{{ route('make-to-order-products') }}";
</script>
<script src="{{ asset('assets/front/js/cart.js') }}?v={{ filemtime(public_path('assets/front/js/cart.js')) }}"></script>
<script src="{{ asset('assets/front/js/checkouts.js') }}?v={{ filemtime(public_path('assets/front/js/checkouts.js')) }}"></script>

<script>

    function showFlashMessage(msg, type = 'success') {
        const flash = document.getElementById('flash-msg');

        if (!flash) {
            console.log(msg);
            return;
        }
        
        let icon = '';
        if (type === 'success') {
            icon = '<i class="fas fa-check-circle text-success"></i>';
        } else if (type === 'error') {
            icon = '<i class="fas fa-times-circle text-danger"></i>';
        } else if (type === 'warning') {
            icon = '<i class="fas fa-exclamation-circle text-warning"></i>';
        }

        console.log(msg);
        flash.innerHTML = `${icon} <span>${msg}</span>`;
        flash.classList.remove('d-none', 'alert-success', 'alert-danger', 'alert-warning');
        flash.classList.add(`alert-${type}`);

        setTimeout(() => {
            flash.classList.add('d-none');
        }, 3000);
    }
    const localCartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    console.log(' center-main : ',localCartItems.length );
    $('.center-main').html(localCartItems.length);

   // console.log(' old cart items : ', JSON.parse(localStorage.getItem('oldCartItems')).length );
    console.log(' old cart : ', JSON.parse(localStorage.getItem('oldCartItems')) );
    let productListContainer = $('.productListContainer');
    let productListCartPopupContainer = $('.productListCartPopupContainer');
    var emptyCartImg = $(`<div class="empty-cart"><img src="{{ asset("assets/front/images/empty-cart.png") }}" alt="Empty Cart"></div></br><div class="text-center">
        <a class="learn-more" href="{{ env('WEBSITE_URL') }}">Continue Shopping<i class="fa fa-long-arrow-right"></i></a>
    </div>`);

    if (isLoggedIn &&  JSON.parse(localStorage.getItem('oldCartItems').length===0)) {
      const getCartItem = "{{ route('user.get-cart-items') }}";
      fetch(getCartItem)
         .then(res => res.json())
         .then(response => {
               if (!response.success) return;
               let serverCartItems = response.cartItems || [];
               localStorage.setItem('cartItems', JSON.stringify(serverCartItems));
               var notRequiredQtyAjaxClickonQtyBtn = true;
               console.log('eight');
               displayCartItems(notRequiredQtyAjaxClickonQtyBtn);
               getCoupon();
         });
   } else {
      const localCartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
      if (localCartItems.length > 0) {
         var notRequiredQtyAjaxClickonQtyBtn = true;
         console.log('nine');
         displayCartItems(notRequiredQtyAjaxClickonQtyBtn);
         getCoupon();
      } else {
            $(".add-cart-footer").hide();
            productListContainer.append(emptyCartImg);
      }
   }

</script>


<script>
    // search script
    $('#liveSearchInput').on('keyup', function () { 
        let query = $(this).val();
        var defaultProuduct = $('.result-show-box').html();
        $.ajax({
        url: '{{ route("product.search") }}',
        type: 'GET',
        data: { query: query },
        success: function (res) {
            $('.result-show-box').html(res.html);
        }
        });
        var viewAllHref = $('.search-view-all').attr('href')+'?q='+query;
        $('.search-view-all').attr("href", viewAllHref);
    });
    
    $(document).on('click', '.search-category', function () {
        let categoryId = $(this).data('id');
        let query = $('#liveSearchInput').val();
        console.log()
        $.ajax({
            url: '{{ route("product.search") }}',
            type: 'GET',
            data: {  query: query,
                category_id: categoryId },
            success: function (res) {
                $('.result-show-box').html(res.html);
            }
        });
        var viewAllHref = $('.search-view-all').attr('href') + '?q='+query + '&category_id='+categoryId;
        $('.search-view-all').attr("href", viewAllHref);

    });
    
    $(document).on('click', '#default-search-category', function () {
        let categoryId = $(this).data('id');
        let query = $('#liveSearchInput').val();
        $.ajax({
            url: '{{ route("product.search-default") }}',
            type: 'GET',
            data: {  query: query, category_id: categoryId },
            success: function (res) {
                $('.result-show-box').html(res.html);
            }
        });
        var viewAllHref = $('.search-view-all').attr('href') + '?q='+query + '&category_id='+categoryId;
        $('.search-view-all').attr("href", viewAllHref);
   });
   wishlistItemCount();
   function wishlistItemCount() {
      $.ajax({
         url: wishlistUrl,
         type: 'get',
         data: {
               _token: $('meta[name="csrf-token"]').attr('content'),
         },
         success: function (response) {
            localStorage.setItem('wishlistCount', response.data);
            $(".wishlist-count").html(response.data);
         },
         error: function (xhr) {
              // alert('Failed to add to cart. Please try again.');
         }
      });
   }
   
   $(document).on('click', '#resendOtp', function (e) {
		e.preventDefault();
		var user_id = $('.user_id').val();
        if(user_id!=''){
            $.ajax({
                url: "{{ route('front-user.resentotp') }}",
                type: 'post',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    user_id: user_id,
               },
               success: function(data) {
                    if (data.status) {
                        $('.otp_message').html('OTP resent on your registered email id.');
                    } else {
                        alert('Something went wrong');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                }
            });
        }
    });

</script>

<!-- login form submission -->
 <script>
    $(document).on('click', '#loginBtn', function (e) {
        var email = $('#email').val();
        var password = $('#password').val();
        var user_role_id = $('#user_role_id').val();
        if(email=='' || password==''){
            $('.login-error').html("Email & Password required field");
            return false;
        }
        $('.login-success').html('');
        $('.login-error').html('');
        $.ajax({
            url: "{{route('front-user.postLogin')}}",
            method: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                email: email,
                user_role_id:user_role_id,
                password: password
            },
            success: function(response) {
               $('.login-success').html(response.message);
               window.location.href = "{{ route('user.dashboard') }}";
            },
            error: function(jqXHR) {
                if (jqXHR.status === 422) {
                    var errors = jqXHR.responseJSON.errors;
                    $('.login-error').html(errors);
                }
            }
        });
    });
</script>
<!-- login form submission -->

<!-- user signup form submission -->
 <script>
    $(document).on('click', '#signupBtn', function (e) {
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var email = $('#email').val();
        var phone_number = $('#phone_number').val();
        var password = $('#password').val();
        if(first_name=='' || last_name=='' || email=='' || phone_number=='' || password==''){
            $('.login-error').html("All fields are required");
            return false;
        }
        $('.login-success').html('');
        $('.login-error').html('');
        $.ajax({
            url: "{{route('front-user.postSignup')}}",
            method: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                first_name: first_name,
                last_name: last_name,
                email: email,
                phone_number: phone_number,
                password: password
            },
            success: function(response) {
               // window.location.href = "{{ route('user.dashboard') }}";
               $('.login-success').html(response.message);
            },
            error: function(jqXHR) {
                if (jqXHR.status === 422) {
                    var errors = jqXHR.responseJSON.errors;
                    $('.login-error').html(errors);
                }
            }
        });
    });

</script>
<!-- user signup form submission -->

<!-- user profile form submission -->
<script>
$(document).on('submit', '#editProfileForm', function(e) {
    e.preventDefault();
    $btnName = $(this).find('button[type=submit]').html();
    $(this).find('button[type=submit]').prop('disabled', true);

    $(this).find('button[type=submit]').html(
        '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> ' +
        $btnName);
    const that = this;
    var formData = new FormData($('#editProfileForm')[0]);
    const attributes = {
        hasButton: true,
        btnSelector: '.saveBtn',
        btnText: $btnName,
        handleSuccess: function() {
            localStorage.setItem('flashMessage', datas['msg']);
            window.location.href = "{{ route('user.dashboard') }}";
        }
    };
    const ajaxOptions = {
        url: "{{ route('front-user.updateProfile') }}",
        method: 'post',
        data: formData
    };

    makeAjaxRequest(ajaxOptions, attributes);
});
</script>
<!-- user profile form submission -->

<!--  dashbaord.js -->
<script>
  $(document).ready(function () {
    $('#saveAddressBtn').on('click', function (e) {
        e.preventDefault();

        // Clear previous error states
        $('#addAddressForm input, #addAddressForm select').removeClass('is-invalid');

        let isValid = true;

        // Validate required fields
        const requiredFields = [
            { name: 'country', selector: '#country', invalidValue: 'Country/Region' },
            { name: 'firstname', selector: 'input[name="firstname"]' },
            { name: 'lastname', selector: 'input[name="lastname"]' },
            { name: 'address', selector: 'input[name="address"]' },
            { name: 'state', selector: '#state', invalidValue: 'State' },
            { name: 'city', selector: '#city', invalidValue: 'City' },
            { name: 'pinCode', selector: 'input[name="pinCode"]' },
            { name: 'phone', selector: 'input[name="phone"]' },
        ];

        requiredFields.forEach(field => {
            const $el = $(field.selector);
            const value = $el.val().trim();
            if (!value || (field.invalidValue && value === field.invalidValue)) {
                $el.addClass('is-invalid');
                isValid = false;
            }
        });

        // Additional validation for PIN and phone
        const pin = $('input[name="pinCode"]').val().trim();
        const phone = $('input[name="phone"]').val().trim();

        if (!/^\d{5,6}$/.test(pin)) {
            $('input[name="pinCode"]').addClass('is-invalid');
            isValid = false;
        }

        if (!/^\d{10}$/.test(phone)) {
            $('input[name="phone"]').addClass('is-invalid');
            isValid = false;
        }

        if (isValid) {
            const formData = new FormData(document.getElementById('addAddressForm'));
        
            fetch('/save-user-address', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert('Something went wrong. Please check your input.');
                }
            })
            .catch(error => {
                console.error('AJAX Error:', error);
                alert('Something went wrong. Please try again later.');
            });
        }

    });

    $('#cancelAddressBtn').on('click', function () {
        $('#add-address').modal('hide');
    });
});


    
    // Edit address case.
    // $(document).on('change', '.editState', function () {
    //     var stateId = $(this).val();
    //     var selectedCityId = null; // dynamically set if needed
    
    //     if (stateId) {
    //         $.ajax({
    //             url: '/get-cities/' + stateId,
    //             type: 'GET',
    //             success: function (response) {
    //                 var options = '<option value="">Select City</option>';
    //                 $.each(response, function (id, name) {
    //                     var selected = (id == selectedCityId) ? 'selected' : '';
    //                     options += '<option value="' + id + '" ' + selected + '>' + name + '</option>';
    //                 });
    //                 $('.editCity').html(options);
    //             }
    //         });
    //     } else {
    //         $('.editCity').html('<option value="">Select City</option>');
    //     }
    // });

    
     $(document).ready(function () {
        $('.edit-address-btn').on('click', function () {
            const addressId = $(this).data('id');
    
            $.ajax({
                url: '/get-user-address/' + addressId,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    
                    //console.log(response);
                    // Populate fields
                    $('#editAddressForm select[name="country"]').val(response.country);
                    $('#editAddressForm input[name="firstname"]').val(response.firstname);
                    $('#editAddressForm input[name="lastname"]').val(response.lastname);
                    $('#editAddressForm input[name="address"]').val(response.address);
                    $('#editAddressForm input[name="addressSecond"]').val(response.addressSecond);
                    $('#editAddressForm select[name="state"]').val(response.state);
                    $('#editAddressForm select[name="city"]').html(`<option value="${response.city}" selected>${response.city_name}</option>`);
                    $('#editAddressForm input[name="pinCode"]').val(response.pinCode);
                    $('#editAddressForm input[name="phone"]').val(response.phone);
                    $('#editAddressForm input[name="addressId"]').val(response.address_id);
    
                    $('#editAddressForm input[name="address_place_type"][value="' + response.address_place_type + '"]').prop('checked', true);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert('Something went wrong while fetching address.');
                }
            });
        });
    });

    $(document).ready(function () {
        $('#updateAddressBtn').on('click', function (e) {
            e.preventDefault();
    
            // Clear previous errors
            $('#editAddressForm input, #editAddressForm select').removeClass('is-invalid');
            $('.error-msg').remove();
    
            // Serialize form data
            const formData = $('#editAddressForm').serialize();
            
            console.log(formData);
    
            // AJAX submission
            $.ajax({
                url: '/update-address', // Change to your actual route
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Required for Laravel
                },
                success: function (response) {
                    if (response.success) {
                        alert('Address updated successfully!');
                        $('#edit-address').modal('hide');
                        // Optionally reload address list
                        location.reload();
                    } else {
                        alert(response.message || 'Failed to update address.');
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert('Something went wrong. Please try again.');
                }
            });
        });
    
        // Cancel button action
        $('#cancelAddressBtn').on('click', function () {
            $('#edit-address').modal('hide');
        });
    });
</script>
<!--  dashbaord.js -->

<!-- Save Address -->
 <script>
    $(document).on('click', '#addAddressBtn', function (e) {
        // Serialize form data
        var address_id = $('#address_id').val();
        var address = $('#address').val();
        var landmark = $('#landmark').val();
        var name = $('#name').val();
        var phone_number = $('#phone_number').val();
        var country = $('#country').val();
        var state = $('#state').val();
        var city = $('.city').val();
        var postal_code = $('#postal_code').val();
        var type = $('#type').val();
        var address_type = $('input[name="address_type"]:checked').val();
        alert(city);
        
        $('.add-adddress-error').html('');
        $('.add-adddress-success').html('');
        $.ajax({
            url: "{{ route('front-user.addAddress') }}",
            method: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                address_id: address_id,
                address: address,
                landmark: landmark,
                name: name,
                phone_number: phone_number,
                country_id: country,
                state_id: state,
                city_id: city,
                postal_code: postal_code,
                type: type,
                address_type: address_type,
            },
            success: function(response) {
                if(response.status=='error'){
                    $('.add-adddress-error').html(response.msg);
                } else {
                   // $('#change-password-div').hide();
                  //  $('#success-password-msg').show();
                   $('.add-adddress-success').html(response.msg);
                   setTimeout(function() {
                        window.location.href = "{{ route('user.dashboard') }}";
                    }, 3000);
                  
                }
            },
            error: function(jqXHR) {
                if (jqXHR.status === 422) {
                    var errors = jqXHR.responseJSON.errors;
                    $('.add-adddress-error').html(errors);
                }
            }
        });
    });
</script>
<!-- Save Address -->

<!--   Deleted Address -->
<script>
$(document).on('click', '#removeAddressBtn', function () {
    var adddressId = $(this).attr('data-adddressId');
    confirm("You want to delete address. \n Please make sure by click on 'OK' button.");
    if (adddressId) {
        $.ajax({
            url: '/addresses/delete-address/' + adddressId,
            type: 'GET',
            success: function (response) {
                if(response.status){
                    alert(response.msg);
                    window.location.href = "{{ route('user.dashboard') }}";
                } else {
                    alert(response.msg);
                }
            }
        });
    } 
});

$(document).on('click', '.codeBlock', function () {
    var affiliateId = $(this).attr('data-affiliateId');
    var customerId = $(this).attr('data-customerId');
    var couponId = $(this).attr('data-couponId');
    var status = $(this).attr('data-status');
    confirm("You want to block this code. \n Please make sure by click on 'OK' button.");
    if (affiliateId !='' && customerId !='' && couponId !='' ) {
        $.ajax({
            url: '/block-referalcode/' + affiliateId + '/' + customerId +  '/' + couponId + '/' + status,
            type: 'GET',
            success: function (response) {
                if(response.status){
                    alert(response.message);
                    window.location.href = "{{ route('user.dashboard') }}";
                } else {
                    alert(response.message);
                }
            }
        });
    } 
});

/* Selected primary address */
$(document).on('click', '.primary_address', function () {
    var adddressId = $('input[name="primary_address"]:checked').val();
    confirm("You want to make primary address. \n Please make sure by click on 'OK' button.");
    if (adddressId) {
        $.ajax({
            url: '/addresses/make-primary-address/' + adddressId,
            type: 'GET',
            success: function (response) {
                if(response.status){
                    alert(response.msg);
                    window.location.href = "{{ route('user.dashboard') }}";
                } else {
                    alert(response.msg);
                }
            }
        });
    } 
});

/* get address by id */
$(document).on('click', '.edit_address', function () {
    var adddressId = $(this).attr('data-adddressId');
    if (adddressId) {
        $.ajax({
            url: '/addresses/get-address/' + adddressId,
            type: 'GET',
            success: function (response) {
                if(response!='NULL'){
                    var addressData = response[0];
                    // alert(addressData.phone_number);
                    $('#address_id').val(addressData.id);
                    $('#address').val(addressData.address);
                    $('#landmark').val(addressData.landmark);
                    $('.edit_name').val(addressData.name);
                    $('.edit_phone_number').val(addressData.phone_number);
                    $('#postal_code').val(addressData.postal_code);
                    
                    // $('#country').val(addressData.country_id).niceSelect('update');
                    // $('#state').val(addressData.state_id).niceSelect('update');
                    // $('#city').val(addressData.city_id).niceSelect('update');
                    // $('#type').val(addressData.type).niceSelect('update');

                    $('#country').val(addressData.country_id);
                    $('#state').val(addressData.state_id);
                    $('#city').val(addressData.city_id);
                    $('#type').val(addressData.type);

                    if(addressData.address_type==1){
                        $('.address_type_home').prop('checked', true);
                    }
                    if(addressData.address_type==2){
                        $('.address_type_office').prop('checked', true);
                    }
                    if(addressData.address_type==3){
                        $('.address_type_other').prop('checked', true);
                    }
                } 
            }
        });
    } 
});
/* get address by id */

/* Selected primary address */
</script>
<!--   Deleted Address -->

<!-- get state & city dynamic -->
<script>
// $(document).on('change', '#country', function(e) {
//     var countryId = $(this).val();
//     var selectedStateId = null; // or set this dynamically

//     if (countryId) {
//         $.ajax({
//             url: '/get-states/' + countryId,
//             type: 'GET',
//             success: function (response) {
//                 var options = '<option value="">Select State</option>';
//                 $.each(response, function (id, name) {
//                     var selected = (id == selectedStateId) ? 'selected' : '';
//                     options += '<option value="' + id + '" ' + selected + '>' + name + '</option>';
//                 });
//                 $('#state').html(options);
//             }
//         });
//     } else {
//         $('#state').html('<option value="">Select State</option>');
//     }
// });


$(document).on('change', '.city_dropdown', function() {
    var stateId = $(this).val();
    var $cityDropdown = $('#city'); // The dependent dropdown
    console.log(' stateId : ', stateId);
    if (stateId) {
        $.ajax({
            url: '/get-cities/' + stateId,
            type: 'GET',
            success: function (response) {
                var options = '<option value="">Select City</option>';
                $.each(response, function (id, name) {
                    // Check if variable selectedCityId is defined elsewhere
                    var selected = (typeof selectedCityId !== 'undefined' && id == selectedCityId) ? 'selected' : '';
                    options += '<option value="' + id + '" ' + selected + '>' + name + '</option>';
                });

                // 2. Update the HTML of the dependent select
                $cityDropdown.html(options);

                // 3. CRITICAL: Tell Nice Select to refresh the visual UI
               // $cityDropdown.niceSelect('update');
            }
        });
    } else {
       //  $cityDropdown.html('<option value="">Select City</option>');
       //  $cityDropdown.niceSelect('update');
    }
});
</script>
<!-- get state & city dynamic -->


<!-- change password -->
 <script>
    $(document).on('click', '#changePasswordBtn', function (e) {
         $('#change-password-div').show();
        $('#success-password-msg').hide();
        var current_password = $('#current_password').val();
        var new_password = $('#new_password').val();
        var confirm_password = $('#confirm_password').val();
        if(current_password=='' || new_password=='' || confirm_password==''){
            $('.change-pass-error').html("Password field are required");
            return false;
        }
        $('.change-pass-error').html('');
        $('.change-pass-success').html('');
        $.ajax({
            url: "{{route('front-user.changePassword')}}",
            method: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                current_password: current_password,
                new_password: new_password,
                confirm_password: confirm_password
            },
            success: function(response) {
                if(response.status=='error'){
                    $('.change-pass-error').html(response.msg);
                } else {
                    $('#change-password-div').hide();
                    $('#success-password-msg').show();
                }
            },
            error: function(jqXHR) {
                if (jqXHR.status === 422) {
                    var errors = jqXHR.responseJSON.errors;
                    $('.change-pass-error').html(errors);
                }
            }
        });
    });
</script>
<!-- change password -->

<!-- Fetch Order detail by id -->
<script>
    $(document).ready(function() {
        $('.track-order').click(function() {
            var itemId = $(this).attr('data-orderId'); // Get ID from button data attribute
            $.ajax({
                url: '/order-details/'+ itemId, // URL to fetch data from
                type: 'GET',
                success: function(response) {
                    // 1. Inject the response into the modal body
                    $('#orderDetailContent').html(response.html); 
                    
                    // 2. Open the modal programmatically
                    $('#orderTrackModal').modal('show'); 
                },
                error: function() {
                    alert('Failed to load data.');
                }
            });
        });

        $('.orderTrackModalClose').click(function() {
            $('#orderTrackModal').modal('hide'); 
        });

        $('.roletab').click(function() {
            var roleId = $(this).attr('data-roleId');
            $('#user_role_id').val(roleId);
        });

    });
</script>
<!-- Fetch Order detail by id -->

<script>
    $(document).ready(function() {
        $.validator.addMethod('alphanumericCouponCode', function(value, element) {
            return this.optional(element) || /^[A-Za-z0-9]+$/.test(value);
        }, 'Coupon code can only contain letters and numbers.');

        $.validator.addMethod('affiliatePercentageLimit', function(value, element) {
            if ($('#discount_type').val() !== 'percentage' || this.optional(element)) {
                return true;
            }

            const maximumPercentage = parseFloat($('#couponForm').data('max-percentage'));
            return !isNaN(maximumPercentage) && parseFloat(value) <= maximumPercentage;
        });

        $(function () {
            $('form#couponForm').validate({
                rules: {
                    name: 'required',
                    coupon_code: {
                        required: true,
                        alphanumericCouponCode: true
                    },
                    discount_value: {
                        required: true,
                        number: true,
                        min: 0.01,
                        affiliatePercentageLimit: true
                    },
                    min_cart_value: {
                        number: true,
                        min: 0
                    },
                    max_discount: {
                        number: true,
                        min: 0
                    },
                    available_coupons: {
                        required: function() {
                            return $('#is_unlimited').val() === '0';
                        },
                        digits: true,
                        min: 1
                    },
                    per_user_avalibity: {
                        required: true,
                        digits: true,
                        min: 1
                    },
                    start_date: 'dateISO',
                    end_date: 'dateISO'
                },
                messages: {
                    name: 'Please enter a name.',
                    coupon_code: {
                        required: 'Please enter a coupon code.',
                        alphanumericCouponCode: 'Use letters and numbers only, without spaces or symbols.'
                    },
                    discount_value: {
                        required: 'Please enter a discount value.',
                        number: 'Enter a valid number.',
                        min: 'Discount value must be greater than zero.',
                        affiliatePercentageLimit: 'Discount percentage exceeds your affiliate maximum.'
                    },
                    min_cart_value: {
                        number: 'Enter a valid number.',
                        min: 'Minimum cart value cannot be negative.'
                    },
                    max_discount: {
                        number: 'Enter a valid number.',
                        min: 'Maximum discount cannot be negative.'
                    },
                    available_coupons: {
                        required: 'Enter the number of available coupons.',
                        digits: 'Enter a whole number.',
                        min: 'Available coupons must be at least one.'
                    },
                    per_user_avalibity: {
                        required: 'Number of coupons available per user.',
                        digits: 'Enter a whole number.',
                        min: 'Per user available coupons must be at least one.'
                    },
                    start_date: 'Enter a valid start date.',
                    end_date: 'Enter a valid end date.'
                },
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });

        $('#is_unlimited').on('change', function() {
            const isUnlimited = $(this).val() === '1';
            $('#availableCouponsField').toggle(!isUnlimited);
            if (isUnlimited) {
                $('#available_coupons').val('').removeClass('is-invalid');
            }
        }).trigger('change');

        $('#discount_type').on('change', function() {
            $('#discount_value').valid();
        });

        let affiliateCouponPage = 1;

        function renderAffiliateCouponPagination(pagination) {
            const controls = $('#affiliateCouponPagination').empty();
            if (!pagination || pagination.total === 0) {
                return;
            }

            controls.append($('<span>').text(
                `Page ${pagination.current_page} of ${pagination.last_page} (${pagination.total} coupons)`
            ));

            if (pagination.last_page > 1) {
                const buttons = $('<div class="btn-group" role="group" aria-label="Coupon list pages"></div>');
                buttons.append($('<button>', {
                    type: 'button',
                    class: 'btn btn-outline-secondary affiliateCouponPage',
                    text: 'Previous',
                    disabled: pagination.current_page <= 1
                }).attr('data-page', pagination.current_page - 1));
                buttons.append($('<button>', {
                    type: 'button',
                    class: 'btn btn-outline-secondary affiliateCouponPage',
                    text: 'Next',
                    disabled: pagination.current_page >= pagination.last_page
                }).attr('data-page', pagination.current_page + 1));
                controls.append(buttons);
            }
        }

        function loadAffiliateCoupons(page = 1) {
            const list = $('#affiliateCouponList');
            if (!list.length) {
                return;
            }

            affiliateCouponPage = page;
            list.html('<tr><td colspan="6" class="text-center">Loading coupons...</td></tr>');
            $.get("{{ route('front-user.coupon.index') }}", { page: page })
                .done(function(response) {
                    list.empty();
                    const coupons = response.coupons || [];
                    renderAffiliateCouponPagination(response.pagination);
                    if (!response.success || !coupons.length) {
                        list.append($('<tr>').append($('<td>', {
                            colspan: 6,
                            class: 'text-center',
                            text: 'No coupons created yet.'
                        })));
                        return;
                    }

                    $.each(coupons, function(_, coupon) {
                        const discount = coupon.discount_type === 'percentage'
                            ? `${coupon.discount_value}%`
                            : `₹${coupon.discount_value}`;
                        const availability = Number(coupon.is_unlimited)
                            ? 'Unlimited'
                            : `${coupon.available_coupons} total / ${coupon.per_user_avalibity} per user`;
                        const editButton = $('<button>', {
                            type: 'button',
                            class: 'btn btn-sm btn-outline-primary editAffiliateCoupon',
                            text: 'Edit'
                        }).data('coupon', coupon);

                        list.append($('<tr>')
                            .append($('<td>').text(coupon.name))
                            .append($('<td>').text(coupon.coupon_code))
                            .append($('<td>').text(discount))
                            .append($('<td>').text(availability))
                            .append($('<td>').text(Number(coupon.is_active) ? 'Active' : 'Inactive'))
                            .append($('<td>').append(editButton)));
                    });
                })
                .fail(function() {
                    list.html('<tr><td colspan="6" class="text-center text-danger">Could not load coupons.</td></tr>');
                });
        }

        $(document).on('click', '.affiliateCouponPage', function() {
            if (!$(this).prop('disabled')) {
                loadAffiliateCoupons(Number($(this).data('page')));
            }
        });

        $(document).on('click', '.editAffiliateCoupon', function() {
            const coupon = $(this).data('coupon');
            const form = $('#couponForm');

            $.each({
                coupon_id: coupon.id,
                name: coupon.name,
                coupon_code: coupon.coupon_code,
                discount_type: coupon.discount_type,
                discount_value: coupon.discount_value,
                min_cart_value: coupon.min_cart_value,
                max_discount: coupon.max_discount,
                start_date: coupon.start_date,
                end_date: coupon.end_date,
                is_unlimited: coupon.is_unlimited,
                available_coupons: coupon.available_coupons,
                per_user_avalibity: coupon.per_user_avalibity,
                is_active: coupon.is_active
            }, function(name, value) {
                form.find(`[name="${name}"]`).val(value ?? '');
            });

            $('#discount_type, #is_unlimited').trigger('change');
            $('#couponModalCreate .modal-title').text('Edit Coupon');
            bootstrap.Modal.getOrCreateInstance(document.getElementById('couponModalCreate')).show();
        });

        $('#saveCouponFormChangesBtn').on('click', function() {
            const form = $('#couponForm');
            if (!form.valid()) {
                return;
            }

            const button = $(this);
            const validator = form.validate();
            button.prop('disabled', true);

            $.ajax({
                url: "{{ route('front-user.coupon.save') }}",
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    const message = $('#couponModalCreate .message');
                    message.removeClass('alert-danger').addClass('alert alert-success').text(response.message);
                    form[0].reset();
                    validator.resetForm();
                    form.find('.is-invalid').removeClass('is-invalid');
                    $('#is_unlimited').trigger('change');
                    $('#couponModalCreate .modal-title').text('Create Coupon');
                    loadAffiliateCoupons(1);
                },
                error: function(xhr) {
                    const response = xhr.responseJSON || {};
                    const message = $('#couponModalCreate .message');
                    message.removeClass('alert-success').addClass('alert alert-danger')
                        .text(response.message || 'Unable to save the coupon. Please try again.');

                    if (response.errors) {
                        const fieldErrors = {};
                        $.each(response.errors, function(field, errors) {
                            fieldErrors[field] = errors[0];
                        });
                        validator.showErrors(fieldErrors);
                    }
                },
                complete: function() {
                    button.prop('disabled', false);
                }
            });
        });

        $('#couponModalCreate').on('hidden.bs.modal', function() {
            const couponForm = $('#couponForm');
            couponForm[0].reset();
            couponForm.validate().resetForm();
            couponForm.find('.is-invalid').removeClass('is-invalid');
            $('#is_unlimited').trigger('change');
            $(this).find('.modal-title').text('Create Coupon');
            $(this).find('.message').removeClass('alert alert-success alert-danger').text('');
        });

        loadAffiliateCoupons();
    });
</script>
@stack('scripts')

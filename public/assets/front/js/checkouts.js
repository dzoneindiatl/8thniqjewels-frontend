
/* Billing Address country */

$('#country').on('change', function () {
    var countryId = $(this).val();
    var selectedStateId = null; // or set this dynamically

    if (countryId) {
        $.ajax({
            url: '/get-states/' + countryId,
            type: 'GET',
            success: function (response) {
                var options = '<option value="">Select State</option>';
                $.each(response, function (id, name) {
                    var selected = (id == selectedStateId) ? 'selected' : '';
                    options += '<option value="' + id + '" ' + selected + '>' + name + '</option>';
                });
                $('#state').html(options);
            }
        });
    } else {
        $('#state').html('<option value="">Select State</option>');
    }
});

$('#state').on('change', function () {
    var stateId = $(this).val();
    var selectedCityId = null; // or set this dynamically

    if (stateId) {
        $.ajax({
            url: '/get-cities/' + stateId,
            type: 'GET',
            success: function (response) {
                // console.log(response);
                var options = '<option value="">Select City</option>';
                $.each(response, function (id, name) {
                    var selected = (id == selectedCityId) ? 'selected' : '';
                    options += '<option value="' + id + '" ' + selected + '>' + name + '</option>';
                });
                $('#city').html(options);
            }
        });
    } else {
        $('#city').html('<option value="">Select City</option>');
    }
});

/* Shipping Addrress country */

$('#shipping_country').on('change', function () {
    var countryId = $(this).val();
    var selectedStateId = null; // or set this dynamically

    if (countryId) {
        $.ajax({
            url: '/get-states/' + countryId,
            type: 'GET',
            success: function (response) {
                var options = '<option value="">Select State</option>';
                $.each(response, function (id, name) {
                    var selected = (id == selectedStateId) ? 'selected' : '';
                    options += '<option value="' + id + '" ' + selected + '>' + name + '</option>';
                });
                $('#shipping_state').html(options);
            }
        });
    } else {
        $('#shipping_state').html('<option value="">Select State</option>');
    }
});

$('#shipping_state').on('change', function () {
    var stateId = $(this).val();
    var selectedCityId = null; // or set this dynamically

    if (stateId) {
        $.ajax({
            url: '/get-cities/' + stateId,
            type: 'GET',
            success: function (response) {
                // console.log(response);
                var options = '<option value="">Select City</option>';
                $.each(response, function (id, name) {
                    var selected = (id == selectedCityId) ? 'selected' : '';
                    options += '<option value="' + id + '" ' + selected + '>' + name + '</option>';
                });
                $('#shipping_city').html(options);
            }
        });
    } else {
        $('#shipping_city').html('<option value="">Select City</option>');
    }
});

// Billing Address validation
document.addEventListener('DOMContentLoaded', function () {
    const billingForm = document.getElementById('addressForm');
    const shippingForm = document.getElementById('shippingAddressForm');

    function handleValidation(form, submitButton, redirectUrl) {
        if (form && submitButton) {
            submitButton.addEventListener('click', function (e) {
                e.preventDefault();
                let isValid = true;

                // Clear previous errors
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

                const showError = (input, message) => {
                    input.classList.add('is-invalid');
                    const error = document.createElement('div');
                    error.className = 'invalid-feedback';
                    error.style.color = 'red';
                    error.innerText = message;
                    input.parentNode.appendChild(error);
                    isValid = false;
                };

                // Scoped form fields
                const country = form.querySelector('[name="country"]');
                const firstName = form.querySelector('[name="firstname"]');
                const lastName = form.querySelector('[name="lastname"]');
                const address = form.querySelector('[name="address"]');
                const city = form.querySelector('[name="city"]');
                const state = form.querySelector('[name="state"]');
                const pinCode = form.querySelector('[name="pinCode"]');
                const phone = form.querySelector('[name="phone"]');

                // Validations
                if (!country || !country.value || country.value === 'Country/Region') {
                    showError(country, 'Please select a country');
                }
                if (!firstName || !firstName.value.trim()) {
                    showError(firstName, 'First name is required');
                }
                if (!lastName || !lastName.value.trim()) {
                    showError(lastName, 'Last name is required');
                }
                if (!address || !address.value.trim()) {
                    showError(address, 'Address is required');
                }
                if (!city || !city.value || city.value === 'City') {
                    showError(city, 'Please select a city');
                }
                if (!state || !state.value || state.value === 'State') {
                    showError(state, 'Please select a state');
                }
                if (!pinCode || !pinCode.value.trim()) {
                    showError(pinCode, 'PIN code is required');
                } else if (!/^\d{6}$/.test(pinCode.value.trim())) {
                    showError(pinCode, 'PIN code must be 6 digits');
                }
                if (!phone || !phone.value.trim()) {
                    showError(phone, 'Phone number is required');
                } else if (!/^\d{10}$/.test(phone.value.trim())) {
                    showError(phone, 'Phone number must be 10 digits');
                }

                if (isValid) {
                    const formData = new FormData(form);

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
                            if (data.success) {
                                alert(data.message);
                                window.location.href = data.redirect_url;
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
        }
    }

    // Attach validation to both forms
    handleValidation(billingForm, document.getElementById('save_billing_address'));
    handleValidation(shippingForm, document.getElementById('save_shipping_address'));
});

// Biling Addrress for close/open
$(document).ready(function () {
    $('#add_new_billing_address').on('click', function () {
        /* var btn = $(this);
        if (btn.text().trim() == "Cancel") {
            btn.text("Add New Billing Address");
        } else {
            btn.text("Cancel");
        } */
        $('#main_billing').slideToggle();
    });
});

// Shipping Addrress for close/open
$(document).ready(function () {
    $('#add_new_shipping_address').on('click', function () {
        $('#main_shipping').slideToggle();
    });
});

/*Same as billing address*/
$('.select_shipping_address').click(function () {
    if ($(this).prop('checked') === true) {
        $('#main_shipping').slideUp();
        $('#same_as_billing').prop('checked', false);
    }
});

function toggleSamasBilling() {
    const checkbox = document.getElementById('same_as_billing');
    if (checkbox.checked) {
        $('#main_shipping').slideUp();
        $('#addAddressFromDiv').slideUp();
    } else {
        $('#main_shipping').slideDown();
    }
}

function OpenAddressFrom() {
    $('#addAddressFromDiv').slideDown();
}


/*End Same as billing address*/

/* for payment process */
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


var totalShippingCharge = 0;
$('#pay_now').off('click').on('click', function (e) {
    let that = $(this);
    $('.pay_error').html('');
    $('.pay_success').html('');

    var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    console.log(' cart items ', cartItems.length);
    if (parseInt(cartItems.length) === 0) {
        $('#pay_now').remove();
        $('#shoopping_continue').show();
        return false;
    }

    if (!$('.payment_type:checked').length && !$('#wallet').is(':checked')) {
        $('.pay_error').html('Please select a payment method.');
        return false;
    }

    let terms = $('#terms').is(':checked');
    if (terms === false) {
        $('.pay_error').html('Please checked "Term & Condition" policy.');
        return;
    }

    let selectedBilling = $('.billing_address:checked').val();
    if (!selectedBilling) {
        $('.pay_error').html('Please select at least one billing  address.');
        return;
    } else {
        $('.pay_error').html('');
    }

    let isSameAsBillingChecked = $('#same_as_billing').is(':checked');
    let selectedShipping = $('.shipping_address:checked').val();
    if (!isSameAsBillingChecked && !selectedShipping) {
        $('.pay_error').html('Please select at least one shipping address.');
        return;
    } else {
        $('.pay_error').html('');
    }

    if ($('[id="cash"]:checked').length != 0 && $('[id="wallet"]:checked').length != 0) {
        e.preventDefault();
        $('.pay_error').html('You cant order with COD & Wallet Togeter.');
        return;
    } else {
        $('.pay_error').html('');
    }

    var billing_id = selectedBilling;
    var shipping_id = (isSameAsBillingChecked === true) ? billing_id : selectedShipping;

    // Quantity Validation on checkout page
    var isQuantity = true;
    cartItems.forEach(function (item) {
        // get variant color and size combo exact qty
        const { sku: product_selected_variant_sku } = getVariantSku(item);

        var getExactVariantComboQty = 0;
        const originalHtmlMinus = $(".addToDecQtyBtn").html();
        const originalHtmlPlus = $(".addToNewQtyBtn").html();
        $.ajax({
            url: getVarientReaminingQty,
            type: 'POST',
            async: false,
            cache: false,
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                product_id: item.productId,
                sku: product_selected_variant_sku,
            },
            success: function (response) {
                getExactVariantComboQty = response;

                console.log('maxSellingQty 1 : ', maxSellingQty);
                if (parseInt(maxSellingQty) > parseInt(getExactVariantComboQty) || parseInt(maxSellingQty) == 0) {
                    maxSellingQtyNew = getExactVariantComboQty;
                } else {
                    maxSellingQtyNew = maxSellingQty;
                }
                console.log('getExactVariantComboQty : ', getExactVariantComboQty);
                console.log('maxSellingQty 2 : ', maxSellingQty);
                console.log('maxSellingQtyNew 3 : ', maxSellingQtyNew);

                $(".addToDecQtyBtn").attr("disabled", false).html(originalHtmlMinus);
                $(".addToNewQtyBtn").attr("disabled", false).html(originalHtmlPlus);
            },
            error: function (xhr) {
                // alert('Failed to add to cart. Please try again.');
            }
        });
        // get variant color and size combo exact qty

        var quantity = item.quantity;
        if (parseInt(quantity) > parseInt(maxSellingQtyNew) && maxSellingQtyNew != 0) {
            isQuantity = false;
            e.preventDefault();
            $('.pay_error').show();
            $(".pay_error").html("You can't order above max quantity of product, Your product quantity is exceed : " + quantity);
            setTimeout(function () { $(".pay_error").html(""); }, 5000);
        }
    });
    if (!isQuantity) {
        return false;
    }
    // Quantity Validation on checkout page

    console.log('calculate cart : ', cartItems);
    var totals = calculateCartTotals(cartItems);
    var fullOrderTotal = totals.fullOrderTotal;
    var subTotal = totals.finalAmount;
    var wallet_amount = 0;

    // COD order should be less than 500 validation
    if ($('[id="cash"]:checked').val() == 'cod' && subTotal > codMaxLimit) {
        $(".pay_error").html("Cash on Delivery available for orders up to ₹" + codMaxLimit);
        return false;
    } else {
        $(".pay_error").html("");
    }

    if (parseInt(subTotal) == 0) { //  order amount should be greater than 0 rs validation
        $(".pay_error").html("You cant process order with zero amount.");
        return false;
    } else {
        $(".pay_error").html("");
    }

    if (parseInt(subTotal) < 0) { //  order amount should be greater than 0 rs validation
        e.preventDefault();
        $(".pay_error").html("You cant process order with minus amount.");
        return false;
    } else {
        $(".pay_error").html("");
    }
    // COD order should be less than 5000 validation

    var payment_type = $('.payment_type:checked').val();

    var walletCheckbox = document.getElementById('wallet');
    var wallet_type = walletCheckbox?.checked ? "wallet" : null;

    var codCheckbox = document.getElementById('cash');
    var cod_type = codCheckbox?.checked ? "cod" : null;
    console.log('wallet_type : ', wallet_type);
    console.log('cod_type : ', cod_type);

    if (wallet_type && cod_type != 'cod') {
        // Get real available waller balance 
        var walletBalance = 0;
        $.ajax({
            url: '/get-user-wallet/' + USERID,
            type: 'GET',
            async: false,
            cache: false,
            success: function (response) {
                console.log('response  : ', response);
                walletBalance = parseFloat(response) || 0;
            }
        });
        // Get real available waller balance 

        // var walletBalance = parseFloat(
        // document.getElementById('wallet_amount').innerText.replace(/[^\d.]/g, '')
        // parseFloat(localStorage.getItem('uw_amount'))
        // ) || 0;
        console.log('user_id  : ', USERID);
        console.log('walletBalance  : ', walletBalance);

        // var subTotal = parseFloat($('.finalAmount').text().replace(/[^\d.]/g, ''));
        if (walletCheckbox?.checked) {
            if (parseFloat(walletBalance) >= (subTotal)) {
                wallet_amount = subTotal;
                payment_type = "wallet";
                subTotal = 0;
            } else if (payment_type === "razorpay") {
                wallet_amount = walletBalance;
                subTotal = subTotal - walletBalance;
            } else if (payment_type === "phonepay") {
                wallet_amount = walletBalance;
                subTotal = subTotal - walletBalance;
            }
        }
    } else {
        var subTotal = parseFloat($('.finalAmount').text().replace(/[^\d.]/g, ''));
    }

    shippingCalculation(shipping_id, cartItems, subTotal);
    var postData = {
        cartItems: cartItems,
        sub_total: subTotal,
        payment_mode: payment_type,
        coupon_id: localStorage.getItem('coupon_id'),
        coupon_discount: parseFloat(localStorage.getItem('coupon_discount')) || 0,
        wallet_amount: wallet_amount,
        order_total: fullOrderTotal,
        pending_amount: totals.pendingAmount,
        billing_id: billing_id,
        shipping_id: shipping_id,
        shippingcharge: totalShippingCharge,
    };
    // console.log('postData : ', postData); return false;
    that.prop('disabled', true).text('Please wait...');
    var url = window.location.origin + "/place-order";
    $.ajax({
        type: "POST",
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json'
        },
        data: JSON.stringify(postData),
        success: function (data) {
            if (data.success == false) {
                console.log(' final order response ', data);
                $(".pay_error").html(data.message);
                setTimeout(function () { $(".pay_error").html(""); }, 5000);
            } else {
                if (payment_type === "wallet" && data.success) {
                    localStorage.removeItem('cartItems');
                    localStorage.removeItem('coupon_id');
                    localStorage.removeItem('coupon_discount');
                    window.location.href = data.url;
                }
                if (payment_type == 'razorpay') {
                    if (data.success) {
                        if (data.type == 'wallet') {
                            localStorage.removeItem('cartItems');
                            location.href = window.location.origin + "/dashboard";
                        } else {
                            var options = {
                                "key": RAZORPAYKEY,
                                "amount": data.data.amount,
                                "currency": "INR",
                                "name": "VASVI",
                                "description": "Transaction",
                                "image": "https://vasvi.in/uploads/settings/AUG2025/1755156000-settings.png",
                                "order_id": data.data.id,
                                "callback_url": window.location.origin + "/checkout-callback",
                                "prefill": {
                                    "name": USERNAME,
                                    "email": USEREMAIL,
                                    "contact": USERPHONE
                                },
                                "notes": {
                                    "coupon_id": postData.coupon_id,
                                    "coupon_discount": postData.coupon_discount,
                                    "shippingcharge": postData.shippingcharge,
                                    "billing_id": postData.billing_id,
                                    "shipping_id": postData.shipping_id,
                                },
                                "theme": {
                                    "color": "#3399cc"
                                }
                            };
                            var rzp1 = new Razorpay(options);
                            rzp1.open();
                        }
                    }
                } else if (payment_type == 'phonepay') {
                    if (data.success) {
                        that.prop('disabled', false).text('Pay Now');
                        $('.pay_success').html("You are redirecting to Phone Pay App");
                        setTimeout(function () {
                            $(".pay_success").html("");
                            window.location.href = data.url;
                        }, 2000);
                    } else {
                        $(".pay_error").html("Something went wrong with PhonePay Payment API");
                    }
                } else {
                    if (data.success) {
                        localStorage.removeItem('cartItems');
                        localStorage.removeItem('coupon_id');
                        localStorage.removeItem('coupon_discount');
                        window.location.href = data.url;
                    }
                }
            }
            that.prop('disabled', false).text('Pay Now');
        },
        error: function (err) {
            that.prop('disabled', false).text('Pay Now');
            $('.error-msg').remove();
            if (err.status == 422) {
                $("#add-new-billing-address").addClass('d-none');
                $('#new-billing-address').toggleClass('show');
                $.each(err.responseJSON.errors, function (i, error) {
                    var el = $(document).find('[name="' + i + '"]');
                    el.after($('<span class="error-msg" style="color: red;">' + error[0] + '</span>'));
                });
            }
        }
    });
});



// Edit address case.
$(document).on('change', '.editState', function () {
    var stateId = $(this).val();
    var selectedCityId = null; // dynamically set if needed

    if (stateId) {
        $.ajax({
            url: '/get-cities/' + stateId,
            type: 'GET',
            success: function (response) {
                var options = '<option value="">Select City</option>';
                $.each(response, function (id, name) {
                    var selected = (id == selectedCityId) ? 'selected' : '';
                    options += '<option value="' + id + '" ' + selected + '>' + name + '</option>';
                });
                $('.editCity').html(options);
            }
        });
    } else {
        $('.editCity').html('<option value="">Select City</option>');
    }
});


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
                console.log(response);
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

        // let isValid = true;
        const formData = $('#editAddressForm').serialize();

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


renderCart();

function renderCart() {
    var cartItems = [];
    var cartOutOfStock = [];
    var cartAllItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    cartAllItems.forEach(function (item, index) {
        //  product is out of stock 

        $.ajax({
            url: isOutOfStock,
            type: 'POST',
            async: false,
            cache: false,
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                product_id: item.productId,
                // variant_sku: variant_sku,
            },
            success: function (response) {
                if (!response) {
                    // cartItems.push(item);
                } else {
                    cartOutOfStock.push(item);
                }
                cartItems.push(item);
            },
            error: function (xhr) {
                // alert('Failed to add to cart. Please try again.');
            }
        });
        //  product is out of stock 
    });
    if (cartOutOfStock != '') {
        document.addEventListener("DOMContentLoaded", function () {
            var myModal = new bootstrap.Modal(document.getElementById('out-of-stock-product'));
            myModal.show();
        });
        // confirm('You have some out of stock product in cart, You can buy these product when will be in stock.');
        console.log(' cartItems new ', cartItems);
    }

    console.log(' render cart ', cartItems);
    var $container = $('#checkout-cart-container');
    let couponDiscount = parseFloat(localStorage.getItem('coupon_discount')) || 0;
    if (cartItems.length === 0) {
        $container.html('<p>Your cart is empty.</p>');
        $('#totalMrp, #delivery, #totalDiscount, #subTotal, #couponDiscount, #total-items, #grandTotal, #taxableAmount, #taxPrice, .finalAmount').text('₹0');
        $('#pay_now').remove();
        $('#shoopping_continue').show();
        $('.Delivery-sec').html('<h3>Your Cart is empty !!!</h3><img src="https://vasvi.in/assets/front/img/vasvi-cart-empty.jpg" style="width:200px !important;height:200px !important" alt="cart empty"></br><button class="w-100 full-btn" id="shoopping_continue"><a href="https://vasvi.in/" style="color:#fff">Add to Cart Any Item</a></button>');
        return;
    }

    let output = '';
    let delivery = 0;
    let totalMrp = 0;
    let totalDiscount = 0;
    let totalTaxPrice = 0;
    let taxOption = 'inclusive';
    let qty = 0;
    let sellingPrice = 0;
    let itemPrice = 0;
    console.log(' before loop ', cartItems);
    cartItems.forEach(function (item) {
        qty = item.quantity;
        if (item.instock == 0) {
            $('.codPaymentDiv').hide();
        }
        sellingPrice = item.sellingPrice;
        itemPrice = item.price;
        totalMrp += itemPrice * item.quantity;
        totalDiscount += (itemPrice - sellingPrice) * item.quantity;

        taxOption = item.tax_option;
        totalTaxPrice += item.tax_price;

        output += `<div class="cart-lists mb-20">
            <div class="row">
                <div class="col-md-3">
                    <div class="pro-thumbnail">
                        <a href="#">
                            <img class="img-fluid" src="${item.image}" alt="${item.name}" />
                        </a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="product-details-des cart">
                        <h3 class="mt-10 mb-30">${item.name}</h3>
                        <p> QTY : ${item.quantity}</p>
                        <div class="pricebox">
                            <span class="regular-price">₹${Math.floor(sellingPrice)}</span>
                        </div>
                        <div class="delete-cart-list"></div>
                    </div>
                </div>
            </div>
        </div>`;
    });
    $container.html(output);

    let subTotal = totalMrp - totalDiscount;
    let grandTotal = subTotal - couponDiscount;
    let taxableAmount = grandTotal;
    if (taxOption == 'inclusive') {
        taxableAmount = grandTotal - totalTaxPrice;
    } else if (taxOption == 'exclusive') {
        taxableAmount = grandTotal;
    }

    console.log(totalShippingCharge);
    const orderTotals = calculateCartTotals(cartItems);
    let finalAmount = orderTotals.finalAmount;
    $('.finalAmount').closest('tr').find('td:first').text(
        orderTotals.pendingAmount > 0 ? '50% deposit due now' : 'Cart total'
    );
    // Update Summary

    // Maanage COD checkbox text value 
    if (totalMrp > 5000) {
        $(".cod_value").html('Not Available');
    } else {
        $(".cod_value").html(`₹${Math.floor(totalMrp)}`);
    }
    // Maanage COD checkbox text value 

    if (totalMrp > 0) {
        $("#totalMrp").html(`₹${Math.floor(totalMrp)}`).show();
    } else {
        $("#totalMrp").html("0"); // Or use .text('') depending on your layout
    }
    if (totalDiscount > 0) {
        $("#totalDiscount").html(`-₹${totalDiscount.toFixed(2)}`).show();
    } else {
        $("#totalDiscount").html("0"); // Or use .text('') depending on your layout
    }
    $('#subTotal').html(`₹${(subTotal).toFixed(2)}`);
    if (couponDiscount > 0) {
        $("#couponDiscount").html(`-₹${couponDiscount.toFixed(2)}`).show();
    } else {
        $("#couponDiscount").html("0"); // Or use .text('') depending on your layout
    }
    $('#grandTotal').html(`₹${(grandTotal).toFixed(2)}`);
    $('#taxableAmount').html(`₹${(taxableAmount).toFixed(2)}`);
    if (taxOption == 'inclusive') {
        $("#taxPrice").html(`+₹${totalTaxPrice.toFixed(2)}`).show();
    } else if (taxOption == 'exclusive') {
        $("#taxPrice").html(`+₹${totalTaxPrice.toFixed(2)}`).show();
    } else {
        $("#taxPrice").html("0"); // Or use .text('') depending on your layout
    }
    if (finalAmount > 0) {
        //$('.finalAmount').html(`₹${finalAmount.toFixed(2)}`);
        if (taxOption == 'inclusive') {
            $('.finalAmount').html(`₹${Math.floor(finalAmount)}`);
        } else if (taxOption == 'exclusive') {
            $('.finalAmount').html(`₹${Math.floor(finalAmount + totalTaxPrice)}`);
        }
        $('.checkoutButton').removeClass('disabled-link');
    } else {
        $('.finalAmount').html(`₹0`);
        $('.checkoutButton').addClass('disabled-link');
    }
    $('#delivery').text(`₹${delivery.toLocaleString()}`);
    // $('#total-items').text(cartItems.length);
    $('#total-items').html(qty);
}


// sandeep
function calculateCartTotals(cartItems) {

    let totalMrp = 0;
    let totalDiscount = 0;
    let totalTaxPrice = 0;
    let taxOption = 'inclusive';
    let fullProductTotal = 0;
    let depositProductTotal = 0;
    let makeToOrderPending = 0;

    cartItems.forEach(function (item) {
        const quantity = Number(item.quantity) || 0;
        const itemPrice = Number(item.price) || 0;
        const sellingPrice = Number(item.sellingPrice) || 0;
        const itemTotal = sellingPrice * quantity;
        const isMakeToOrder = Number(item.instock) === 0;

        totalMrp += itemPrice * quantity;
        totalDiscount += (itemPrice - sellingPrice) * quantity;
        fullProductTotal += itemTotal;
        if (isMakeToOrder) {
            depositProductTotal += itemTotal / 2;
            makeToOrderPending += itemTotal / 2;
        } else {
            depositProductTotal += itemTotal;
        }

        taxOption = item.tax_option;
        const itemTax = Number(item.tax_price) || 0;
        totalTaxPrice += itemTax;
        if (taxOption === 'exclusive') {
            depositProductTotal -= isMakeToOrder ? itemTax / 2 : 0;
            depositProductTotal += itemTax;
            makeToOrderPending += isMakeToOrder ? itemTax / 2 : 0;
        }
    });

    let couponDiscount = parseFloat(localStorage.getItem('coupon_discount')) || 0;
    let shippingCharge = Number(totalShippingCharge) || 0;
    let exclusiveTax = taxOption === 'exclusive' ? totalTaxPrice : 0;
    let fullOrderTotal = fullProductTotal + exclusiveTax + shippingCharge - couponDiscount;
    let hasMakeToOrderItem = cartItems.some(item => Number(item.instock) === 0);
    let dueNowTotal = hasMakeToOrderItem
        ? depositProductTotal + shippingCharge - couponDiscount
        : fullOrderTotal;
    let pendingAmount = hasMakeToOrderItem
        ? Math.max(0, fullOrderTotal - dueNowTotal)
        : 0;
    let subTotal = totalMrp - totalDiscount;
    let grandTotal = subTotal - couponDiscount;
    let finalAmount = dueNowTotal;
 console.log('calculateCartTotals : ', {
        totalMrp,
        totalDiscount,
        subTotal,
        couponDiscount,
        grandTotal,
        totalTaxPrice,
        taxOption,
        finalAmount,
        fullOrderTotal,
        pendingAmount,
        hasMakeToOrderItem
    });
    return {
        totalMrp,
        totalDiscount,
        subTotal,
        couponDiscount,
        grandTotal,
        totalTaxPrice,
        taxOption,
        finalAmount,
        fullOrderTotal,
        pendingAmount,
        hasMakeToOrderItem
    };
}

//


$('.shipping_cancel').on('click', function () {
    $('#main_shipping').slideUp();
});

$('.billing_cancel').on('click', function () {
    $('#main_billing').slideUp();
});
document.addEventListener("DOMContentLoaded", () => {
    const wallet = document.getElementById("flexRadioDefault11");
    const paymentRadios = document.querySelectorAll("input[name='pay_online']");
    if (wallet) {
        const toggleWallet = () => {
            wallet.disabled = document.getElementById("flexRadioDefault13").checked;
            if (wallet.disabled) wallet.checked = false;
        };

        paymentRadios.forEach(r => r.addEventListener("change", toggleWallet));
        toggleWallet();
    }
});
function checkCOD() {
    let limit = +$('#cash_on').val(),
        total = +$('.finalAmount').text().replace(/[^\d.]/g, '');
    $('#flexRadioDefault13').prop('disabled', total >= limit).prop('checked', total >= limit ? false : $('#flexRadioDefault13').prop('checked'));
    $('.limit').css('color', total >= limit ? 'red' : 'green')
        .html(`<i class="fa fa-info-circle" aria-hidden="true"></i>   Cash on Delivery available for orders up to ₹${limit}`);
}

$(document).ready(function () {
    checkCOD();
    new MutationObserver(checkCOD).observe(document.querySelector('.finalAmount'), { childList: true, subtree: true });
});
document.addEventListener('DOMContentLoaded', function () {
    let walletInput = document.getElementById('flexRadioDefault11');
    let walletAmount = parseFloat(document.getElementById('wallet_amount').textContent.replace(/[₹,]/g, '') || 0);

    if (walletAmount <= 0) {
        walletInput.disabled = true;
    }
});

//////////////Shipping Charge//////////////

$(document).ready(function () {
    const shipping_id = $('#selected_shipping_id').val() || 1;
    const subTotal = parseFloat($('#subtotal').val() || 0);
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    shippingCalculation(shipping_id, cartItems, subTotal);
});

$('[name="address"]').on('change', function () {
    if ($('#same_as_billing').prop('checked')) {
        const shipping_id = $(this).val();
        const subTotal = parseFloat($('#subtotal').val());
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        shippingCalculation(shipping_id, cartItems, subTotal);
    }
});
$('[name="shipaddress"]').on('change', function () {
    const shipping_id = $(this).val();
    const subTotal = parseFloat($('#subtotal').val());
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

    shippingCalculation(shipping_id, cartItems, subTotal);
});

function shippingCalculation(shipping_id, cartItems, subTotal) {
    const deliveryShippingCharge = document.getElementById('totalShippingCharge');
    $.ajax({
        url: '/get-shipping-address',
        method: 'POST',
        data: {
            shippingId: shipping_id,
            productData: cartItems,
            totalAmount: subTotal
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                const data = response.data;
                // console.log('shippingPrice', response.shippingPrice);
                totalShippingCharge = response.shippingPrice;
                deliveryShippingCharge.innerHTML = `₹${response.shippingPrice}`;
            } else {
            }
            renderCart();
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
}
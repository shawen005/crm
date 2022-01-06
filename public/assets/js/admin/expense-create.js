/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/admin/sales-order-create.js":
/*!**************************************************!*\
  !*** ./resources/js/admin/sales-order-create.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $(document).on('change', 'input[name="email"]', function (event) {
    $('#quote-email').text($(this).val());
  });

  if ($('#update-costings').length) {
    setTimeout(function () {
      $('.qty').trigger('change');
    }, 800);
  }

  $(document).on('click', '.checkbox-item-all, .checkbox-item', function () {
    if ($(this).hasClass('checkbox-item-all')) {
      if ($(this).is(':checked')) {
        // uncheck all
        $('#products-list input.checkbox-item:not(:disabled)').prop('checked', true);
      } else {
        // check all
        $('#products-list input.checkbox-item:not(:disabled)').prop('checked', false);
      }
    }

    var checked = $('#products-list input.checkbox-item:checked').length;

    if (checked) {
      $('#remove-items-btn').removeClass('disabled').removeAttr('disabled');
    } else {
      $('#remove-items-btn').addClass('disabled').attr('disabled', 'disabled');
    }
  });
  $('#remove-items-btn').on('click', function (event) {
    event.preventDefault();
    Swal.fire({
      title: 'Are you sure you want remove checked items?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, remove it!'
    }).then(function (action) {
      if (action.isConfirmed) {
        $('#products-list input.checkbox-item').each(function () {
          if ($(this).is(':checked')) {
            $(this).parents('tr').remove();
          }
        });
      }
    });
  }); // copy address to shipping

  $('.copy-address-to-shipping').on('click', function (e) {
    e.preventDefault();
    var parent = $(this).parents('.address'); //#shipping-address-details
    //#billing-address-details

    $('[name="delivery_address_data[title]"]').val(parent.find('[name="billing_address_data[title]"]').val());
    $('[name="delivery_address_data[line1]"]').val(parent.find('[name="billing_address_data[line1]"]').val());
    $('[name="delivery_address_data[line2]"]').val(parent.find('[name="billing_address_data[line2]"]').val());
    $('[name="delivery_address_data[line3]"]').val(parent.find('[name="billing_address_data[line3]"]').val());
    $('[name="delivery_address_data[city]"]').val(parent.find('[name="billing_address_data[city]"]').val());
    $('[name="delivery_address_data[postcode]"]').val(parent.find('[name="billing_address_data[postcode]"]').val());
    $('[name="delivery_address_data[county]"]').val(parent.find('[name="billing_address_data[county]"]').val());
    $('[name="delivery_address_data[country]"]').val(parent.find('[name="billing_address_data[country]"]').val());
    $('[name="delivery_address_data[lat]"]').val(parent.find('[name="billing_address_data[lat]"]').val());
    $('[name="delivery_address_data[lng]"]').val(parent.find('[name="billing_address_data[lng]"]').val());
  });
  $('.copy-address-to-billing').on('click', function (e) {
    e.preventDefault();
    var parent = $(this).parents('.address'); //#shipping-address-details
    //#billing-address-details

    $('[name="billing_address_data[title]"]').val(parent.find('[name="delivery_address_data[title]"]').val());
    $('[name="billing_address_data[line1]"]').val(parent.find('[name="delivery_address_data[line1]"]').val());
    $('[name="billing_address_data[line2]"]').val(parent.find('[name="delivery_address_data[line2]"]').val());
    $('[name="billing_address_data[line3]"]').val(parent.find('[name="delivery_address_data[line3]"]').val());
    $('[name="billing_address_data[city]"]').val(parent.find('[name="delivery_address_data[city]"]').val());
    $('[name="billing_address_data[postcode]"]').val(parent.find('[name="delivery_address_data[postcode]"]').val());
    $('[name="billing_address_data[county]"]').val(parent.find('[name="delivery_address_data[county]"]').val());
    $('[name="billing_address_data[country]"]').val(parent.find('[name="delivery_address_data[country]"]').val());
    $('[name="billing_address_data[lat]"]').val(parent.find('[name="delivery_address_data[lat]"]').val());
    $('[name="billing_address_data[lng]"]').val(parent.find('[name="delivery_address_data[lng]"]').val());
  }); // change billing address

  $('#change-billing-address').click(function (e) {
    e.preventDefault();
    $('.new-billing-address').toggle();
  }); // change billing address

  $('#change-delivery-address').click(function (e) {
    e.preventDefault();
    $('.new-delivery-address').toggle();
  }); // Sale order form

  $(document).on('submit', '#create-saleorder-form', function (e) {
    if ($('.attendee').length) {
      var counter = 0;
      $('.attendee').each(function () {
        if (!$(this).val()) {
          counter++;
        }
      });

      if (counter) {
        e.preventDefault();
        Swal.fire({
          icon: 'info',
          title: 'Enter Attendees',
          text: 'Please enter all attendee names.' //footer: '<a href>Why do I have this issue?</a>'

        });
      }
    }
  });
  $(document).on('change', '[name="customer_id"]', function () {
    var selected = $(this).find(':selected');
    var first_name = selected.data('first-name');
    var last_name = selected.data('last-name');
    var email = selected.data('email');
    $('[name="first_name"]').val(first_name);
    $('[name="last_name"]').val(last_name);
    $('[name="email"]').val(email); // Add attendee if training product selected

    if ($('.attendee').length) {
      $('.attendee').first().val(first_name + ' ' + last_name);
    }

    $('input[name="email"]').trigger('change'); // get customer addresses

    $.ajax({
      method: 'get',
      url: '/customers/addresses/' + selected.val(),
      success: function success(response) {
        if (response.success) {
          $('#billing_id, #delivery_id').parent().show();
          var addresses = '<option>Select address</option>';
          $.each(response.data, function (key, value) {
            addresses += '<option value="' + value.id + '" data-organisation="' + value.title + '" data-line-1="' + value.line1 + '" data-line-2="' + value.line2 + '" data-line-3="' + value.line3 + '" data-county="' + value.county + '" data-city="' + value.city + '" data-country="' + value.country + '" data-lat="' + value.lat + '" data-lng="' + value.lng + '" data-postcode="' + value.postcode + '" >';
            addresses += value.line1 + ' ' + value.line2 + ' ' + value.line3 + ' ' + value.city + ' ' + value.postcode;
            addresses += '</option>';
          });
          $('#billing_id').select2('destroy');
          $('#billing_id').html(addresses);
          $('#billing_id').select2();
          $('.new-billing-address').show();
          $('#delivery_id').select2('destroy');
          $('#delivery_id').html(addresses);
          $('#delivery_id').select2();
          $('.new-delivery-address').show();
        } else {
          Swal.fire({
            icon: 'info',
            title: 'No addresses',
            text: 'The selected customer has no addresses, you can enter one manually, however this is not required for the quote.' //footer: '<a href>Why do I have this issue?</a>'

          });
        }
      },
      error: function error() {
        console.log('Failed to fetch addresses');
      }
    });
  }); // Training

  $(document).on('change', '#is-training', function (event) {
    if ($(this).is(':checked')) {
      $('#assessment-product').show();
      $('#free-shipping').prop('checked', 'checked');
    } else {
      $('#assessment-product').hide();
      $('#free-shipping').prop('checked', false);
    }
  }); // Costings

  $(document).on('change focusout', '.item-cost, .vat-type, .qty', function (event) {
    var container = $(this).parents('tr');
    var item_cost = $(container).find('.item-cost');
    var vat_type = $(container).find('.vat-type');
    var net = $(container).find('.net-cost');
    var gross_cost = $(container).find('.gross-cost');
    var vat_cost = $(container).find('.vat-cost');
    var qty = $(container).find('.qty').val();

    if (item_cost.val() == '') {
      item_cost.val(0);
    }

    var vat_value = vat_type.find(':selected').data('value');
    var net_cost = parseFloat(item_cost.val()) * qty;
    net.val(net_cost);
    var vat = net_cost * vat_value / 100;
    vat_cost.val(vat.toFixed(2));
    var gross = net_cost + vat;
    gross_cost.val(gross.toFixed(2));
    calculate_totals();
  });
  /*
   * Shipping cost
   */

  $('#add-shipping-cost,#add-shipping-vat-id').on('change', function () {
    calculate_totals();
  }); //

  setTimeout(function () {
    if (pre_fetch_product) {
      $('#products-list .select-product').val(pre_fetch_product);
      $('#products-list .select-product').trigger('change');
    }
  }, 800); // Populate form data

  $(document).on('change', '.select-product', function (event) {
    event.stopImmediatePropagation();
    var product_row = $(this).find(':selected');
    var selected = product_row.val();
    var container = $(this).parents('tr');
    var item_cost = $(container).find('.item-cost');
    var net_cost = $(container).find('.net-cost');
    var vat_type = $(container).find('.vat-type');
    var gross_cost = $(container).find('.gross-cost');
    var qty = $(container).find('.qty'); // Training box

    var is_training = $(product_row).data('is-training');
    var row_id = container.data('id');
    var training_container = $('.show-trainings-' + row_id);
    var training_row = training_container.find('.product-trainings');
    $(training_container).hide();

    if (is_training) {
      $(qty).val(1);
      $(qty).attr('readonly', 'readonly');
    } else {
      $(qty).removeAttr('readonly');
    } // fetch product


    $.ajax({
      method: 'GET',
      url: '/get-product',
      data: 'id=' + selected,
      success: function success(response) {
        if (response.success) {
          item_cost.val(0);
          net_cost.val(0);
          gross_cost.val(0);

          if (qty.val() == '') {
            qty.val(1);
          }

          qty.trigger('change');

          if (response.data.net_cost) {
            item_cost.val(response.data.net_cost);
          }

          if (response.data.sale_cost) {
            item_cost.val(response.data.sale_cost);
          }

          if (response.data.vat_type_id) {
            vat_type.val(response.data.vat_type_id).trigger('change');
          }

          calculate_totals(); // Show training results
        } 
      },
    });
  });
  /*
   *  Add a new product to the list
   */

  $('#add-product').on('click', function (event) {
    event.preventDefault();
    var clone = $('#product-prototype tbody').html();
    var id = new Date().getTime();
    clone = clone.replace(/{REPLACE_ID}/g, id);
    $('#products-list tbody').append(clone);
    $('#products-list tbody').find('.select-product:not(.select2)').select2();
    $('#products-list tbody').find('.vat-type:not(.select2)').select2();
    $('#products-list tbody').find('.checkbox-item:last').removeAttr('disabled');
    calculate_totals();
  });
});

function calculate_totals() {
  var subtotal = 0;
  var vat = 0;
  var gross = 0;
  var shipping = 0;
  var shipping_vat = 0;
  $('#products-list tbody tr.tb-tnx-item').each(function () {
    subtotal += parseFloat($(this).find('.net-cost').val());
    vat += parseFloat($(this).find('.vat-cost').val());
  });
  shipping = parseFloat($('[name="shipping_cost"]').val());
  shipping_vat = $('#add-shipping-vat-id').find(':selected').data('value');
  shipping_vat = shipping_vat / 100 * shipping;
 
  gross = parseFloat(subtotal) + parseFloat(vat);
  $('#show-total-net span').text(subtotal.toFixed(2));
  $('#show-total-vat span').text(vat.toFixed(2));
  $('#show-total-gross span').text(gross.toFixed(2));
}

/***/ }),

/***/ 6:
/*!********************************************************!*\
  !*** multi ./resources/js/admin/sales-order-create.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/richardholmes/Sites/localhost/jenflow-laravel/resources/js/admin/sales-order-create.js */"./resources/js/admin/sales-order-create.js");


/***/ })

/******/ });
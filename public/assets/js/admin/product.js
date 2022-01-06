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
/******/ 	return __webpack_require__(__webpack_require__.s = 14);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/admin/product.js":
/*!***************************************!*\
  !*** ./resources/js/admin/product.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  // Keywords
  $('[name=keywords]').tagify();
  $('#modalAttribute').on('shown.bs.modal', function (e) {
    var button = e.relatedTarget;
    var product_id = $(button).data('product-id');
    Livewire.emit('set:product-id', product_id);
  });
  $('[name="value_id"]').on('change', function (e) {
    var selected = $(this).find(':selected');
    var product = selected.val();
    $('#show-attributes .form-group').html('');
    $('#show-attributes .form-group').html(loader);
    $('#show-attributes').show();

    if (product) {
      Livewire.emit('set:selected-product', product);
    }
  });
  window.addEventListener('product-updated', function (event) {
    if (event.detail.attributes) {
      $('#show-attributes .form-group').html('');
      $('#show-attributes .form-group').append('<label class="form-label">Exclude selected product attributes : </label><br>');
      $(event.detail.attributes).each(function (key, value) {
        var inputs = '<div class="custom-control custom-checkbox mr-3">';
        inputs += '<input type="checkbox" id="exclude-' + key + '" name="exclude_value_attributes[]" class="custom-control-input" value="' + value.pivot.value_id + '">';
        inputs += '<label class="custom-control-label" for="exclude-' + key + '">' + (value.pivot.attribute_title ? value.pivot.attribute_title : event.detail.title) + '</label></div>';
        $('#show-attributes .form-group').append(inputs);
      });
    } else {
      $('#show-attributes').hide();
    }
  });
  window.addEventListener('product-id-added', function (event) {
    $('#attribute-product-id').val(event.detail.productId);
  }); // slug

  $(document).on('keyup', '[name="title"]', function (event) {
    var title = $(this).val();
    setTimeout(function () {
      var slug = title.toLowerCase().replace(/ /g, '-').replace(/[-]+/g, '-').replace(/[^\w-]+/g, '');
      $('[name="slug"]').val(slug);
    }, 400);
  }); // Training

  $(document).on('change', '#is-training', function (event) {
    if ($(this).is(':checked')) {
      $('#assessment-product').show();
      $('#free-shipping').prop('checked', 'checked');
    } else {
      $('#assessment-product').hide();
      $('#free-shipping').prop('checked', false);
    }
  }); // Pallet or Box

  $(document).on('change', '#is-packaging', function (event) {
    if ($(this).is(':checked')) {
      $('#packaging-options').show();
      $('#product-options').hide();
    } else {
      $('#packaging-options').hide();
      $('#product-options').show();
    }
  });
  $(document).on('change', '#is-shipping-box', function (event) {
    if ($(this).is(':checked')) {
      $('#is-shipping-pallet').prop('checked', false);
    }
  });
  $(document).on('change', '#is-shipping-pallet', function (event) {
    if ($(this).is(':checked')) {
      $('#is-shipping-box').prop('checked', false);
    }
  }); // summernote editor

  if ($('.summernote-minimal').length) {
    $('.summernote-minimal').summernote({
      placeholder: 'Description',
      tabsize: 2,
      height: 120,
      toolbar: [['style', ['style']], ['font', ['bold', 'underline', 'clear']], ['para', ['ul', 'ol', 'paragraph']], ['table', ['table']], ['view', ['fullscreen']]]
    });
  } // Sale costings


  if ($('#sale-net-cost').length) {
    setTimeout(function () {
      $('#sale-net-cost').trigger('change');
    }, 400);
    $(document).on('change keyup', '#sale-net-cost, #vat-type-id', function (event) {
      var net_cost = parseFloat($('#sale-net-cost').val());
      var vat_value = $('#vat-type-id').find(':selected').data('value'); // Update costings

      if ($('#sale-net-cost').val() != '') {
        if ($('#vat-type-id').length && $('#sale-vat-cost').length && $('#sale-gross-cost').length) {
          var vat = net_cost * vat_value;
          var vat_cost = vat / 100;
          var gross_cost = net_cost + vat_cost;
          vat_cost = vat_cost.toFixed(2);
          gross_cost = gross_cost.toFixed(2);
          $('#sale-vat-cost').val(vat_cost);
          $('#sale-gross-cost').val(gross_cost); // calculate saving

          var cost_net = parseFloat($('#net-cost').val());
          var sale_net = parseFloat($('#sale-net-cost').val());
          var saving = sale_net / cost_net * 100;
          saving = 100 - saving;
          $('#sale-saving mark').text(saving.toFixed(2) + '%').removeClass('text-danger');
          $('#sale-saving').show();

          if (saving < 0) {
            $('#sale-saving mark').text(saving.toFixed(2) + '% this is not a saving').addClass('text-danger');
          }
        }
      } else {
        $('#sale-saving').hide();
        $('#sale-vat-cost').val('');
        $('#sale-gross-cost').val('');
      }
    });
  } // Deposit allowed


  $(document).on('change', '#deposit-allowed', function () {
    if ($(this).is(':checked')) {
      $('#deposit-costings').show();
    } else {
      $('#deposit-costings').hide();
    }
  }); // Update costings

  if ($('#deposit-net-cost').length) {
    $(document).on('change', '#deposit-net-cost, #vat-type-id', function (event) {
      var net_cost = parseFloat($('#deposit-net-cost').val());
      var vat_value = $('#vat-type-id').find(':selected').data('value'); // Update costings

      if ($('#deposit-net-cost').val() != '') {
        if ($('#vat-type-id').length && $('#deposit-vat-cost').length && $('#deposit-gross-cost').length) {
          var vat = net_cost * vat_value;
          var vat_cost = vat / 100;
          var gross_cost = net_cost + vat_cost;
          vat_cost = vat_cost.toFixed(2);
          gross_cost = gross_cost.toFixed(2);
          $('#deposit-vat-cost').val(vat_cost);
          $('#deposit-gross-cost').val(gross_cost);
        }
      } else {
        $('#sale-saving').hide();
        $('#sale-vat-cost').val('');
        $('#sale-gross-cost').val('');
      }
    });
  } // Update the product

  /*$(document).on('submit','#product-detail-form', function(event) {
      event.preventDefault();
      var url = $(this).attr('action');
      var button = $(this).find('.submit-btn');
       button.attr('disabled','disabled').text('...Please wait');
       $.ajax({
          method : 'POST',
          url : url,
          data : $(this).serialize(),
          async : false,
          success : function(response, textStatus, XHR) {
              if(response.success)
              {
                   Swal.fire({
                      icon: 'success',
                      title: 'Success',
                      text: response.message ? response.message : 'Product updated.',
                      //footer: '<a href>Why do I have this issue?</a>'
                  });
                  button.removeAttr('disabled').text('Save');
               }
              else
              {
                  Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: response.message ? response.message : 'Something went wrong! please re-fresh your page and try again.',
                      //footer: '<a href>Why do I have this issue?</a>'
                  });
                  button.removeAttr('disabled').text('Save');
              }
          },
          error : function(XHR, textStatus, error) {
              if(XHR.status === 422) {
                  var response = XHR.responseJSON;
                  var errors = response.errors;
                  var message = 'You have errors in your form.';
                  $.each( errors, function( key, value ) {
                      $('#modalCreate [name="'+ key +'"]').parent().append('<span id="'+ key +'-error" class="invalid">This field is required.</span>');
                      message += value;
                  });
              }
              Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: message ? message : 'Your session may have expired, please re-fresh your page and try again.',
                  //footer: '<a href>Why do I have this issue?</a>'
              });
               button.removeAttr('disabled').text('Save');
          }
      });
  });*/
  // Populate form data


  $(document).on('change', '#add-product-id', function (event) {
    $('#fetch-product-status').fadeOut(400);
    var selected = $(this).find(':selected').val(); // fetch product

    $.ajax({
      method: 'GET',
      url: '/get-product',
      data: 'id=' + selected,
      success: function success(response) {
        if (response.success) {
          if (response.data.weight) {
            $('#add-qty').val(1);
            $('#add-weight').val(response.data.weight);
          }

          if (response.data.unit_of_measure_id && !response.data.builds_by_unit) {
            $('#add-unit-of-measure-id option[value="' + response.data.unit_of_measure_id + '"]').prop('selected', true).change();
            $('#build-weight').show();
          } else {
            $('#add-unit-of-measure-id option[value="unit"]').prop('selected', true).change();
            $('#build-weight').hide();
          }
        } else {
          $('#fetch-product-status').html('Error fetching the selected product to auto populate the form but the request failed, you can manually fill the form in.').show();
        }
      },
      error: function error() {
        $('#fetch-product-status').html('Error fetching the selected product to auto populate the form but the request failed, your session may have expired, please re-fresh and try again.').show();
      }
    });
  }); // Add build product

  $(document).on('submit', '#create-form', function (event) {
    event.preventDefault();
    var url = $(this).attr('action');
    var method = $(this).attr('method');
    var button = $(this).find('.submit-btn');
    button.attr('disabled', 'disabled').text('...Please wait');
    $.ajax({
      method: method,
      url: url,
      data: $(this).serialize(),
      async: false,
      success: function success(response, textStatus, XHR) {
        if (response.success) {
          // add to table
          if ($('#build-products').length) {
            var clone = $('#build-product-prototype tbody').html();
            clone = clone.replace(/{ID}/g, response.data.id);
            clone = clone.replace(/{PRODUCT_TITLE}/g, response.data.product_title);
            clone = clone.replace(/{QTY}/g, response.data.qty);
            clone = clone.replace(/{PRODUCT_ID}/g, response.data.product_id);
            $('#build-products tbody').prepend(clone);
            $('#build-products tbody tr').eq(0).attr('data-id', response.data.id);
            $('#create-form').trigger('reset');
            $('#modalCreate').modal('hide');
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: response.message ? response.message : 'Build product added.' //footer: '<a href>Why do I have this issue?</a>'

            });
          } else {
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: response.message ? response.message : 'Build product added.' //footer: '<a href>Why do I have this issue?</a>'

            });
            setTimeout(function () {
              location.reload();
            }, 900);
          }

          button.removeAttr('disabled').text('Save');
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: response.message ? response.message : 'Something went wrong! please re-fresh your page and try again.' //footer: '<a href>Why do I have this issue?</a>'

          });
          button.removeAttr('disabled').text('Save');
        }
      },
      error: function error(XHR, textStatus, _error) {
        if (XHR.status === 422) {
          var response = XHR.responseJSON;
          var errors = response.errors;
          var message = 'You have errors in your form.';
          $.each(errors, function (key, value) {
            $('#modalCreate [name="' + key + '"]').parent().append('<span id="' + key + '-error" class="invalid">This field is required.</span>');
            message += value;
          });
        }

        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: message ? message : 'Your session may have expired, please re-fresh your page and try again.' //footer: '<a href>Why do I have this issue?</a>'

        });
        button.removeAttr('disabled').text('Save');
      }
    });
  });
});

/***/ }),

/***/ 14:
/*!*********************************************!*\
  !*** multi ./resources/js/admin/product.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/richardholmes/Sites/localhost/jenflow-laravel/resources/js/admin/product.js */"./resources/js/admin/product.js");


/***/ })

/******/ });
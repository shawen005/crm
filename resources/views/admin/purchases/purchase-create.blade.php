<?php

    if($duplicate_purchase) {
        $detail = $duplicate_purchase;
    }

?>
<!DOCTYPE html>
<html lang="eng" class="js">
@push('styles')

@endpush
{{ view('admin.templates.header') }}

<body class="nk-body npc-default has-apps-sidebar has-sidebar">

<div class="nk-app-root">
{{ view('admin.templates.sidebar') }}
<!-- main @s -->
    <div class="nk-main ">
        <!-- wrap @s -->
        <div class="nk-wrap ">
            <!-- main header @s -->
        {{ view('admin.templates.topmenu') }}
        <!-- main header @e -->
        {{ view('admin.templates.sidemenus.sidemenu-default') }}

        <!-- content @s -->
            <div class="nk-content ">

                {{ view('admin.templates.alert') }}

                <div class="container-fluid">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">

                            <div class="nk-block nk-block-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h4 class="title nk-block-title">Create new purchase order</h4>
                                            <div class="nk-block-des">
                                                <p>
                                                    Fill in as much detail as you can, more options will be available once you have added the sales order
                                                </p>
                                            </div>
                                        </div>

                                        <div class="nk-block-head-content">
                                            <div class="toggle-wrap nk-block-tools-toggle">
                                                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                                <div class="toggle-expand-content" data-content="pageMenu">
                                                    <ul class="nk-block-tools g-3">
                                                        <li><a href="{{ url('salesorders') }}" class="btn btn-danger"><span>Cancel</span></a></li>
                                                        {{--<li class="nk-block-tools-opt">
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-plus"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right" style="">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#"><span>Add User</span></a></li>
                                                                        <li><a href="#"><span>Add Team</span></a></li>
                                                                        <li><a href="#"><span>Import User</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>--}}
                                                    </ul>
                                                </div>
                                            </div><!-- .toggle-wrap -->
                                        </div>
                                    </div>

                                </div>
                                <form method="post" action="{{ url('purchases') }}" id="create-purchase-form" class="form-validate">
                                    <div class="row g-gs">

                                       @csrf
                                        <div class="col-lg-6">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-head">
                                                        <?php if(isset($detail->id)) : ?>
                                                            <h5 class="card-title">You are duplicating : <a href="{{ url('purchases/'.$detail->id) }}" target="_blank">{{ $detail->id }}</a></h5>
                                                        <?php else : ?>
                                                            <h5 class="card-title">Supplier details</h5>
                                                        <?php endif; ?>
                                                    </div>

                                                        <div class="form-group">
                                                            <label class="form-label" for="notes">Supplier *</label>
                                                            <div class="form-control-wrap">
                                                                <select class="form-select" name="supplier_id" data-search="on" required>
                                                                    <?php if($suppliers && $suppliers->count()) : ?>
                                                                    <option>Select supplier</option>
                                                                    <?php foreach($suppliers as $supplier) : ?>
                                                                    <option value="{{ $supplier->id }}" {{ is_selected($supplier->id, isset($detail->supplier_id) ? $detail->supplier_id : '') }}>{{ $supplier->title }} - {{ $supplier->email }}</option>
                                                                    <?php endforeach; ?>
                                                                    <?php endif; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Customer detail -->
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Supplier invoice number</label>
                                                                    <div class="form-control-wrap">
                                                                        <input class="form-control" type="text" name="supplier_invoice_number" value="{{ old('supplier_invoice_number', isset($detail->supplier_invoice_number) ? $detail->supplier_invoice_number : '') }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="form-label">Expected delivery date *</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="form-icon form-icon-left">
                                                                            <em class="icon ni ni-calendar"></em>
                                                                        </div>
                                                                        <input type="text" class="form-control date-picker" name="expected_delivery_date" id="expected-delivery-date" data-date-format="yyyy-mm-dd" value="{{ old('expected_delivery_date', isset($detail->expected_delivery_date) ? $detail->expected_delivery_date : '') }}" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="form-label">Order notes</label>
                                                            <textarea name="notes" class="form-control">{{ old('notes', isset($detail->notes) ? $detail->notes : '') }}</textarea>
                                                        </div>

                                                        <?php
                                                            $billing_address = [];
                                                            $shipping_address = [];
                                                            if(isset($franchise->addresses) && $franchise->addresses->count())
                                                            {
                                                                foreach ($franchise->addresses as $address)
                                                                {
                                                                    if($address->default_billing_address) {
                                                                        $billing_address = $address->toArray();
                                                                    }

                                                                    if($address->default_shipping_address) {
                                                                        $billing_address = $address->toArray();
                                                                    }

                                                                }

                                                                if(empty($billing_address)) {
                                                                    $billing_address = $franchise->addresses[0]->toArray();
                                                                }
                                                                if(empty($shipping_address)) {
                                                                    $shipping_address = $franchise->addresses[0]->toArray();
                                                                }
                                                            }
                                                        ?>
                                                        <h5 class="card-title mt-5 mb-4">Your Billing and Shipping Address</h5>
                                                        <div class="row mb-4">
                                                            <div class="col-md-6 address">

                                                                <div class="mb-3">
                                                                    <h6>Billing address <a href="#" class="copy-address-to-shipping" data-toggle="tooltip" data-placement="top" title="Copy to shipping"><em class="icon ni ni-swap"></em></a>
                                                                        <a href="#" id="change-billing-address" class="btn btn-sm btn-outline-primary float-right">Change billing address</a>
                                                                    </h6>
                                                                </div>

                                                                <div class="address-container">

                                                                    <div class="card card-bordered new-billing-address mt-4 mb-3 bg-light-grey" style="display: none">
                                                                        <div class="card-inner">

                                                                            <div class="form-group" style="{{ (isset($franchise->addresses) && $franchise->addresses->count()) ? 'display:block;' : 'display:none;' }}">
                                                                                <label class="form-label">Select a saved billing address</label>
                                                                                <select class="form-select">
                                                                                    <option>Choose address</option>
                                                                                    <?php if(isset($franchise->addresses)) : ?>
                                                                                        <?php foreach($franchise->addresses as $address) : ?>
                                                                                        <option value="{{ $address->id }}" data-organisation="{{ $address->title }}" data-line-1="{{ $address->line1 }}" data-line-2="{{ $address->line2 }}" data-line-3="{{ $address->line3 }}" data-county="{{ $address->county }}" data-city="{{ $address->city }}" data-country="{{ $address->country }}" data-lat="{{ $address->lat }}" data-lng="{{ $address->lng }}" data-postcode="{{ $address->postcode }}">
                                                                                            {{ $address->line1.' '.$address->line2.' '.$address->line3.' '.$address->city.' '.$address->postcode }}
                                                                                        </option>
                                                                                        <?php endforeach; ?>
                                                                                    <?php endif;  ?>
                                                                                </select>

                                                                                <h5 class="mt-3">OR</h5>
                                                                            </div>


                                                                            <div class="form-group">
                                                                                <label class="form-label" for="notes">Enter postcode *</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input id="find-postcode" class="find-postcode form-control" value="" placeholder="Enter postcode">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <button id="postcode-btn" type="button" class="submit-btn postcode-btn btn btn-outline-primary">Find addresses</button>
                                                                            </div>

                                                                            <div id="show-addresses" class="form-group show-addresses" style="display: none;">
                                                                                <label class="form-label" for="notes">Addresses found</label>
                                                                                <div class="form-control-wrap">
                                                                                    <select class="form-select">

                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="form-label">Your company / Address name</label>
                                                                        <div class="form-control-wrap">
                                                                            <input class="form-control title" type="text" name="billing_address_data[title]" value="{{ old('billing_address_data.title', isset($billing_address['title']) ? $billing_address['title'] : '') }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-3">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Line 1 *</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input class="form-control line1" type="text" name="billing_address_data[line1]" value="{{ old('billing_address_data.line1',isset($billing_address['line1']) ? $billing_address['line1'] : '') }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Line 2</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input class="form-control line2" type="text" name="billing_address_data[line2]" value="{{ old('billing_address_data.line2',isset($billing_address['line2']) ? $billing_address['line2'] : '') }}" >
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-3">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Line 3</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input class="form-control line3" type="text" name="billing_address_data[line3]" value="{{ old('billing_address_data.line3', isset($billing_address['line3']) ? $billing_address['line3'] : '') }}" >
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label">City *</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input class="form-control city" type="text" name="billing_address_data[city]" value="{{ old('billing_address_data.city', isset($billing_address['city']) ? $billing_address['city'] : '') }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-3">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Postcode *</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input class="form-control postcode" type="text" name="billing_address_data[postcode]" value="{{ old('billing_address_data.postcode', isset($billing_address['postcode']) ? $billing_address['postcode'] : '') }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label">County</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input class="form-control county" type="text" name="billing_address_data[county]" value="{{ old('billing_address_data.county', isset($billing_address['county']) ? $billing_address['county'] : '') }}" >
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <?php
                                                                        if( !$ip_country = session('ip_location.country_name') ) {
                                                                            $ip_country = '';
                                                                        }
                                                                        ?>
                                                                        <label class="form-label" for="notes">Country *</label>
                                                                        <div class="form-control-wrap">
                                                                            <select class="form-select country" name="billing_address_data[country]" data-search="on" required>
                                                                                <?php if($countries = countries()) : ?>
                                                                                <?php foreach($countries as $country) : ?>
                                                                                <option value="{{ $country->title }}" data-country-code="{{$country->code}}" {{ is_selected($country->title, $ip_country) }}>{{$country->title}}</option>
                                                                                <?php endforeach; ?>
                                                                                <?php endif; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <input class="lat" type="hidden" name="billing_address_data[lat]" value="{{ old('billing_address_data.lat', isset($billing_address['lat']) ? $billing_address['lat'] : '') }}">
                                                                    <input class="lng" type="hidden" name="billing_address_data[lng]" value="{{ old('billing_address_data.lng', isset($billing_address['lng']) ? $billing_address['lng'] :  '') }}">
                                                                </div>

                                                            </div>

                                                            <div class="col-md-6">

                                                                <div class="mb-3">
                                                                    <h6>Delivery address <a href="#" class="copy-address-to-billing" data-toggle="tooltip" data-placement="top" title="Copy to billing"><em class="icon ni ni-swap"></em></a>
                                                                        <a href="#" id="change-delivery-address" class="btn btn-sm btn-outline-primary float-right">Change shipping address</a>
                                                                    </h6>
                                                                </div>

                                                                <div class="address-container">

                                                                    <div class="card card-bordered new-delivery-address mt-4 mb-3 bg-light-grey" style="display: none">
                                                                        <div class="card-inner">

                                                                            <div class="form-group" style="{{ (isset($franchise->addresses) && $franchise->addresses->count()) ? 'display:block;' : 'display:none;' }}">
                                                                                <label class="form-label">Select a saved delivery address</label>
                                                                                <select class="form-select">
                                                                                    <option>Choose address</option>
                                                                                    <?php if(isset($franchise->addresses)) : ?>
                                                                                        <?php foreach($franchise->addresses as $address) : ?>
                                                                                            <option value="{{ $address->id }}" data-organisation="{{ $address->title }}" data-line-1="{{ $address->line1 }}" data-line-2="{{ $address->line2 }}" data-line-3="{{ $address->line3 }}" data-county="{{ $address->county }}" data-city="{{ $address->city }}" data-country="{{ $address->country }}" data-lat="{{ $address->lat }}" data-lng="{{ $address->lng }}" data-postcode="{{ $address->postcode }}">
                                                                                                {{ $address->line1.' '.$address->line2.' '.$address->line3.' '.$address->city.' '.$address->postcode }}
                                                                                            </option>
                                                                                        <?php endforeach; ?>
                                                                                    <?php endif;  ?>
                                                                                </select>

                                                                                <h5 class="mt-3">OR</h5>
                                                                            </div>
--}}

                                                                            <div class="form-group">
                                                                                <label class="form-label" for="notes">Enter postcode *</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input id="find-postcode" class="find-postcode form-control" value="" placeholder="Enter postcode">
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <button id="postcode-btn" type="button" class="submit-btn postcode-btn btn btn-outline-primary">Find addresses</button>
                                                                            </div>

                                                                            <div id="show-addresses" class="form-group show-addresses" style="display: none;">
                                                                                <label class="form-label" for="notes">Addresses found</label>
                                                                                <div class="form-control-wrap">
                                                                                    <select class="form-select">

                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label class="form-label">Your company / Address name</label>
                                                                        <div class="form-control-wrap">
                                                                            <input class="form-control title" type="text" name="delivery_address_data[title]" value="{{ old('delivery_address_data.title', isset($shipping_address['title']) ? $shipping_address['title'] : '') }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-3">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Line 1 *</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input class="form-control line1" type="text" name="delivery_address_data[line1]" value="{{ old('delivery_address_data.line1',isset($shipping_address['line1']) ? $shipping_address['line1'] : '') }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Line 2</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input class="form-control line2" type="text" name="delivery_address_data[line2]" value="{{ old('delivery_address_data.line2',isset($shipping_address['line2']) ? $shipping_address['line2'] : '') }}" >
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-3">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Line 3</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input class="form-control line3" type="text" name="delivery_address_data[line3]" value="{{ old('delivery_address_data.line3',isset($shipping_address['line3']) ? $shipping_address['line3'] : '') }}" >
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label">City *</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input class="form-control city" type="text" name="delivery_address_data[city]" value="{{ old('delivery_address_data.city',isset($shipping_address['city']) ? $shipping_address['city'] : '') }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mb-3">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label">Postcode *</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input class="form-control postcode" type="text" name="delivery_address_data[postcode]" value="{{ old('delivery_address_data.postcode',isset($shipping_address['postcode']) ? $shipping_address['postcode'] : '') }}" >
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="form-label">County</label>
                                                                                <div class="form-control-wrap">
                                                                                    <input class="form-control county" type="text" name="delivery_address_data[county]" value="{{ old('delivery_address_data.county',isset($shipping_address['county']) ? $shipping_address['county'] : '') }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <?php
                                                                        if( !$ip_country = session('ip_location.country_name') ) {
                                                                            $ip_country = '';
                                                                        }
                                                                        ?>
                                                                        <label class="form-label" for="notes">Country *</label>
                                                                        <div class="form-control-wrap">
                                                                            <select class="form-select country" name="delivery_address_data[country]" data-search="on" required>
                                                                                <?php if($countries = countries()) : ?>
                                                                                <?php foreach($countries as $country) : ?>
                                                                                <option value="{{ $country->title }}" data-country-code="{{$country->code}}" {{ is_selected($country->title, $ip_country) }}>{{$country->title}}</option>
                                                                                <?php endforeach; ?>
                                                                                <?php endif; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <input class="lat" type="hidden" name="delivery_address_data[lat]" value="{{ old('delivery_address_data.lat',isset($shipping_address['lat']) ? $shipping_address['lat'] : '') }}">
                                                                    <input class="lng" type="hidden" name="delivery_address_data[lng]" value="{{ old('delivery_address_data.lng',isset($shipping_address['lng']) ? $shipping_address['lng'] :  '') }}">
                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="form-group">
                                                            <?php if($order_statuses = purchase_order_statuses()) : ?>
                                                            <label class="form-label" for="notes">Status *</label>
                                                            <div class="form-control-wrap">
                                                                <select class="form-select" name="purchase_order_status_id" id="purchase-order-status-id" data-search="on">
                                                                    <?php foreach($order_statuses as $status) : if(!in_array($status->id,[1,2])) { continue; } ?>
                                                                    <option value="{{ $status->id }}">{{ $status->title }}</option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <?php else : ?>
                                                            <div class="alert alert-warning">Please <a href="#">create a new purchase order status</a></div>
                                                            <?php endif; ?>
                                                        </div>


                                                    </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-head">
                                                        <h5 class="card-title">Products</h5>
                                                    </div>

                                                    <div class="card card-bordered card-preview">
                                                        <table id="products-list" class="table table-tranx">
                                                            <thead>
                                                                <tr class="tb-tnx-head">
                                                                    <th width="5%">
                                                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                            <input type="checkbox" class="custom-control-input checkbox-item-all" id="items-all">
                                                                            <label class="custom-control-label" for="items-all"></label>
                                                                        </div>
                                                                    </th>
                                                                    <th width="40%">Product</th>
                                                                    <th width="10%">Qty</th>
                                                                    <th width="15%">Vat</th>
                                                                    <th width="15%">Item Cost</th>
                                                                    <th width="15%" class="text-right">Gross</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            <?php if(!empty(old('items'))) : ?>
                                                                <div id="update-costings"></div>
                                                                <!-- repopulate list if error -->
                                                               <?php foreach(old('items') as $key => $item) : ?>
                                                                    {{ view('admin.purchases.template.product-row', ['id' => $key,'data' => $item]) }}
                                                               <?php endforeach; ?>

                                                            <?php else : ?>

                                                                {{ view('admin.purchases.template.product-row', ['id' => 0]) }}


                                                            <?php endif; ?>


                                                            </tbody>

                                                        </table>

                                                        <div class="pl-3 pr-3 pb-3">
                                                            <a id="add-product" href="#" class="btn btn-white btn-primary"><span> Add row </span></a>
                                                        </div>

                                                    </div><!-- .card-preview -->

                                                    <div class="row mt-4">
                                                        <div class="col-md-6">
                                                            <a href="#" id="remove-items-btn" class="btn btn-danger disabled" disabled><span> Remove items </span></a>
                                                        </div>

                                                        <div class="col-md-6">

                                                            <table class="table">
                                                                <thead class="thead-dark">
                                                                <tr>
                                                                    <th scope="col" colspan="2">Order Totals</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="card-bordered">
                                                                <tr>
                                                                    <th scope="row">Net cost</th>
                                                                    <td id="show-total-net">&pound; <span>{{ number_format(0.00,2,'.',',') }}</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Net shipping</th>
                                                                    <td><input id="add-shipping-cost" type="text" value="0" min="0" class="form-control" name="shipping_cost"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Shipping vat</th>
                                                                    <td>
                                                                        <select id="add-shipping-vat-id" name="shipping_vat_type_id" class="form-select form-control" data-search="on" required>
                                                                            <?php if($vat_types = vat_types()) : ?>
                                                                            <?php foreach($vat_types as $vats) : ?>
                                                                            <option value="{{ $vats->id }}" data-value="{{ $vats->value }}">{{ $vats->title }}</option>
                                                                            <?php endforeach; ?>
                                                                            <?php endif; ?>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Vat</th>
                                                                    <td id="show-total-vat">&pound; <span>{{ number_format( (0.00),2,'.',',') }}</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Gross</th>
                                                                    <td id="show-total-gross" class="font-weight-bolder text-primary">&pound; <span>{{ number_format(0,2,'.',',') }}</span> </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="submit-btn btn btn-lg btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->
        </div>
        <!-- wrap @e -->
    </div>
    <!-- main @e -->
</div>

<table style="display: none;" id="product-prototype">
    <tbody>
        {{ view('admin.purchases.template.product-row', ['prototype' => true]) }}
    </tbody>
</table>

@push('scripts')
    <script src="{{ asset('assets/js/admin/purchase-order-create.js') }}"></script>
@endpush
{{ view('admin.templates.footer') }}
</body>

<script type="text/javascript">
    var load_supplier_items = {{ old('supplier_id') ?: 0  }};
</script>
<!--<script type="text/javascript"></script>-->
</html>

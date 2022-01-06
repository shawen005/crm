<?php

    $customer_name = $detail->getFullNameAttribute();
    $billing_address = $detail->billing_address_data;
    $delivery_address = $detail->delivery_address_data;

    $additional_shipping = 0;

    $ignore_address_keys = ['lat','lng'];
?>

<div class="invoice-wrapper">
    <div class="logo-wrapper">
        <div class="logo">
            <img src="{{ asset('assets/files/img/Jenflow-Logo.png') }}" alt="Jenflow Systems Ltd">
        </div>
        <div class="call-to-action pt-3 text-uppercase">
            <b>QUOTE</b>
        </div>
    </div>


    <div class="payment-info">
        <div class="row">
            <div class="col-sm-6">
                <?php
                $franchise = current_user_franchise();
                $franchise_address = isset($franchise->addresses) ? $franchise->addresses()->first() : null;
                ?>
                <span>{{ $franchise->title }}</span><br>
                <?php if($franchise_address) : ?>
                {{ $franchise_address['line1'] }}<br>
                {{ $franchise_address['line2'] }}<br>
                {{ $franchise_address['line3'] }}<br>
                {{ $franchise_address['city'] }},{{ $franchise_address['county'] }}<br>
                {{ $franchise_address['postcode'] }},{{ $franchise_address['country'] }}<br>
                <?php endif; ?>
                Registered in Scotland<br>
                VAT: {{ $franchise->vat_number ?: 'NA' }}<br>
                01922 907711 | 07539 081756 | 07377 335978<br>
            </div>
            <div class="col-sm-6 text-right">
                <span>Quote Date</span>
                <strong>{{ format_date_time($detail->created_at) }}</strong>
                <span>Valid Until.</span>
                <strong>{{ format_date($detail->quote_valid_until) }}</strong>
                <span>Order number.</span>
                <strong>{{ $detail->id }}</strong>
            </div>
        </div>
    </div>

    <div class="payment-details">
        <div class="row">
            <div class="col-sm-6">
                <span>Billing</span>
                <b>
                    {{ $customer_name }}
                </b>
                <p>
                    <?php foreach ($billing_address as $key => $line) : if(in_array($key,$ignore_address_keys)) { continue; } if($line == '') { continue; } ?>
                    {{ $line }}<br>
                    <?php endforeach; ?>
                </p>
            </div>
            <div class="col-sm-6">
                <span>Shipping</span>
                <b>
                    {{ $customer_name }}
                </b>
                <p>
                    <?php foreach ($delivery_address as $key => $line) : if(in_array($key,$ignore_address_keys)) { continue; } if($line == '') { continue; } ?>
                    {{ $line }}<br>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>
    </div>

    <div class="line-items">
        <div class="headers clearfix">
            <div class="row mr-0 ml-0">
                <div class="col-sm-4">Description</div>
                <div class="col-sm-2">Qty</div>
                <div class="col-sm-2">Rate</div>
                <div class="col-sm-2">VAT</div>
                <div class="col-sm-2 text-right">Amount</div>
            </div>
        </div>
        <div class="items">
            <?php foreach ($detail->items as $item) : ?>
            <?php
            if($item->is_additional_shipping)  {
                $additional_shipping = $item->net_cost;
            }
            ?>
            <div class="row mr-0 ml-0 item">
                <div class="col-sm-4 ">
                    {{ $item->product_title }} {{--- <span>Show option here</span>--}}
                    {!! $item->paid_deposit ? '<br><small class="text-info">DEPOSIT</small>' : '' !!}
                </div>
                <div class="col-sm-2 ">
                    {{ $item->qty }}
                </div>
                <div class="col-sm-2 ">
                    {{ number_format($item->item_cost,2,'.',',') }}
                </div>
                <div class="col-sm-2 ">
                    {{ $item->vat_percentage }}%
                </div>
                <div class="col-sm-2 text-right">
                    £{{ number_format($item->net_cost,2,'.',',') }}
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="total text-right">
            <p class="extra-notes">
                <strong>Extra Notes</strong>
                {{ $detail->notes }}
            </p>
            <div class="field">
                Subtotal <span>£{{ number_format($detail->net_cost-$additional_shipping,2,'.',',') }}</span>
            </div>
            <?php if($detail->shipping) : ?>
            <div class="field">
                Shipping <span>£{{ number_format($detail->shipping->shipping_cost,2,'.',',') }}</span>
            </div>
            <?php elseif($additional_shipping) : ?>
            <div class="field">
                Shipping <span>£{{ number_format($additional_shipping,2,'.',',') }}</span>
            </div>
            <?php endif; ?>
            <div class="field">
                VAT <span>£{{ number_format($detail->vat_cost,2,'.',',') }}</span>
            </div>
            <!--<div class="field">
                Discount <span>4.5%</span>
            </div>-->
            <div class="field grand-total">
                Total <span>£{{ number_format($detail->gross_cost,2,'.',',') }}</span>
            </div>
        </div>

        <div class="account-details">
            <span><b>To go ahead with this quote please contact us quoting ref #{{$detail->id}}</b></span><br>
            Call : <b>{{ env('SUPPORT_PHONE') }}</b> or Email : <b>info@jenflow.co.uk</b>

            <div class="terms" >
                Terms and conditions attached
            </div>
        </div>

    <!--<div class="print">
            <a href="{{ url('invoices/print/'.$detail->id) }}" target="_blank" class="btn btn-outline-primary">
                <em class="icon ni ni-printer"></em>
                Print this invoice
            </a>
        </div>-->
    </div>
</div>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Treasury</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-size:12px;
            font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .lines {
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .discount-seperator {
            color:#ccc;
        }
        .lines-heading {
            text-align: left;
            background-color: #ededed;
        }

        .lines-heading th {
            padding: 5px 10px;
            border: 1px solid #ccc;
        }

        .lines-body td {
            padding: 5px 10px;
            border: 1px solid #ededed;
        }

        .lines-footer {
            border-top:5px solid #f5f5f5;
            text-align:right;
        }

        .lines-footer td {
            padding: 10px;
            border: 1px solid #ededed;
        }

        .summary {
            margin-bottom: 40px;
        }

        .summary td {
            padding: 5px 10px;
        }

        .info {
            color:#0099e5;
        }

        .summary .total td {
            border-top: 1px solid #ccc;
        }


    </style>
</head>

<body>
    <div class="content">
        <div class="invoice-box">

            <table cellpadding="0" cellspacing="0" width="100%">
                <tr class="top">
                    <td>
                        <table width="100%">
                            <tr>
                                <td class="title" align="left" width="50%">
                                    <img src="{{env('APP_URL')}}/candy-hub/images/logo/treasury.png" width="100px">
                                    <h3>Order Invoice</h3>
                                </td>
                                <td align="right" width="50%">
                                    Invoice: {{ @$order->invoice_reference }} <br>
                                    Tanggal Dibuat: {{ $order->created_at }}<br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td align="left" width="33%">
                                    <h3>Pembayaran</h3>
                                    Metode Pembayaran: {{ $order['meta']['payment_data']['payment']['name']}}<br/>
                                    Trans ID : {{ $order['meta']['payment_data']['trans_id']}}<br/>
                                    Status : {{ $order['meta']['payment_data']['status']}}<br/>
                                    <img src="{{$order['meta']['payment_data']['payment']['photo']}}" width="100px"/>
                                    {{ $order->billing_firstname }} {{ @$order->billing_lastname }}<br>
                                    {{ $order->billing_address }}
                                    @if ($order->billing_address_two)
                                        {{ $order->billing_address_two }} <br>
                                    @endif
                                    @if ($order->billing_address_three)
                                        {{ $order->billing_address_three }} <br>
                                    @endif
                                    {{ $order->billing_city }}<br>
                                    {{ $order->billing_county }}<br>
                                    {{ $order->billing_state }}<br>
                                    {{ $order->billing_zip }}<br>
                                    {{ $order->billing_country }}<br>
                                    @if($order->vat_no)
                                        <p>Pajak No.: {{ $order->vat_no }}</p>
                                    @endif
                                </td>

                                <td align="left" width="33%">
                                    <h3>Pengiriman</h3>
                                    {{ $order->shipping_firstname }} {{ @$order->shipping_lastname }}<br>
                                    {{ $order->shipping_address }}
                                    @if ($order->shipping_address_two)
                                        {{ $order->shipping_address_two }} <br>
                                    @endif
                                    @if ($order->shipping_address_three)
                                        {{ $order->shipping_address_three }} <br>
                                    @endif
                                    {{ $order->shipping_city }}<br>
                                    {{ $order->shipping_county }}<br>
                                    {{ $order->shipping_state }}<br>
                                    {{ $order->shipping_zip }}<br>
                                    {{ $order->shipping_country }}
                                </td>

                                <td align="right" width="33%">
                                    <strong>{{ $settings['address']['address'] }}</strong><br>
                                    {{ $settings['address']['address_two'] }}<br>
                                    {{ $settings['address']['city'] }}<br>
                                    {{ $settings['address']['state'] }}<br>
                                    {{ $settings['address']['zip'] }}<br>
                                    {{ $settings['address']['country'] }}<br>
                                    @if($settings['tax']['vat_number'])
                                    <p>Pajak No.: {{ $settings['tax']['vat_number'] }}</p>
                                    @endif
                                    @if($settings['contact']['telephone'])
                                    <p>No Telephone: {{ $settings['contact']['telephone'] }}</p>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table cellpadding="0" cellspacing="0" width="600px" class="lines">
                <thead class="lines-heading">
                    <tr width="100%">
                        <th width="18%">
                            Produk
                        </th>
                        <th width="15%">
                            SKU
                        </th>
                        <th width="10%">
                            Qty
                        </th>
                        <th width="12%">
                            Harga Per Unit
                        </th>
                        <th width="15%">
                            Diskon
                        </th>
                        <th width="12%">
                            Rate Pajak
                        </th>
                        <th width="12%">
                            Pajak
                        </th>
                        <th width="12%">
                            Baris Total
                        </th>
                    </tr>
                </thead>
                <tbody class="lines-body">
                    @foreach ($order->basketLines as $item)
                    <tr>
                        <td>
                            {{ $item->description }} <br>
                            <small>{{ $item->option }}</small>

                            @if ($item->variant)
                                <small>
                                    @foreach($item->variant->options as $option)
                                        {{ $option }}@if(!$loop->last), @endif
                                    @endforeach
                                </small>
                            @endif
                        </td>
                        <td>
                            {{ $item->sku }}
                        </td>
                        <td>
                            {{ $item->quantity }}
                        </td>
                        <td>
                            {!! $order->currency == 'IDR' ? 'IDR' : '&euro;' !!}{{ number_format($item->unit_price / 100, 2) }}
                        </td>
                        <td>
                            {!! $order->currency == 'IDR' ? 'IDR' : '&euro;' !!}{{ number_format($item->discount_total / 100, 2) }}
                        </td>
                        <td>Pajak @ {{ $item->tax_rate }}%</td>
                        <td>
                            {!! $order->currency == 'IDR' ? 'IDR' : '&euro;' !!}{{ number_format($item->tax_total / 100, 2) }}
                        </td>
                        <td align="right">
                            {!! $order->currency == 'IDR' ? 'IDR' : '&euro;' !!}{{ number_format($item->line_total / 100, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="lines-footer">
                    @if($order->discounts)
                        @foreach ($order->discounts as $discount)
                            <tr class="discount-row">
                                <td colspan="4">
                                    <strong>{{ $discount->name }}</strong> @if($discount->type == 'percentage') @ {{ $discount->amount }}%@endif Diskon<br>
                                    @if ($discount->coupon)
                                    Kode: <code>{{ $discount->coupon }}</code>
                                    @endif
                                </td>
                                <td>-{{ $order->currency == 'IDR' ? 'IDR' : '&euro;' }}{{ number_format($discount->total, 2) }}</td>
                            </tr>
                        @endforeach
                    @endif
                    <tr>
                        <td colspan="5"></td>
                        <td colspan="2">
                            <strong>Pengiriman</strong> <br>
                            <small>{{ $order->shipping_method }}</small>
                        </td>
                        <td>{!! $order->currency == 'IDR' ? 'IDR' : '&euro;' !!}{{ number_format($order->delivery_total / 100, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td colspan="2"><strong>Sub Total</strong></td>
                        <td>{!! $order->currency == 'IDR' ? 'IDR' : '&euro;' !!}{{ number_format(($order->sub_total + $order->delivery_total) / 100, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td colspan="2"><strong>Pajak</strong></td>
                        <td>{!! $order->currency == 'IDR' ? 'IDR' : '&euro;' !!}{{ number_format($order->tax_total / 100, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5"></td>
                        <td colspan="2"><strong>Total</strong></td>
                        <td>{!! $order->currency == 'IDR' ? 'IDR' : '&euro;' !!}{{ number_format(($order->order_total) / 100, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            @if($order->notes)
            <p><strong>Catatan</strong><br>
            {{ $order->notes }}</p>
            <br>
            @endif
        </div>
    </div>
</body>
</html>

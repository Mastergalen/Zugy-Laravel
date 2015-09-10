@section('title', 'Review order')
@extends('pages.checkout.partials.template')

@section('css')
    @parent

    <style>
        h4 .step-number {
            display: inline-block;
            width: 25px;
        }

        h4 {
            margin-top: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1>Review order</h1>
    </div>
    @include('pages.checkout.partials.order-step', ['active' => 'review'])
    <div class="alert alert-warning">
        We only sell alcohol to people <b>older than the legal drinking age of 18</b>. Our drivers may ask your for your photo ID to verify your age at delivery. If we are unable to verify your age, we will cancel your order and refund your payment, minus a service charge of 10.00 &euro;.
    </div>
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7">
            <div class="row">
                <div class="col-md-3">
                    <h4><span class="step-number">1</span>Delivery Address</h4>
                </div>
                <div class="col-md-9">
                    <div class="pull-left">
                        <address>
                            {{$shippingAddress->name}}<br>
                            {{$shippingAddress->line_1}}<br>
                            @if($shippingAddress->line_2 != ""){{$shippingAddress->line_2}}<br>@endif
                            {{$shippingAddress->city}}, {{$shippingAddress->postcode}}<br>
                            <i class="fa fa-phone"></i> {{$shippingAddress->phone}}<br>
                            Delivery instructions: {{$shippingAddress->delivery_instructions}}<br>
                        </address>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-default btn-sm" href="{!! localize_url('routes.checkout.address') !!}?change">Change</a>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-3">
                    <h4><span class="step-number">2</span>Payment Method</h4>
                </div>
                <div class="col-md-9">
                    <div class="pull-left">
                        @if($payment['method'] == 'card')
                            <p><i class="fa fa-credit-card"></i> <b>{{ $payment['card']->brand }}</b> ending in {{ $payment['card']->last4 }}</p>
                        @endif
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-default btn-sm" href="{!! localize_url('routes.checkout.payment') !!}?change">Change</a>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-3">
                    <h4><span class="step-number">3</span>Review items</h4>
                </div>
                <div class="col-md-9">
                    <h4>Estimated delivery: Between 1-2 hours</h4>
                    @foreach(Cart::content() as $row)
                        <div class="panel panel-default" data-product-id="{{$row->id}}" data-row-id="{{$row->rowid}}">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="cart-product-thumb">
                                            <a href="{!! $row->product->getUrl() !!}"><img
                                                        src="{!! $row->product->images()->first()->url !!}"
                                                        alt="{{ $row->name }}"></a>
                                        </div>
                                    </div>
                                    <div class="col-xs-9">
                                        <div class="cart-description">
                                            <h4><a href="{!! $row->product->getUrl() !!}">{{ $row->name }}</a></h4>

                                            <div class="price">{{ money_format("%i", $row->price) }}&euro;</div>

                                            <p><b>Quantity: </b>{!! $row->qty !!}</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <hr class="visible-xs"/>
        <div class="col-lg-3 col-md-3 col-sm-5">
            <div class="box" style="margin-bottom: 10px">
                <table id="order-summary" class="table">
                    <tr>
                        <td>Items</td>
                        <td class="price">{!! money_format("%i", Cart::total()) !!}&euro;</td>
                    </tr>
                    <tr>
                        <td>Shipping</td>
                        <td class="price">
                            @if($shipping == 0)
                                <span style="color: #8BB418;">Free shipping</span>
                                @else
                                {!! money_format("%i", $shipping) !!}&euro;
                            @endif
                        </td>
                    </tr>
                    <tr class="total">
                        <td>Order Total</td>
                        <td class="price">{!! money_format("%i", Cart::total() + $shipping) !!}&euro;</td>
                    </tr>
                    <tr><td colspan="2" style="border: 0">Order totals include <a role="button" id="vat-expand">VAT</a></td></tr>
                </table>
            </div>
            <a href="{!! localize_url('routes.checkout.landing') !!}" class="btn btn-block btn-lg btn-success">
                @if(session('checkout.method') == 'paypal')
                    Proceed to <i class="fa fa-paypal"></i> PayPal <i class="fa fa-arrow-right"></i>
                @else
                    <i class="fa fa-check-square"></i> Place order
                @endif
            </a>
            <small>By placing your order you agree to {!! config('site.name') !!}'s Privacy Policy and Terms and Conditions.</small><!--TODO Fix links-->

        </div>
        </div>
    </div>

    <div id="vat-popover-template" style="display:none">
        <table class="table">
            <tr>
                <td>Total before VAT</td>
                <td class="price">{!! money_format("%i", $vat['before_vat'])  !!}&euro;</td>
            </tr>
            <tr>
                <td>VAT</td>
                <td class="price">{!! money_format("%i", $vat['vat']) !!}&euro;</td>
            </tr>
            <tr class="total">
                <td>Order Total</td>
                <td class="price">{!! money_format("%i", Cart::total() + $shipping) !!}&euro;</td>
            </tr>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#vat-expand').popover({
                html: true,
                title: 'VAT Summary',
                placement: 'bottom',
                content: $('#vat-popover-template').html()
            })
        });
    </script>
@endsection
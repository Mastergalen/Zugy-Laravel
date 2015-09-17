@extends('pages.checkout.partials.template')

@section('content')
    <div class="page-header">
        <h1><i class="fa fa-shopping-cart"></i> Checkout</h1>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7">
            <form action="{!! request()->url() !!}" method="POST" id="guest-checkout-form">
                {!! Form::token() !!}
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input type="text" class="form-control" name="email" placeholder="Email" required>
                </div>

                <div class="panel-group" role="tablist" id="accordion">
                    <!-- Address-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="#address" role="button" data-toggle="collapse" data-parent="#accordion">
                                    <i class="fa fa-truck"></i> Address
                                </a>
                            </h4>
                        </div>
                        <div id="address" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <legend>Delivery Address</legend>
                                @include('pages.checkout.partials.address-form', ['type' => 'delivery'])

                                <legend>Billing Address</legend>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label for="billing-same">
                                            <input type="checkbox" name="delivery[billing_same]" id="billing-same" checked>
                                            Same as delivery address
                                        </label>
                                    </div>
                                </div>
                                @include('pages.checkout.partials.address-form', ['type' => 'billing'])
                            </div>
                        </div>
                    </div><!-- Address /-->

                    <!-- Payment -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="#payment" role="button" data-toggle="collapse" data-parent="#accordion">
                                    <i class="fa fa-credit-card"></i> Payment Method
                                </a>
                            </h4>
                        </div>
                        <div id="payment" class="panel-collapse collapse">
                            <div class="panel-body">
                                <p>Pay with PayPal or Card</p>
                                <div id="braintree"></div>
                                <input type="hidden" name="payment_method_nonce">
                            </div>
                        </div>
                    </div><!-- Payment /

                    <!-- Review -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a href="#review" role="button" data-toggle="collapse" data-parent="#accordion">
                                    <i class="fa fa-shopping-cart"></i> Review items
                                </a>
                            </h4>
                        </div>
                        <div id="review" class="panel-collapse collapse">
                            <div class="panel-body">
                                @include('pages.checkout.partials.review-items') <!--TODO Able to change quantity and delete without having to go back -->
                            </div>
                        </div>
                    </div><!-- Review /-->
                </div>
            </form>
        </div><!--column /-->
        <div class="col-lg-3 col-md-3 col-sm-5">
            @include('includes.order-summary',  ['total' => Cart::total(), 'shipping' => Cart::shipping(), 'grandTotal' => Cart::grandTotal()])
        </div>
    </div>

    @include('includes.vat-popover', ['vat' => Cart::vat(), 'grandTotal' => Cart::grandTotal()])

@endsection

        @section('scripts')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.1/js/formValidation.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.1/js/framework/bootstrap.js"></script>
            <script src="https://js.braintreegateway.com/v2/braintree.js"></script>
            <script>
                $(document).ready(function() {

                    $('#vat-expand').popover({
                        html: true,
                        title: 'VAT Summary',
                        placement: 'bottom',
                        content: $('#vat-popover-template').html()
                    })

                    /* Payment method */
                    braintree.setup('{!! \Braintree_ClientToken::generate() !!}', "dropin", {
                        container: "braintree",
                        onPaymentMethodReceived: function(obj) {
                            console.log('Payment method received');
                            $('#guest-checkout-form input[name="payment_method_nonce"]').val(obj.nonce);
                        }
                    });

                    $('#billing-same').click(function () {
                        $('#billing-address').toggle('slow');
                    });

                    $('#guest-checkout-form').formValidation({
                        framework: 'bootstrap',
                        fields: {
                            'name': {
                                selector: '.inputName',
                                validators: {
                                    notEmpty: {},
                                    stringLength: {
                                        max: 64,
                                    }
                                }
                            },
                            'line_1': {
                                selector: '.inputLine1',
                                validators: {
                                    notEmpty: {},
                                    stringLength: {
                                        max: 64,
                                    }
                                }
                            },
                            'line_2': {
                                selector: '.inputLine2',
                                validators: {
                                    stringLength: {
                                        max: 64,
                                    }
                                }
                            },
                            'delivery[postcode]': {
                                validators: {
                                    notEmpty: {},
                                    stringLength: {
                                        min: 2,
                                        max: 10,
                                    },
                                    zipCode: {
                                        country: 'IT'
                                    }
                                }
                            },
                            'city': {
                                selector: '.inputCity',
                                validators: {
                                    notEmpty: {},
                                    stringLength: {
                                        max: 64,
                                    }
                                }
                            },
                            'delivery[delivery_instructions]': {
                                validators: {
                                    stringLength: {
                                        max: 1000,
                                    }
                                }
                            },
                            'delivery[phone]': {
                                validators: {
                                    notEmpty: {},
                                    stringLength: {
                                        min: 5,
                                        max: 32,
                                    }
                                }
                            },
                            'billing[postalcode]': {
                                validators: {
                                    notEmpty: {},
                                    stringLength: {
                                        max:10
                                    }
                                }
                            },
                        }
                    });
                });


            </script>
@endsection
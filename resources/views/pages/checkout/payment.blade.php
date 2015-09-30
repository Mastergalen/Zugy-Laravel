@section('title', 'Select payment method')
@extends('pages.checkout.partials.template')

@section('css')
    @parent
    <style>
        .credit-card-box .panel-title {
            display: inline;
            font-weight: bold;
        }

        .credit-card-box .display-table {
            display: table;
            width: 100%
        }
        .credit-card-box .display-tr {
            display: table-row;
        }
        .credit-card-box .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 50%;
        }

        #card {
            padding-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1>Select payment method</h1>
    </div>
    @include('pages.checkout.partials.order-step', ['active' => 'payment'])
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="panel-group" id="payment-methods">
        <div class="panel panel-default credit-card-box">
            <div class="panel-heading display-table">
                <div class="row display-tr panel-title">
                    <a role="button" class="display-td" data-toggle="collapse" data-parent="#payment-methods"
                       href="#braintree-panel">
                        <h4 class="">
                            <i class="fa fa-credit-card"></i> Card or <i class="fa fa-paypal"></i> PayPal
                        </h4>
                    </a>
                    <div class="payment-method-img display-td">
                        <div class="pull-right">
                            <img src="/img/payment/master_card.png"
                                 alt="Master Card">
                            <img src="/img/payment/visa_card.png" alt="Visa">
                            <img src="/img/payment/american_express_card.png"
                                 alt="American Express">
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <div id="braintree-panel" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body">
                    <p>Pay with PayPal or Card</p>
                    <form action="{!! request()->url() !!}" method="POST" id="braintree-form">
                        {!! Form::token() !!}
                        <div id="braintree"></div>
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Proceed <i class="fa fa-right"></i></button>
                        <input type="hidden" name="method" value="braintree">
                        <input type="hidden" name="payment_method_nonce">
                        <!-- Add a set as default payment method -->
                    </form>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#payment-methods" href="#cash">
                        <i class="fa fa-money"></i> Cash
                    </a>
                </h4>
            </div>
            <div id="cash" class="panel-collapse collapse" role="tabpanel">
                <div class="panel-body">
                    <p>Pay with cash on delivery</p>
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Pay with cash</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://js.braintreegateway.com/v2/braintree.js"></script>
    <script>
        jQuery(function($) {
            braintree.setup('{!! $braintreeToken !!}', "dropin", {
                container: "braintree",
                onPaymentMethodReceived: function(obj) {
                    console.log('Method received');
                    var $braintreeForm = $('#braintree-form');
                    $braintreeForm.find('input[name="payment_method_nonce"]').val(obj.nonce);
                    $braintreeForm.submit();
                }
            });
        });
    </script>
@endsection
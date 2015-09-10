@section('title', 'Select payment method')
@extends('pages.checkout.partials.template')

@section('css')
    @parent
    <style>
        #credit-card-box .panel-title {
            display: inline;
            font-weight: bold;
        }

        #credit-card-box .display-table {
            display: table;
            width: 100%
        }
        #credit-card-box .display-tr {
            display: table-row;
        }
        #credit-card-box .display-td {
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
        <div class="panel panel-default" id="credit-card-box">
            <div class="panel-heading display-table">
                <div class="row display-tr panel-title">
                    <a role="button" class="display-td" data-toggle="collapse" data-parent="#payment-methods"
                                            href="#card">
                        <h4 class="">
                            <i class="fa fa-credit-card"></i> Card
                        </h4>
                    </a>

                    <div class="payment-method-img display-td">
                        <div class="pull-right">
                            <img class="" src="/img/payment/master_card.png"
                                                      alt="Master Card">
                            <img class="" src="/img/payment/visa_card.png" alt="Visa">
                            <img class="" src="/img/payment/american_express_card.png"
                                 alt="American Express">
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <div id="card" class="panel-collapse collapse in" role="tabpanel">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-offset-4 col-md-4">
                            <form action="{!! request()->url() !!}" method="POST" id="stripe-form" class="form">
                                {!! Form::token() !!}
                                <input type="hidden" name="method" value="card">
                                <span class="payment-errors text-danger"></span>
                                <div class="form-group">
                                    <label>Card Number</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="card-brand">
                                            <i class="fa fa-credit-card"></i>
                                        </span>
                                        <input type="tel" size="20" class="form-control" id="card-number" autocomplete="cc-number" data-stripe="number"/>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-7 col-md-7">
                                        <div class="form-group">
                                            <label>CVC</label>
                                            <input type="tel" size="4" class="form-control" placeholder="CVC"
                                                   id="card-cvc" autocomplete="off" data-stripe="cvc"/>
                                        </div>
                                    </div>

                                    <div class="col-xs-5 col-md-5 pull-right">
                                        <div class="form-group">
                                            <label>Expiration (MM/YY)</label>
                                            <input type="tel" size="2" id="card-exp" class="form-control" placeholder="MM / YY"
                                                   data-stripe="exp-month"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label for="default">
                                            <input type="checkbox" name="defaultPayment" value="true" checked> Set this as the default payment method
                                        </label>
                                    </div>
                                </div>

                                <button class="btn btn-primary btn-lg btn-block" type="submit">Use credit card</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#payment-methods" href="#paypal">
                        <i class="fa fa-paypal"></i> Paypal
                    </a>
                </h4>
            </div>
            <div id="paypal" class="panel-collapse collapse" role="tabpanel">
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.1/js/formValidation.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.1/js/framework/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.3.2/jquery.payment.min.js"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        Stripe.setPublishableKey('{!! env('STRIPE_PUBLIC') !!}');

        jQuery(function($) {
            $stripeForm = $('#stripe-form')

            $('#card-number').payment('formatCardNumber')
            $('#card-cvc').payment('formatCardCVC')
            $('#card-exp').payment('formatCardExpiry')

            $.fn.toggleInputError = function(erred) {
                this.closest('.form-group').toggleClass('has-error', erred);
                return this;
            };

            $stripeForm.find('#card-number').keyup(function() {
                var cardType = $.payment.cardType($('#card-number').val());

                if(cardType != null) {
                    $stripeForm.find('#card-brand').html($('<i>').attr('class', 'fa fa-cc-' + cardType));
                } else {
                    $stripeForm.find('#card-brand').html($('<i>').attr('class', 'fa fa-credit-card'));
                }
            });

            $('#card-number').keyup(validateNumber);
            $('#card-exp').keyup(validateExp);
            $('#card-cvc').keyup(validateCvc);

            $stripeForm.submit(function(e) {
                e.preventDefault();

                var $form = $(this);

                // Disable the submit button to prevent repeated clicks
                $form.find('button').prop('disabled', true);

                validateNumber();
                validateExp();
                validateCvc();

                if($form.find('.has-error').length > 0) {
                    $form.find('button').prop('disabled', false);
                    return false;
                }

                Stripe.card.createToken({
                    number: $('#card-number').val(),
                    cvc: $('#card-cvc').val(),
                    exp_month: $('#card-exp').payment('cardExpiryVal').month,
                    exp_year: $('#card-exp').payment('cardExpiryVal').year
                }, stripeResponseHandler);
            });
        });

        function validateNumber() {
            console.log('validateNumber');
            $('#card-number').toggleInputError(!$.payment.validateCardNumber($('#card-number').val()));
        }

        function validateExp() {
            $('#card-exp').toggleInputError(!$.payment.validateCardExpiry($('#card-exp').payment('cardExpiryVal')));
        }

        function validateCvc() {
            var cardType = $.payment.cardType($('#card-number').val());
            $('#card-cvc').toggleInputError(!$.payment.validateCardCVC($('#card-cvc').val(), cardType));
        }

        function stripeResponseHandler(status, response) {
            var $form = $('#stripe-form');

            if (response.error) {
                // Show the errors on the form
                $form.find('.payment-errors').text(response.error.message);
                $form.find('button').prop('disabled', false);
            } else {
                // response contains id and card, which contains additional card details
                var token = response.id;
                // Insert the token into the form so it gets submitted to the server
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                // and submit
                $form.get(0).submit();
            }
        }

    </script>
@endsection
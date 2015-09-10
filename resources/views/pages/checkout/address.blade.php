@extends('pages.checkout.partials.template')

@section('content')
    <div class="page-header">
        <h1><i class="fa fa-shopping-cart"></i> Checkout</h1>
    </div>

    @include('pages.checkout.partials.order-step', ['active' => 'address'])

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{!! request()->url() !!}" method="POST" id="address-form">
        {!! Form::token() !!}
        <legend>Delivery Address</legend>
        @include('pages.checkout.partials.address-form', ['type' => 'delivery'])

        <legend>Billing Address</legend>
        <div class="form-group">
            <div class="checkbox">
                <label for="billing-same">
                    <input type="checkbox" name="delivery[billing_same]" id="billing-same" checked> Same as delivery address
                </label>
            </div>
        </div>
        @include('pages.checkout.partials.address-form', ['type' => 'billing'])
        <div class="form-footer">
            <div class="pull-left"> <a class="btn btn-footer" href="{!! Localization::getURLFromRouteNameTranslated(Localization::getCurrentLocale(), 'routes.shop') !!}"> <i class="fa fa-arrow-left"></i> &nbsp; Back to Shop </a> </div>
            <div class="pull-right"> <button class="btn btn-primary" type="submit">Select payment method &nbsp; <i class="fa fa-arrow-circle-right"></i> </button> </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.1/js/formValidation.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.1/js/framework/bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            $('#billing-same').click(function () {
                $('#billing-address').toggle('slow');
            });

            $('#address-form').formValidation({
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
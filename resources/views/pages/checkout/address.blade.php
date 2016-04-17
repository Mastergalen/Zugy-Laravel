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

    <div class="row">
        <div class="col-lg-9 col-md-9   col-sm-7">
            @if(count($addresses) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            {!! trans('checkout.address.choose-delivery') !!}
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            @foreach($addresses as $a)
                                <form action="{!! request()->url() !!}" method="POST">
                                    {!! Form::token() !!}
                                    <div class="col-md-3">
                                        <input type="hidden" name=delivery[addressId]" value="{!! $a->id !!}">
                                        @include('includes._address', ['address' => $a, 'edit' => true])
                                        <button class="btn btn-primary btn-block"><i class="fa fa-truck"></i> {!! trans('checkout.address.select-delivery') !!}</button>
                                    </div>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <p><a href="#" id="btn-add-address">{!! trans('checkout.address.deliver-new') !!} <i class="fa fa-caret-right"></i></a></p>

                        <p><span class="small">{!! trans('checkout.address.deliver-new-desc') !!}</span></p>
                    </div>
                </div>
            @endif

            <form action="{!! request()->url() !!}" method="POST" id="address-form" @if(count($addresses) > 0)style="display: none"@endif>
                {!! Form::token() !!}
                <legend>{!! trans('checkout.address.form.delivery') !!}</legend>
                @include('pages.checkout.partials.address-form', ['type' => 'delivery'])

                <legend>{!! trans('checkout.address.form.billing') !!}</legend>
                <div class="form-group">
                    <div class="checkbox">
                        <label for="billing-same">
                            <input type="checkbox" name="delivery[billing_same]" id="billing-same" checked> {!! trans('checkout.address.form.same') !!}
                        </label>
                    </div>
                </div>
                @include('pages.checkout.partials.address-form', ['type' => 'billing'])
                <div class="form-footer">
                    <div class="pull-left">
                        <a class="btn btn-footer" href="{!! localize_url('routes.shop.index') !!}">
                            <i class="fa fa-arrow-left"></i> &nbsp; {!! trans('buttons.back-to-shop') !!}
                        </a>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-arrow-right"></i> {!! trans('buttons.proceed') !!}</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-5">
            @include('includes.order-summary',  [
                'total' => Cart::total(),
                'shipping' => Cart::shipping(),
                'grandTotal' => Cart::grandTotal(),
                'couponDeduction' => Cart::couponDeduction()
            ])
        </div>
    </div>

    @include('pages.checkout.partials.address-modal')
@endsection

@section('scripts')
    <script src="{{ elixir('dist/js/formvalidation.js') }}"></script>
    <script>
        $(document).on('ready pjax:success', function() {
            $('#billing-same').click(function () {
                $('#billing-address').toggle('slow');
            });

            $('#btn-add-address').click(function() {
                $('#address-form').show('slow');
            });

            /*
             * Edit address modal
             */

            var $modal = $('#edit-address-modal');

            $('.btn-edit-address').click(function() {
                var data = $(this).data('address');
                $modal.modal();

                $modal.find('input[name=addressId]').val(data.id);
                $modal.find('input[name=name]').val(data.name);
                $modal.find('input[name=line_1]').val(data.line_1);
                $modal.find('input[name=line_2]').val(data.line_2);
                $modal.find('input[name=postcode]').val(data.postcode);
                $modal.find('input[name=city]').val(data.city);
                $modal.find('textarea[name=delivery_instructions]').val(data.delivery_instructions);
                $modal.find('input[name=phone]').val(data.phone);
            });

            /*
             * Delete address button
             */
            $modal.find('.btn-delete').click(function() {
               swal({
                   title: 'Are you sure you want to remove this address?',
                   showCancelButton: true,
                   type: 'warning',
               }, function() {
                   var addressId = $modal.find('input[name=addressId]').val();

                   console.log("Deleting", addressId);

                   address.delete(addressId).success(function() {
                       swal({
                           title: 'Address deleted',
                           timer: 1000,
                           type: 'success',
                       });
                       $.pjax.reload('#container', {timeout: 1500});
                   });
               });
            });

            $modal.find('form').submit(function (e) {
                e.preventDefault();

                var $btn = $(this).find("input[type=submit]:focus" );
                $btn.prop('disabled', true);

                var addressId = $(this).find('input[name=addressId]').val();
                var addressForm = $(this).serializeArray();
                addressForm.default = true;

                address.update(addressId, addressForm).done(function() {
                    $btn.prop('disabled', false);
                }).success(function() {
                    $modal.modal('hide');
                    $.pjax.reload('#container', {timeout: 1500});
                });
            });

            $('#address-form').formValidation({
                locale: $('meta[name="og:locale"]').attr('content'),
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
                                max: 10
                            },
                            zipCode: {
                                country: 'IT'
                            },
                            remote: {
                                type: 'GET',
                                url: function(validator) {
                                    console.log(validator);
                                    return "{!! action('API\PostcodeController@checkPostcode', ['postcode' => '']) !!}/" + $('input[name="delivery[postcode]"]').val()
                                },
                                validKey: 'delivery'
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
                    }
                }
            });
        });
    </script>
@endsection
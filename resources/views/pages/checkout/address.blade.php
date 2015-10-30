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

    @if(count($addresses) > 0)
        <form action="{!! request()->url() !!}" method="POST">
            {!! Form::token() !!}
            <legend>Choose a delivery address</legend>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                        Choose a delivery address
                    </div>
                </div>
                <div class="panel-body">
                    @foreach($addresses as $a)
                        <div class="radio">
                            <label>
                                <input type="radio" name=delivery[addressId]" value="{!! $a->id !!}">
                                <b>{{$a->name}}</b> {{$a->line_1}}@if(isset($a->line_2)), {{$a->line_2}}@endif, {{$a->city}}, {{$a->postcode}}
                                <b><a href="#" class="btn-edit-address" data-address='{{$a}}'>Edit</a></b>
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary">Use this address</button>
                </div>
            </div>
        </form>

        <div class="panel panel-default">
            <div class="panel-body">
                <p><a href="#" id="btn-add-address">Deliver to a new address <i class="fa fa-caret-right"></i></a></p>

                <p><span class="small">Add a new delivery address to your address book.</span></p>
            </div>
        </div>
    @endif

    <form action="{!! request()->url() !!}" method="POST" id="address-form" @if(count($addresses) > 0)style="display: none"@endif>
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
            <div class="pull-left"> <a class="btn btn-footer" href="{!! localize_url('routes.shop.index') !!}"> <i class="fa fa-arrow-left"></i> &nbsp; Back to Shop </a> </div>
            <div class="pull-right">
                <button class="btn btn-primary btn-footer" type="submit"><i class="fa fa-plus"></i> Add new address</button>
            </div>
        </div>
    {!! Form::close() !!}

    @include('pages.checkout.partials.address-modal')
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.1/js/formValidation.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.1/js/framework/bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            $('#billing-same').click(function () {
                $('#billing-address').toggle('slow');
            });

            $('#btn-add-address').click(function() {
                $('#address-form').show('slow');
            });

            /*
             * Edit address modal
             */
            $('.btn-edit-address').click(function() {
                var $modal = $('#edit-address-modal');
                var data = $(this).data('address');
                $modal.modal();

                $modal.find('input[name=addressId]').val(data.id);
                $modal.find('input[name=name]').val(data.name);
                $modal.find('input[name=line_1]').val(data.line_1);
                $modal.find('input[name=line_2]').val(data.line_2);
                $modal.find('input[name=postcode]').val(data.postcode);
                $modal.find('input[name=city]').val(data.city);
                $modal.find('input[name=delivery_instructions]').val(data.delivery_instructions);
                $modal.find('input[name=phone]').val(data.phone);

            });

            $('#edit-address-modal').find('form').submit(function (e) {
                e.preventDefault();

                var addressId = $(this).find('input[name=addressId]').val();

                console.log($(this).serialize());

                $.ajax({
                    url: "{!! action('API\AddressController@index') !!}/" + addressId,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'PUT',
                    data: $(this).serialize(),
                    success: function() {
                        $(this).modal('hide');
                        alert("Updated address successfully"); //TODO Use awesome alerts
                    }
                });

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
@section('title', trans('checkout.review.title'))
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
        <h1>{!! trans('checkout.review.title') !!}</h1>
    </div>
    @include('pages.checkout.partials.order-step', ['active' => 'review'])
    @include('pages.checkout.partials.age-warning')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7">
            <div class="row">
                <div class="col-md-3">
                    <h4><span class="step-number">1</span>{!! trans('checkout.address.form.delivery') !!}</h4>
                </div>
                <div class="col-md-9">
                    <div class="pull-left">
                        @include('includes._address', ['address' => $shippingAddress])
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-default btn-sm" href="{!! localize_url('routes.checkout.address') !!}?change">{!! trans('buttons.change') !!}</a>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-3">
                    <h4><span class="step-number">2</span>{!! trans('checkout.payment.title') !!}</h4>
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                @include('includes.payment-method', ['payment' => $payment])
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-default btn-sm"
                                   href="{!! localize_url('routes.checkout.payment') !!}?change">{!! trans('buttons.change') !!}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-3">
                    <h4><span class="step-number">3</span>{!! trans('checkout.review.delivery-time') !!}</h4>
                </div>
                <div class="col-md-9">
                    @include('pages.checkout.partials._delivery-time-selector', ['days' => 8])
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-3">
                    <h4><span class="step-number">4</span>{!! trans('checkout.review.coupon') !!}</h4>
                </div>
                <div class="col-md-9">
                    @if(isset($coupon) && $coupon !== null)
                        <div class="alert alert-success">
                            <p>{!! trans('coupon.using', ['code' => $coupon->code]) !!}</p>
                            <p>{!! $coupon->description !!}</p>
                        </div>
                    @endif
                    <div class="form-group">
                        <label>{!! trans('checkout.review.coupon.desc') !!}</label>
                        <form id="form-coupon">
                            <div class="input-group">
                                {!! Form::text('coupon', Input::old('coupon'), ['class' => 'form-control', 'placeholder' => trans('checkout.review.coupon.placeholder')]) !!}
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default">{!! trans('buttons.apply') !!}</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-3">
                    <h4><span class="step-number">5</span>{!! trans('checkout.review.items') !!}</h4>
                </div>
                <div class="col-md-9">
                    @include('pages.checkout.partials.review-items')
                </div>
            </div>
        </div>
        <hr class="visible-xs"/>
        <div class="col-lg-3 col-md-3 col-sm-5">
            @include('includes.order-summary',  [
                'total' => Cart::total(),
                'shipping' => Cart::shipping(),
                'grandTotal' => Cart::grandTotal(),
                'couponDeduction' => Cart::couponDeduction()
            ])
            <form action="{!! localize_url('routes.checkout.review') !!}" method="POST">
                {!! Form::token() !!}
                {!! Form::hidden('delivery_date', Input::old('delivery_date', 'asap'), ['id' => 'delivery_date-hidden']) !!}
                {!! Form::hidden('delivery_time', Input::old('delivery_date'), ['id' => 'delivery_time-hidden']) !!}
                <button class="btn btn-block btn-lg btn-success" type="submit">
                    @if($payment['method'] == 'paypal')
                        <i class="fa fa-check-square"></i> {!! trans('checkout.payment.form.pay-with', ['name' => 'PayPal']) !!}
                    @else
                        <i class="fa fa-check-square"></i> {!! trans('checkout.review.place-order') !!}
                    @endif
                </button>

            </form>
            <small>
                {!! trans('checkout.review.accept', [
                    'siteName' => config('site.name'),
                    'privacyPolicyUrl' => localize_url('routes.privacy-policy'),
                    'termsAndConditionsUrl' => localize_url('routes.terms-and-conditions'),
                ]) !!}
            </small>

        </div>
    </div>

    @include('includes.vat-popover', ['vat' => Cart::vat(), 'grandTotal' => Cart::grandTotal()])

@endsection

@section('scripts')
    <script>
        $(document).on('ready pjax:success', function(){
            $('#vat-expand').popover({
                html: true,
                title: 'VAT Summary',
                placement: 'bottom',
                content: $('#vat-popover-template').html()
            });

            $('#form-coupon').submit(function(e) {
                e.preventDefault();

                var code = $(this).find('input[name="coupon"]').val();

                $.ajax({
                    type: 'POST',
                    url: '/api/v1/coupon/apply',
                    data: {
                        coupon: code
                    },
                    success: function(data) {
                        $.pjax.reload('#container');
                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        swal({
                            title: err.message,
                            type: 'error'
                        });
                    }
                });

            });

            $('#delivery_date').change(function() {
                function pad(n, width, z) {
                    z = z || '0';
                    n = n + '';
                    return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
                }

                var date = $(this).val();

                //Sync form input
                $('#delivery_date-hidden').val(date);

                var $timeFormGroup = $('#delivery_time-group');
                var $timeSelector = $timeFormGroup.find('#delivery_time');

                if(date == 'asap') {
                    $timeFormGroup.hide('slow');
                } else {
                    var today = $(this).data('today');

                    $timeSelector.empty();

                    for(var i = 0; i < 24; i++) {
                        var $option = $('<option>');
                        var startTime = new Date(0, 0, 0, i, 0, 0);
                        var endTime = new Date(0, 0, 0, i + 1, 0, 0);

                        var startTimeString = pad(startTime.getHours(), 2) + ":00";
                        var endTimeString = pad(endTime.getHours(), 2) + ":00";

                        if(date == today) {
                            var currentTime = $(this).data('time-now');

                            if(currentTime > startTimeString) continue;
                        }

                        $option.val(startTimeString);
                        $option.html(startTimeString + " - " + endTimeString);
                        $timeSelector.append($option);
                    }

                    syncDeliveryTimeFields();
                    $timeFormGroup.show('slow');
                }
            });

            function syncDeliveryTimeFields() {
                $('#delivery_time-hidden').val($('#delivery_time').val());
            }

            //Sync form fields
            $('#delivery_time').change(syncDeliveryTimeFields);
        });
    </script>
@endsection
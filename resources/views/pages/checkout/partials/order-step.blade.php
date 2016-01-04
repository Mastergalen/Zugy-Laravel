<ul class="order-step">
    <li @if($active == 'address')class="active" @endif>
        <a href="{!! localize_url('routes.checkout.address') !!}">
            <i class="fa fa-map-marker"></i> <span> {!! trans('checkout.address.title') !!}</span>
        </a>
    </li>
    <li @if($active == 'payment')class="active" @endif>
        <a href="{!! localize_url('routes.checkout.payment') !!}">
            <i class="fa fa-money"> </i><span>{!! trans('checkout.payment.title') !!}</span>
        </a>
    </li>
    <li @if($active == 'review')class="active" @endif>
        <a href="{!! localize_url('routes.checkout.review') !!}">
            <i class="fa fa-check-square"> </i><span>{!! trans('checkout.order') !!}</span>
        </a>
    </li>
</ul>
<ul class="order-step">
    <li @if($active == 'address')class="active" @endif> <a href="{!! Localization::getURLFromRouteNameTranslated(Localization::getCurrentLocale(), 'routes.checkout.address') !!}"> <i class="fa fa-map-marker "></i> <span> Address</span> </a> </li>
    <li @if($active == 'payment')class="active" @endif> <a href="{!! Localization::getURLFromRouteNameTranslated(Localization::getCurrentLocale(), 'routes.checkout.payment') !!}"><i class="fa fa-money  "> </i><span>Payment</span> </a> </li>
    <li @if($active == 'review')class="active" @endif> <a href="{!! Localization::getURLFromRouteNameTranslated(Localization::getCurrentLocale(), 'routes.checkout.review') !!}"><i class="fa fa-check-square "> </i><span>Order</span></a> </li>
</ul>
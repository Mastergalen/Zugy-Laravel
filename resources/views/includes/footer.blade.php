<div class="footer-main">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h3>{!! trans('footer.support') !!}</h3>
                <h4><i class="fa fa-phone"></i> {!! config('site.phone') !!}</h4>
                <h4><a href="mailto:{!! config('site.email.support') !!}"><i
                                class="fa fa-envelope"></i> {!! config('site.email.support') !!}</a></h4>
                <h3 style="padding-top: 0px;">{!! trans('opening-times.title-delivery-time') !!}</h3>
                <h4>{!! trans('opening-times.when') !!}</h4>
            </div>
            <div class="col-md-2">
                <h3>{!! trans('footer.information') !!}</h3>
                <ul>
                    <li><a href="{!! localize_url('routes.about-us') !!}">{!! trans('pages.about-us.title') !!}</a></li>
                    <li><a href="{!! localize_url('routes.contact') !!}">{!! trans('pages.contact.title') !!}</a></li>
                    <li><a href="{!! localize_url('routes.team') !!}">{!! trans('pages.team') !!}</a></li>
                    <li>
                        <a href="{!! localize_url('routes.terms-and-conditions') !!}">{!! trans('pages.terms-and-conditions') !!}</a>
                    </li>
                    <li>
                        <a href="{!! localize_url('routes.privacy-policy') !!}">{!! trans('pages.privacy-policy') !!}</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-3">
                <h3>{!! trans('footer.my-account') !!}</h3>
                <ul>
                    <li><a href="{!! localize_url('routes.account.index') !!}">{!! trans('footer.my-account') !!}</a></li>
                    <li><a href="{!! localize_url('routes.account.orders') !!}">{!! trans('footer.my-orders') !!}</a></li>
                    <li>
                        @if(isset($translations))
                            @foreach($translations as $localeCode => $url)
                                @if($localeCode == 'en') <?php $flagCode = 'gb' ?>
                                @else
                                    <?php $flagCode = $localeCode ?>
                                @endif
                                <div class="language-selector" style="display: inline-block">
                                    <a href="{{ $url  }}" hreflang="{{ $localeCode }}"><span class="f32"><i class="flag {{$flagCode}}"></i></span></a>
                                </div>
                            @endforeach
                        @else
                            @foreach(Localization::getSupportedLocales() as $localeCode => $properties)
                                @if($localeCode == 'en') <?php $flagCode = 'gb' ?>
                                @else
                                    <?php $flagCode = $localeCode ?>
                                @endif
                                <div class="language-selector" style="display: inline-block">
                                    <a href="{{Localization::getLocalizedURL($localeCode) }}" hreflang="{{ $localeCode }}"><span class="f32"><i class="flag {{$flagCode}}"></i></span></a>
                                </div>
                            @endforeach
                        @endif
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <h3>{!! trans('footer.stay-in-touch') !!}</h3>

                <form action="//myzugy.us12.list-manage.com/subscribe/post?u=e2c66627a36b26aef58321a7e&amp;id=f5f12357e0"
                      method="POST" target="_blank">
                    <input class="form-control" type="email" name="EMAIL" placeholder="{!! trans('footer.email') !!}"/>
                    <button type="submit" class="btn btn-success btn-block" style="margin-top: 5px"><i
                                class="fa fa-envelope"></i> {!! trans('footer.newsletter-subscribe-btn') !!}
                    </button>
                </form>
                <ul class="social">
                    <li><a href="https://www.facebook.com/zugymilan"> <i class="fa fa-facebook"> &nbsp; </i> </a></li>
                    <li><a href="https://instagram.com/zugy_/"> <i class="fa fa-instagram"> &nbsp; </i> </a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="footer-bottom">
    <div class="container">
        <p class="pull-left">&copy; {!! config('site.name') !!} {!! date("Y") !!}. {!! trans('footer.rights-reserved') !!}</p>
        <div class="pull-right payment-method-img">
            <img class="pull-right" src="/img/payment/master_card.png" alt="Master Card">
            <img class="pull-right" src="/img/payment/visa_card.png" alt="Visa">
            <img class="pull-right" src="/img/payment/american_express_card.png" alt="American Express">
            <img class="pull-right" src="/img/payment/paypal.png" alt="PayPal">
        </div>
    </div>
</div>
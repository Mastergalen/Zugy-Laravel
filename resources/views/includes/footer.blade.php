<div class="footer-main">
    <div class="container">
        <div class="col-md-3">
            <h3>Support</h3>
            <h4><i class="fa fa-phone"></i> (+39) 344-281-6494</h4>
            <h4><a href="mailto:{!! config('site.email.support') !!}"><i class="fa fa-envelope"></i> {!! config('site.email.support') !!}</a></h4>
        </div>
        <div class="col-md-2">
            <h3>Information</h3>
            <ul>
                <li><a href="#">About us</a></li>
                <li><a href="#">Contact us</a></li>
                <li><a href="{!! localize_url('routes.terms-and-conditions') !!}">Terms & Conditions</a></li>
                <li><a href="{!! localize_url('routes.privacy-policy') !!}">Privacy Policy</a></li>
            </ul>
        </div>
        <div class="col-md-3">
            <h3>My account</h3>
            <ul>
                <li><a href="#">My account</a></li>
                <li><a href="#">My orders</a></li>
            </ul>
        </div>
        <div class="col-md-4">
            <h3>Stay in touch</h3>

            <form action="//myzugy.us12.list-manage.com/subscribe/post?u=e2c66627a36b26aef58321a7e&amp;id=f5f12357e0" method="POST" target="_blank">
                <input class="form-control" type="email" name="EMAIL" placeholder="Email"/>
                <button type="submit" class="btn btn-success btn-block" style="margin-top: 5px"><i
                            class="fa fa-envelope"></i> Subscribe
                </button>
            </form>
            <ul class="social">
                <li><a href="https://www.facebook.com/zugymilan"> <i class="fa fa-facebook"> &nbsp; </i> </a></li>
                <li><a href="https://instagram.com/zugy_/"> <i class="fa fa-instagram"> &nbsp; </i> </a></li>
            </ul>
        </div>
    </div>
</div>
<div class="footer-bottom">
    <div class="container">
        <p class="pull-left">&copy; {!! config('site.name') !!} {!! date("Y") !!}. All rights reserved.</p>
        <div class="pull-right payment-method-img">
            <img class="pull-right" src="/img/payment/master_card.png" alt="Master Card">
            <img class="pull-right" src="/img/payment/visa_card.png" alt="Visa">
            <img class="pull-right" src="/img/payment/american_express_card.png" alt="American Express">
            <img class="pull-right" src="/img/payment/paypal.png" alt="PayPal">
        </div>
    </div>
</div>
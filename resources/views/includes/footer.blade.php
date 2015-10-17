<div class="footer-main">
    <div class="container">
        <div class="col-md-3">
            <h3>Support</h3>
            <h4><i class="fa fa-phone"></i> (+39) 344-281-6494</h4>
            <h4><a href="mailto:help@myzugy.com"><i class="fa fa-envelope"></i> help@myzugy.com</a></h4>
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
            <input class="form-control" type="text" placeholder="Email"/>
            <button type="button" class="btn btn-success btn-block" style="margin-top: 5px"><i class="fa fa-envelope"></i> Subscribe</button>
            <ul class="social">
                <li><a href="http://facebook.com"> <i class=" fa fa-facebook"> &nbsp; </i> </a></li>
                <li><a href="http://twitter.com"> <i class="fa fa-twitter"> &nbsp; </i> </a></li>
                <li><a href="https://plus.google.com"> <i class="fa fa-google-plus"> &nbsp; </i> </a></li>
                <li><a href="http://youtube.com"> <i class="fa fa-pinterest"> &nbsp; </i> </a></li>
                <li><a href="http://youtube.com"> <i class="fa fa-youtube"> &nbsp; </i> </a></li>
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
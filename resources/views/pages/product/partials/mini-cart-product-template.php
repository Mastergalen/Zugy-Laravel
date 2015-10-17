<script id="mini-cart-product-row-template" type="text/x-handlebars-template">
    <div class="mini-cart-product row">
        <div class="col-md-offset-3 col-md-6 col-xs-12">
            <div class="row">
                <div class="col-md-2 col-xs-3 mini-cart-product-thumb">
                    <div>
                        <a href="{{url}}">
                            <img src="{{thumbnail}}" alt="img">
                        </a>
                    </div>
                </div>
                <div class="col-md-5 col-xs-4 miniCartDescription">
                    <h4><a href="{{url}}">{{title}}</a></h4>
                    <span class="size"></span>

                    <div class="price"><span>{{price}}&euro;</span></div>
                </div>
                <div class="col-md-1 col-xs-1 miniCartQuantity">x{{quantity}}</div>
                <div class="col-md-2 col-xs-2 miniCartSubtotal"><span>{{subtotal}}&euro;</span></div>
                <div class="col-md-1 col-xs-1 delete"><a> <i class="fa fa-remove"></i> </a></div>
            </div>
        </div>
    </div>
</script>
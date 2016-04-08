@if(isset($category))
    @section('title', trans('product.title.category', ['category' => $category->name]))
@elseif(isset($query))
    @section('title', trans('product.title.search', ['query' => $query]))
@else
    @section('title', trans('product.title.shop'))
@endif

@extends('layouts.default')

@section('content')
    <div class="page-header product-list">
        <h1>
            @if(isset($category))
                {{ $category->name }}
            @elseif(isset($query))
                <i class="fa fa-search"></i> {!! trans('product.search-results', ['query' => $query]) !!}
            @endif
        </h1>
        <p>{{ trans_choice('product.count', $products->count(), ['count' => $products->count()]) }}</p>
    </div>
    <div class="row">
        <div class="col-md-9 col-md-push-3">

            <div class="row">
                <div class="col-md-offset-8 col-md-4">
                    <div class="pull-right">
                        <select id="product-sort" class="form-control">
                            <option value="sales" @if(request('sort') == 'sales' && request('direction') == 'asc') selected @endif>{!! trans('product.sort.popular') !!}</option>
                            <option value="price-high" @if(request('sort') == 'price' && request('direction') == 'desc') selected @endif>{!! trans('product.sort.price.highest') !!}</option>
                            <option value="price-low" @if(request('sort') == 'price' && request('direction') == 'asc') selected @endif>{!! trans('product.sort.price.lowest') !!}</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row product-list">
                @forelse($products as $p)
                    <div class="item col-sm-4 col-lg-4 col-md-4 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <a href="{!! $p->getUrl() !!}">
                                    <img src="{!! $p->cover() !!}" class="img-responsive" alt="{!! $p->title !!}">
                                </a>
                                <h4><a href="{!! $p->getUrl() !!}">{!! $p->title !!}</a></h4>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="price"><a href="{!! $p->getUrl() !!}">{!! $p->price !!}&euro;</a>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <button class="btn btn-primary btn-sm pull-right btn-add-cart" data-product-id="{!! $p->id !!}"><i class="fa fa-cart-arrow-down"></i></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        @if(isset($query))
                            <div class="alert alert-info">
                                {!! trans('product.search.empty', ['query' => $query]) !!}
                            </div>
                        @else
                            <div class="alert alert-info">
                                {!! trans('product.category.empty') !!}
                            </div>
                        @endif
                    </div>
                @endforelse
            </div>
            {!! $products->appends(['sort' => request('sort'), 'direction' => request('direction')])->links() !!}
        </div>
        <div class="col-md-3 col-md-pull-9">
            <div class="panel panel-default">
                <div class="panel-heading">{!! trans('product.category.title') !!}</div>
                <div class="category-list">
                    {!! \App\Category::printList()!!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@if(auth()->guest())
    @include('includes._postcode-check')
@endif
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script>
$(document).on('ready pjax:success', function() {
    //Bind pjax to pagination buttons
    $(document).pjax('.pagination a', '#product-list');

    $('.btn-add-cart').unbind('click').click(function() {
        $(this).prop('disabled', true);
        var productId = $(this).data('product-id');

        var $img = $(this).closest('.panel-body').find('img').eq(0);

        cart.addToCartAnimation($img);

        cart.add(productId, 1).done(function() {
            $(this).prop('disabled', false);
        }.bind(this));
    });

    $('#product-sort').unbind('change').change(function() {
        var query;
        console.log($(this).val());
        switch($(this).val()) {
            case 'sales':
                query = {'sort': 'sales', 'direction': 'desc'};
                break;
            case 'price-high':
                query = {'sort': 'price', 'direction': 'desc'};
                break;
            case 'price-low':
                query = {'sort': 'price', 'direction': 'asc'};
                break;
        }

        var $_GET = getQueryParams(document.location.search);

        if(typeof $_GET.page != 'undefined') {
            query.page = $_GET.page;
        }

        var url = [location.protocol, '//', location.host, location.pathname].join('') + "?" + $.param(query);

        $.pjax({url: url, container: '#product-list'});
    });
});
</script>
@endsection
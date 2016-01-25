@if(isset($category))
    @section('title', 'Shop for ' . $category->name)
@elseif(isset($query))
    @section('title', 'Search results for ' . $query)
@else
    @section('title', 'Shop for Alcohol')
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
            <div class="row product-list">
                <!-- FIXME Add pagination -->
                @forelse($products as $p)
                    <div class="item col-sm-4 col-lg-4 col-md-4 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <a href="{!! $p->getUrl() !!}"><img src="{!! $p->cover() !!}" class="img-responsive"
                                                                    alt=""></a>
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
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script>
$('.btn-add-cart').click(function() {
    $(this).prop('disabled', true);
    var productId = $(this).data('product-id');

    var $img = $(this).closest('.panel-body').find('img').eq(0);

    cart.addToCartAnimation($img);

    cart.add(productId, 1).done(function() {
        $(this).prop('disabled', false);
    }.bind(this));
});
</script>
@endsection
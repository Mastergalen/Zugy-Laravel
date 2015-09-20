@section('title', 'Shop for ' . $category->name)
@section('meta_description', '') <!-- TODO Add meta description for category page-->

@extends('layouts.default')

@section('css')
    <style>
        .category-list>.list-group .list-group-item:first-child {border-top-right-radius: 0;border-top-left-radius: 0;}
        .category-list>.list-group .list-group-item {border-width: 1px 0;}
        .category-list>.list-group {margin-bottom: 0;}
        .category-list .list-group-item {border-radius:0;}

        .category-list .list-group .list-group {margin: 0;margin-top: 10px;}
        .category-list .list-group-item li.list-group-item {margin: 0 -15px;border-top: 1px solid #ddd !important;border-bottom: 0;padding-left: 30px;}
        .category-list .list-group-item li.list-group-item:last-child {padding-bottom: 0;}

        .category-list div.list-group div.list-group{margin: 0;}
        .category-list div.list-group .list-group a.list-group-item {border-top: 1px solid #ddd !important;border-bottom: 0;padding-left: 30px;}
        .category-list .list-group-item li.list-group-item {border-top: 1px solid #DDD !important;}
    </style>
@endsection

@section('content')
    <div class="page-header">
        <h1 style="display: inline">{{ $category->name }}</h1>
        <div class="pull-right">{{ trans_choice('product.count', $products->count(), ['count' => $products->count()]) }}</div>
    </div>
    <div class="row">
        <div class="col-md-9 col-md-push-3">
            @if($products->count() == 0)
                <div class="alert alert-info">
                    No products in this category
                </div>
            @endif
            <div class="row">
                @foreach($products as $p)
                    <div class="item col-sm-4 col-lg-4 col-md-4 col-xs-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <a href="{!! $p->getUrl() !!}"><img src="{!! $p->images()->first()->url !!}" class="img-responsive"
                                                  alt=""></a>
                                <h4><a href="{!! $p->getUrl() !!}">{!! $p->title !!}</a></h4>
                                <div class="price"><a href="{!! $p->getUrl() !!}">{!! $p->price !!}&euro;</a></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-3 col-md-pull-9">
            <div class="panel panel-default">
                <div class="panel-heading">Categories</div>
                <div class="category-list">
                    {!! \App\Category::printList()!!}
                </div>
            </div>
        </div>
    </div>
@endsection
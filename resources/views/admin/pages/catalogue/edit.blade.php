@extends('admin.layouts.default')

@section('title', trans('buttons.edit') . ' ' . $product->title)

@inject('TaxClass', 'App\TaxClass')
@inject('Category', 'App\Category')

@section('header')
    <h1><i class="fa fa-plus"></i> {!! trans('buttons.edit') !!} <a href="{!! $product->getUrl() !!}">{{ $product->title }}</a></h1>
@endsection

@section('breadcrumb')
    <li>
        <a href="/admin/catalogue">{!! trans('admin.catalogue.title') !!}</a>
    </li>
    <li class="active">
        {!! trans('product.edit') !!}
    </li>
@endsection

@include('admin.pages.catalogue.partials._product-form', ['method' => 'PATCH', 'action' => ['Admin\CatalogueController@update', $product->id], 'id' => $product->id])
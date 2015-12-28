@extends('admin.layouts.default')

@section('title', 'Edit ' . $product->title)

@inject('TaxClass', 'App\TaxClass')
@inject('Category', 'App\Category')

@section('header')
    <h1><i class="fa fa-plus"></i> Editing <a href="{!! $product->getUrl() !!}">{{ $product->title }}</a></h1>
@endsection

@section('breadcrumb')
    <li>
        <a href="/admin/catalogue">Catalogue</a>
    </li>
    <li class="active">
        Edit product
    </li>
@endsection

@include('admin.pages.catalogue.partials._product-form', ['method' => 'PATCH', 'action' => ['Admin\CatalogueController@update', $product->id]])

@extends('admin.layouts.default')

@section('title', 'Add a product')

@inject('TaxClass', 'App\TaxClass')
@inject('Category', 'App\Category')

@section('header')
<h1><i class="fa fa-plus"></i> Add a product</h1>
@endsection

@section('breadcrumb')
<li>
    <a href="/admin/catalogue">Catalogue</a>
</li>
<li class="active">
    Add a product
</li>
@endsection

@include('admin.pages.catalogue.partials._product-form', ['method' => 'POST', 'action' => 'Admin\CatalogueController@store'])
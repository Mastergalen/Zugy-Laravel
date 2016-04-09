@extends('admin.layouts.default')

@section('title', trans('product.form.add.label'))

@inject('TaxClass', 'App\TaxClass')
@inject('Category', 'App\Category')

@section('header')
<h1><i class="fa fa-plus"></i> {!! trans('product.form.add.label') !!}</h1>
@endsection

@section('breadcrumb')
<li>
    <a href="/admin/catalogue">{!! trans('admin.catalogue.title') !!}</a>
</li>
<li class="active">
    {!! trans('product.form.add.label') !!}
</li>
@endsection

@include('admin.pages.catalogue.partials._product-form', ['method' => 'POST', 'action' => 'Admin\CatalogueController@store', 'id' => null])
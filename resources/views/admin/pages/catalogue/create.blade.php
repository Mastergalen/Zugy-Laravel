@extends('admin.layouts.default')

@section('title', 'Add a product')

@inject('TaxClass', 'App\TaxClass')

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

@section('css')
    <link href="/css/plugins/summernote/summernote.css" rel="stylesheet">
    <link href="/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">

    <link href="/css/admin/plugins/dropzone/basic.css" rel="stylesheet">
    <link href="/css/admin/plugins/dropzone/dropzone.css" rel="stylesheet">

    <style>
        .dropzone {
            border: 2px dashed #0087F7;
            border-radius: 5px;
            background: white;
            background: rgba(0,0,0,0.03);
        }

        .dropzone .dz-message {
            font-weight: 400;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    @foreach($languages as $l)
                        <li class="@if($l['id'] === 1) active @endif">
                            <a data-toggle="tab" href="#desc-{!! $l['code'] !!}" aria-expanded="true">
                                <span class="f32"><i class="flag {!! $l['flag'] !!}"></i></span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($languages as $l)
                        <div id="desc-{!! $l['code'] !!}" class="tab-pane @if($l['id'] === 1) active @endif">
                            <div class="panel-body">
                                @include('admin.pages.catalogue.partials.product-description')
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-image"></i> Upload images</h3>

                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <form id="my-awesome-dropzone" class="dropzone" action="#">
                        <div class="dz-default dz-message">
                            Drop files here or click to upload.<br>
                        </div>
                    </form>
                </div>
            </div>

            <div class="box box-default">
                <div class="box-body">
                    <legend><i class="fa fa-dollar"></i> Pricing</legend>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="price">Price (incl. tax)</label>

                                <div class="input-group">
                                    <span class="input-group-addon">&euro;</span>
                                    {!! Form::text('price', Input::old('price'), ['class' => 'form-control', 'placeholder' => '0.00']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="compare_price">Compare at price</label>

                                <div class="input-group">
                                    <span class="input-group-addon">&euro;</span>
                                    {!! Form::text('compare_price', Input::old('compare_price'), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tax_class_id">Tax class</label>
                        {!! Form::select('tax_class_id', $TaxClass::lists('title', 'id'), null, ['class' => 'form-control']) !!}
                    </div>

                    <legend><i class="fa fa-archive"></i> Inventory</legend>
                    <div class="form-group">
                        <label for="stock">Set stock quantity</label>
                        {!! Form::text('stock', Input::old('stock'), ['class' => 'form-control']) !!}
                    </div>

                    <legend>Attributes</legend>
                    <div class="row">
                        <p class="help-text">Give the product attributes like volume, alcohol content, etc.</p>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <select name="" class="form-control">
                                    <option value="">Select attribute</option>
                                    <option value="">Volume</option>
                                    <option value="">Alcohol content</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            {!! Form::text('attribute_value', Input::old('attribute_value'), ['class' => 'form-control', 'placeholder' => 'Attribute value']) !!}
                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-default"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="box box-default">
                <div class="box-header">
                    <h5>Organisation</h5>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="category">Product category</label>
                        {!! Form::select('category') !!}
                        {!! Form::text('category', Input::old('category'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary"><i class="fa fa-save"></i> Save product</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/admin/plugins/summernote/summernote.min.js"></script>
    <script src="/js/admin/plugins/dropzone/dropzone.js"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                toolbar: [
                    ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['link', 'hr', 'table']],
                    ['misc', ['fullscreen', 'codeview']],
                    ['help', ['help']]
                ]
            });
        });
    </script>
@endsection


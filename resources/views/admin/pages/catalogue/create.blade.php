@extends('admin.layouts.default')

@section('title', 'Add a product')

@inject('TaxClass', 'App\TaxClass')
@inject('Attributes', 'App\Attribute')
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
    {!! Form::open(['id' => 'create-product-form', 'action' => 'CatalogueController@store']) !!}
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
                        <div class="dropzone-previews dropzone">
                            <div class="dz-default dz-message">
                                Drop files here or click to upload.<br>
                            </div>
                        </div>
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
                                    {!!
                                        Form::select(
                                            'attribute_id',
                                            $Attributes->with(['description' => function ($query) {
                                                $query->where('language_id', '=', auth()->user()->settings()->language);
                                            }])->get()->lists('description.0.name','id'),
                                            null,
                                            ['class' => 'form-control']
                                        )
                                    !!}
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
                            <select name="category_id" class="form-control">
                                {!! $Category->printSelect() !!}
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary"><i class="fa fa-save"></i> Save product</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
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

        Dropzone.options.createProductForm = {
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 100,
            maxFiles: 100,

            // The setting up of the dropzone
            init: function() {
                var myDropzone = this;

                // First change the button to actually tell Dropzone to process the queue.
                this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
                    // Make sure that the form isn't actually being sent.
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });

                // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
                // of the sending event because uploadMultiple is set to true.
                this.on("sendingmultiple", function() {
                    // Gets triggered when the form is actually being sent.
                    // Hide the success button or the complete form.
                });
                this.on("successmultiple", function(files, response) {
                    // Gets triggered when the files have successfully been sent.
                    // Redirect user or notify of success.
                });
                this.on("errormultiple", function(files, response) {
                    // Gets triggered when there was an error sending the files.
                    // Maybe show form again, and notify user of error
                });
            }

        }
    </script>
@endsection


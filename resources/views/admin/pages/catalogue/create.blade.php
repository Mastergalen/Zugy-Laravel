@extends('admin.layouts.default')

@section('title', 'Add a product')

@section('breadcrumb')
    <h2><i class="fa fa-plus"></i> Add a product</h2>
    <ol class="breadcrumb">
        <li>
            <a href="/admin">Home</a>
        </li>
        <li>
            <a href="/admin/catalogue">Catalogue</a>
        </li>
        <li class="active">
            <strong>Add a product</strong>
        </li>
    </ol>
@endsection

@section('content')
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

    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Product description</h5>

                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="form-group">
                                <label for="name">Product name</label>
                                {!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => 'Product name']) !!}
                            </div>
                            <label for="">Description</label>
                        </div>
                        <div class="ibox-content no-padding">
                            <div class="summernote">
                                <h3>Lorem Ipsum is simply</h3>
                                dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been
                                    the industry's</strong> standard dummy text ever since the 1500s,
                                when an unknown printer took a galley of type and scrambled it to make a type
                                specimen book. It has survived not only five centuries, but also the leap into
                                electronic
                                typesetting, remaining essentially unchanged. It was popularised in the 1960s with
                                the release of Letraset sheets containing Lorem Ipsum passages, and more recently
                                with
                                <br/>
                                <br/>
                                <ul>
                                    <li>Remaining essentially unchanged</li>
                                    <li>Make a type specimen book</li>
                                    <li>Unknown printer</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Upload images</h5>

                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form id="my-awesome-dropzone" class="dropzone" action="#">
                                <div class="dz-default dz-message">
                                    Drop files here or click to upload.<br>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5><i class="fa fa-dollar"></i> Pricing</h5>

                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="price">Price</label>

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
                                <label for="tax_class">Tax class</label>
                                <select name="" id="" class="form-control">
                                    <option value="">Select</option>
                                    <option value=""></option>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>

                        <div class="ibox-title">
                            <h5><i class="fa fa-dollar"></i> Inventory</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="form-group">
                                <label for="stock">Set stock quantity</label>
                                {!! Form::text('stock', Input::old('stock'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>SEO</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="form-group">
                                <label for="meta_description">Meta description</label>
                                {!! Form::text('meta_description', Input::old('meta_description'), ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Organisation</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="form-group">
                                <label for="category">Product category</label>
                                {!! Form::text('category', Input::old('category'), ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary"><i class="fa fa-save"></i> Save product</button>
                            </div>
                        </div>
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
            $('.summernote').summernote();
        });
    </script>
@endsection


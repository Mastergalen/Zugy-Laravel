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

<link href="/css/admin/plugins/dropzone/dropzone.css" rel="stylesheet">
<link href="/css/admin/plugins/dropzone/basic.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.1/css/formValidation.min.css">

<style>
    .dropzone {
        border: 2px dashed #0087F7;
        border-radius: 5px;
        background: white;
    }

    .dropzone .dz-message {
        font-size: 2em;
        font-weight: 400;
        color: #646C7F;
    }
</style>
@endsection

@section('content')
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{!! Form::open(['id' => 'create-product-form', 'action' => 'Admin\CatalogueController@store']) !!}
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
                    <div class="form-group">
                        <span class="help-block" id="images-error"></span>
                        <div id="my-dropzone" class="dropzone"></div>
                        {!! Form::checkbox('images[]', '-1', false, ['style' => 'display:none']) !!}
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
                        {!! Form::text('stock', Input::old('stock'), ['class' => 'form-control', 'type' => 'number', 'step' => 1, 'min' => '0', 'required' => 'required']) !!}
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
                        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save product</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.1/js/formValidation.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/formvalidation/0.6.1/js/framework/bootstrap.js"></script>
    <script>
        function slugify(text)
        {
            return text.toString().toLowerCase()
                    .replace(/\s+/g, '-')           // Replace spaces with -
                    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                    .replace(/^-+/, '')             // Trim - from start of text
                    .replace(/-+$/, '');            // Trim - from end of text
        }

        $(document).ready(function() {
            var $form = $('#create-product-form');
            $form.formValidation({
                framework: 'bootstrap',
                excluded: [':disabled'],
                fields: {
                    price: {
                        validators: {
                            notEmpty: {},
                            numeric: {
                                message: 'The price must be a number'
                            },
                            greaterThan: {
                                value: 0
                            }
                        }
                    },
                    'compare_price': {
                        validators: {
                            numeric: {
                                message: 'The price must be a number'
                            },
                            greaterThan: {
                                value: 0
                            }
                        }
                    },
                    'images[]': {
                        excluded: false,
                        err: '#images-error',
                        validators: {
                            choice: {
                                min: 1,
                                message: 'You need to add at least 1 image'
                            },
                        }
                    },
                }
            });

            $('input[name$="[title]"]').keyup(function() {
                var slug = slugify($(this).val());

                var $slug = $(this).parent().next().find('input[name$="[slug]"]')

                $slug.val(slug);

                var slugName = $slug.attr('name');

                $form.formValidation('revalidateField', slugName);
            });

            //Initialise hidden inputs

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
                ],
                onInit: function() {
                    $(this).nextAll('input').val($(this).code());
                },
                onKeyup: function(e) {
                    $(this).nextAll('input').val($(this).code());
                },
            });

            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone('div#my-dropzone', {
                url: "{!! action('Admin\ImageController@upload') !!}",
                parallelUploads: 20,
                maxFiles: 20,
                clickable: true,
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                error: function(file, msg) {
                    console.error(msg);
                },
                success: function(file, resp) {
                    console.log(resp);
                    $checkbox = $('<input type="checkbox" name="images[]" value="' + resp.id + '" style="display:none" checked/>');
                    $dropzone = $('#my-dropzone').after($checkbox);
                    $parent = $dropzone.parent();

                    $options = $parent.find('[name="images[]"]');

                    $form.formValidation('addField', $options)
                            .formValidation('revalidateField', 'images[]');
                }
            });

            myDropzone.on("sending", function(file, xhr, formData) {
                formData.append("_token", $("input[name='_token']").val());
            });
        });
    </script>
@endsection


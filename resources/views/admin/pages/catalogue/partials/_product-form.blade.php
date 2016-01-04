@section('css')
    <link href="/plugins/summernote/summernote.css" rel="stylesheet">

    <link href="/plugins/dropzone/dropzone.css" rel="stylesheet">
    <link href="/plugins/dropzone/basic.css" rel="stylesheet">

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

        .dropzone .dz-preview.selected .dz-image {
            border: 2px solid #FB5E5E;
        }

        .dropzone .dz-preview .dz-image img {
            width: 120px;
            height: 120px;
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

    {!! Form::model($product, ['id' => 'create-product-form', 'method' => $method, 'action' => $action ]) !!}
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
                        <div id="my-dropzone" class="dropzone">
                            @foreach($product->images()->get() as $image)
                                @include('admin.pages.catalogue.partials._dropzone-preview', ['thumbnail_id' => $product->thumbnail_id])
                            @endforeach
                        </div>
                        {!! Form::hidden('thumbnail_id', Input::old('thumbnail_id')) !!}
                        {!! Form::checkbox('images[]', '-1', false, ['style' => 'display:none']) !!}
                        @foreach($product->images()->get() as $image)
                            {!! Form::checkbox('images[]', $image->id, true, ['style' => 'display:none']) !!}
                        @endforeach
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
                        {!! Form::select('tax_class_id', $TaxClass::pluck('title', 'id'), null, ['class' => 'form-control']) !!}
                    </div>

                    <legend><i class="fa fa-archive"></i> Inventory</legend>
                    <div class="form-group">
                        <label for="stock">Set stock quantity</label>
                        {!! Form::text('stock_quantity', Input::old('stock_quantity'), ['class' => 'form-control', 'type' => 'number', 'step' => 1, 'min' => '0', 'required' => 'required']) !!}
                    </div>

                    <legend>Attributes</legend>
                    <div class="form-horizontal" id="attributes-container">
                        <p class="help-text">Give the product attributes like volume, alcohol content, etc.</p>
                        @foreach($attributes as $a)
                            <div class="form-group">
                                <label class="col-sm-4 control-label">{{ $a['name'] }}</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        @if(isset( $productAttributes[$a['id']]))
                                            {!! Form::text("attributes[{$a['id'] }]", Input::old("attributes[{$a['id'] }]", $productAttributes[$a['id']]['pivot']['value']), ['class' => 'form-control']) !!}
                                        @else
                                            {!! Form::text("attributes[{$a['id'] }]", Input::old("attributes[{$a['id'] }]"), ['class' => 'form-control']) !!}
                                        @endif
                                        <span class="input-group-addon">{{ $a['unit'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
                        {!! Form::select('category_id', $Category->printSelect(), Input::old('category_id', $category['id']), ['class' => 'form-control']) !!}
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
    <script src="/plugins/summernote/summernote.min.js"></script>
    <script src="/plugins/dropzone/dropzone.js"></script>
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
                locale: $('meta[name="og:locale"]').attr('content'),
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

            /*
             * Generate slug
             */
            $('input[name$="[title]"]').keyup(function() {
                var slug = slugify($(this).val());

                var $slug = $(this).parent().next().find('input[name$="[slug]"]')

                $slug.val(slug);

                var slugName = $slug.attr('name');

                $form.formValidation('revalidateField', slugName);
            });

            /* Init Editor */
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
            var $myDropzone = $('#my-dropzone').dropzone({
                url: "{!! action('Admin\ImageController@upload') !!}",
                parallelUploads: 20,
                maxFiles: 20,
                clickable: true,
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                error: function(file, msg) {
                    console.error(msg);
                },
                success: function(file, resp) {
                    console.log("Image upload successful");
                    console.log(resp);

                    $checkbox = $('<input type="checkbox" name="images[]" value="' + resp.id + '" style="display:none; " checked/>');
                    $dropzone = $('#my-dropzone').after($checkbox);

                    //Add ID to DOM
                    file.previewElement.setAttribute('data-image-id', resp.id);

                    //Update thumbnail if first image
                    $thumbnailInput = $('input[name=thumbnail_id]');
                    if($thumbnailInput.val() == '') {
                        $thumbnailInput.val(resp.id);

                        $(file.previewElement).addClass('selected');
                    }

                    $parent = $dropzone.parent();

                    $options = $parent.find('[name="images[]"]');

                    $form.formValidation('addField', $options)
                            .formValidation('revalidateField', 'images[]');
                },

                init: function() {
                    this.on("sending", function(file, xhr, formData) {
                        formData.append("_token", $("input[name='_token']").val());
                    });

                    this.on("removedfile", function(file) {
                        console.log(file);
                    });
                }
            });

            $myDropzone.on('click', '.dz-preview', function() {
                $myDropzone.find('.dz-preview').removeClass('selected');

                $(this).addClass('selected');

                var imageId = $(this).data('image-id');
                $('input[name=thumbnail_id]').val(imageId);
            });

            $myDropzone.tooltip({
                selector: '.dz-preview',
                title: 'Set this as thumbnail'
            });

        });
    </script>
@endsection

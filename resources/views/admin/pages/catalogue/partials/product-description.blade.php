<div class="form-group">
    <label for="meta[{!! $l['code'] !!}][title]">{!! trans('product.form.name.label') !!}</label>
    {!! Form::text(
        "meta[{$l['code']}][title]",
        Input::old("meta[{$l['code']}][title]",
        $translations[$l['code']]['title']),
        [
            'class' => 'form-control',
            'placeholder' => trans('product.form.name.label'),
            'minlength' => '3',
            'required' => 'required'
        ]
    )!!}
</div>

<div class="form-group">
    <label for="meta[{!! $l['code'] !!}][slug]">Slug</label>
    <div class="input-group">
        <span class="input-group-addon">{{ env('APP_URL') }}/product/</span>
        {!! Form::text(
            "meta[{$l['code']}][slug]",
            Input::old("meta[{$l['code']}][slug]", $translations[$l['code']]['slug']),
            [
                'class' => 'form-control',
                'placeholder' => 'Slug',
                'minlength' => '3',
                'pattern' => "^[a-z0-9-]+$",
                'data-fv-regexp-message' => trans('forms.error.slug'),
                'required' => 'required'
            ]
        ) !!}
    </div>
</div>

<div class="form-group">
    <label for="">{!! trans('admin.description') !!}</label>
    <div class="summernote">
        @if($translations[$l['code']]['description'])
            {!! $translations[$l['code']]['description'] !!}
        @else
            Lorem ipsum dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been
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
        @endif
    </div>
    {!! Form::hidden("meta[{$l['code']}][description]", Input::old("meta[{$l['code']}][description]", $translations[$l['code']]['description'])) !!}
</div>
<div class="form-group">
    <label for="meta_description">{!! trans('admin.meta_description') !!}</label>
    <span class="help-text">{!! trans('admin.meta_description.desc') !!}</span>
    {!! Form::text(
        "meta[{$l['code']}][meta_description]",
        Input::old("meta[{$l['code']}][meta_description]", $translations[$l['code']]['meta_description']),
        ['class' => 'form-control', 'placeholder' => trans('admin.meta_description'), 'data-minlength' => '10', 'required' => 'required']
    ) !!}
</div>